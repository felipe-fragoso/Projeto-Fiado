<?php
namespace Fiado\Graph;

interface GetGraphInterface
{
    /**
     * @param $startDate
     * @param $endDate
     */
    public function getData($startDate, $endDate);
}