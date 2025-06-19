<?php

namespace Fiado\Helpers;

use Fiado\Models\Service\ClienteService;
use Fiado\Models\Service\CompraService;
use Fiado\Models\Service\FiadoItemService;
use Fiado\Models\Service\StripeCustomerService;
use Fiado\Models\Service\StripeInvoiceService;
use Stripe\Invoice;
use Stripe\StripeClient;

class StripeWrapper
{
    private static function getInstance(): StripeClient
    {
        return new StripeClient($_SERVER["STRIPE_SECRETKEY"]);
    }

    /**
     * @param $idCliente
     * @param $idFiado
     * @param $daysUntilDue
     */
    public static function createInvoice($idCliente, $idFiado, $daysUntilDue)
    {
        $stripe = self::getInstance();

        $cliente = ClienteService::getClienteById($idCliente);
        $fiado = CompraService::getCompra($idFiado);

        if (!$cliente || !$fiado) {
            return false;
        }

        $fiadoItens = FiadoItemService::listFiadoItem($fiado->getId());

        if (!$fiadoItens) {
            return false;
        }

        if (!$customer = self::getCustomer($cliente->getEmail())) {
            $customerData = [
                'name' => $cliente->getName(),
                'email' => $cliente->getEmail(),
            ];

            $customer = $stripe->customers->create($customerData);

            if (!$customer) {
                return false;
            }

            StripeCustomerService::salvar(null, $customer->id, $cliente->getEmail());
        }

        $invoice = $stripe->invoices->create([
            'customer' => $customer->id,
            'collection_method' => 'send_invoice',
            'days_until_due' => $daysUntilDue,
        ]);

        foreach ($fiadoItens as $item) {
            $stripe->invoiceItems->create([
                'customer' => $customer->id,
                'invoice' => $invoice->id,
                'unit_amount_decimal' => $item->getValue() * 100,
                'quantity' => $item->getQuantity(),
                'currency' => $_SERVER["STRIPE_CURRENCY"],
                'description' => $item->getProduto()->getName(),
            ]);
        }

        $invoice = $stripe->invoices->finalizeInvoice($invoice->id, []);

        return StripeInvoiceService::salvar(null, $fiado->getId(), $invoice->id);
    }

    /**
     * @param $idFiado
     */
    public static function getInvoice($idFiado)
    {
        $invoice = StripeInvoiceService::getInvoice($idFiado);

        if (!$invoice) {
            return false;
        }

        return self::getInstance()->invoices->retrieve($invoice->getIdInvoice());
    }

    /**
     * @param Invoice $invoice
     */
    public static function checkInvoice(#[\SensitiveParameter] Invoice $invoice)
    {
        if ($invoice->paid && $invoice->status === 'paid') {
            $stripeInvoice = StripeInvoiceService::getInvoiceById($invoice->id);
            CompraService::pay($stripeInvoice->getFiado()->getId());
        }
    }

    /**
     * @param $email
     */
    public static function getCustomer($email)
    {
        $customer = StripeCustomerService::getCustomer($email);

        if (!$customer) {
            return false;
        }

        return self::getInstance()->customers->retrieve($customer->getIdCustomer());
    }
}