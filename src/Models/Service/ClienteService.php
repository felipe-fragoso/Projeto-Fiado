<?php

namespace Fiado\Models\Service;

use Fiado\Helpers\Flash;
use Fiado\Helpers\Mailer;
use Fiado\Helpers\ParamData;
use Fiado\Helpers\ParamItem;
use Fiado\Models\Dao\ClienteDao;
use Fiado\Models\Entity\Cliente;
use Fiado\Models\Validation\ClienteValidate;

class ClienteService
{
    /**
     * @var ClienteDao
     */
    private static $dao;

    public static function getDao()
    {
        if (!isset(self::$dao)) {
            self::$dao = new ClienteDao();
        }

        return self::$dao;
    }

    /**
     * @param array $arr
     */
    private static function getClienteObj(array $arr)
    {
        return new Cliente($arr['id'], $arr['cpf'], $arr['name'], $arr['email'], $arr['senha'], $arr['date']);
    }

    /**
     * @param int $id
     */
    public static function getClienteById(int $id)
    {
        $arr = self::getDao()->getClienteById(new ParamData(new ParamItem('id', $id)));

        if ($arr) {
            return self::getClienteObj($arr);
        }

        return false;
    }

    /**
     * @param string $email
     */
    public static function getClienteByEmail(string $email)
    {
        $arr = self::getDao()->getClienteByEmail(new ParamData(new ParamItem('email', $email)));

        if ($arr) {
            return self::getClienteObj($arr);
        }

        return false;
    }

    /**
     * @param $id
     * @param $cpf
     * @param $name
     * @param $email
     * @param $password
     * @return mixed
     */
    public static function salvar($id, $cpf, $name, $email, $password, $conPassword, $date = null)
    {
        $date = $date ?? date('Y-m-d H:i:s');

        $validation = new ClienteValidate($id, $cpf, $name, $email, $password, $conPassword, $date);

        if ($validation->getQtyErrors()) {
            Flash::setError($validation->getErrors());

            return false;
        }

        $store = new Cliente($id, $cpf, $name, $email, $password, $date);

        if ($store->getId()) {
            return self::getDao()->editCliente([
                'id' => $store->getId(),
                'name' => $store->getName(),
                'cpf' => $store->getCpf(),
                'email' => $store->getEmail(),
                'senha' => $store->getSenha(),
                'date' => $store->getDate(),
            ]);
        }

        return self::getDao()->addCliente([
            'name' => $store->getName(),
            'cpf' => $store->getCpf(),
            'email' => $store->getEmail(),
            'senha' => $store->getSenha(),
            'date' => $store->getDate(),
        ]);
    }

    /**
     * @param $idCliente
     * @param $idLoja
     */
    public static function sendEmailCompletionLink($idCliente, $idLoja)
    {
        $token = urlencode(base64_encode(bin2hex(random_bytes(32))));
        $hash = hash('sha256', $token . $_SERVER["HASH_SALT"]);
        $validUntil = date('Y-m-d H:i:s', strtotime('now +1day'));

        if (!ClienteCompletionLinkService::salvar(null, $hash, $idCliente, $idLoja, false, $validUntil)) {
            return false;
        }

        $cliente = self::getClienteById($idCliente);

        if (!$cliente) {
            return false;
        }

        $username = $cliente->getName();
        $supportEmail = $_SERVER["SUPPORT_EMAIL"];
        $companyName = $_SERVER["COMPANY_NAME"];
        $companyLegalName = $_SERVER["COMPANY_LEGAL_NAME"];
        $companyAddress = $_SERVER["COMPANY_ADDRESS"];

        $link = $_SERVER["BASE_URL"] . 'cadastro/completar/' . $token;

        $completeEmail = Mailer::template('completeEmail', [
            'username' => $username,
            'link' => $link,
            'supportEmail' => $supportEmail,
            'companyName' => $companyName,
            'companyLegalName' => $companyLegalName,
            'companyAddress' => $companyAddress,
        ]);

        return Mailer::sendEmail(
            $_SERVER["FROM_EMAIL"],
            $cliente->getEmail(),
            'Finalize seu cadastro e tenha acesso completo!',
            $completeEmail['body'],
            $completeEmail['altBody']
        );
    }
}