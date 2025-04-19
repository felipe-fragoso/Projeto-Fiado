<?php
namespace Fiado\Graph;

use Fiado\Models\Service\CompraService;

final class GetCompraGraph implements GetGraphInterface
{
    private int $id;
    private ?bool $condition;

    /**
     * @param $id
     * @param $condition
     */
    public function __construct($id, $condition = null)
    {
        $this->id = $id;
        $this->condition = $condition;
    }

    /**
     * @param $startDate
     * @param $endDate
     */
    public function getData($startDate, $endDate)
    {
        return CompraService::getTotalLoja($this->id, $startDate, $endDate, $this->condition);
    }
}