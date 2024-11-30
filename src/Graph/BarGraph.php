<?php
namespace Fiado\Graph;

class BarGraph
{
    /**
     * @var mixed
     */
    private $total;
    private string $moeda;
    private array $bars = [];
    private GetGraphInterface $getObj;
    private IntervalGraphType $type;
    /**
     * @var mixed
     */
    public $getGraph;

    /**
     * @param GetGraphInterface $getObj
     * @param IntervalGraphType $type
     * @param string $moeda
     */
    public function __construct(GetGraphInterface $getObj, IntervalGraphType $type = IntervalGraphType::Month, string $moeda = 'real')
    {
        $this->getObj = $getObj;
        $this->type = $type;
        $this->moeda = $moeda;

        $this->getGraph = match ($this->type) {
            IntervalGraphType::Month => $this->getGraphMontly(...),
            IntervalGraphType::Day => $this->getGraphDaily(...),
        };
    }

    /**
     * @param $startDate
     */
    private function setTotal($startDate)
    {
        $this->total = $this->getObj->getData(new \DateTime($startDate), new \DateTime());
    }

    /**
     * @param $name
     * @param $startDate
     * @param $endDate
     */
    private function setBars($name, $startDate, $endDate)
    {
        $this->bars[] = [
            'name' => $name,
            'value' => $this->getObj->getData(new \DateTime($startDate), new \DateTime($endDate)),
        ];
    }

    /**
     * @param $months
     * @return mixed
     */
    private function getGraphMontly($months)
    {
        $this->setTotal('first day of ' . ($months - 1) . ' months ago');

        for ($i = 0; $i < $months; $i++) {
            $startDate = 'first day of ' . $i . ' months ago midnight';
            $endDate = 'last day of ' . $i . ' months ago midnight 23:59:59';
            $name = (new \DateTime($startDate))->format('M/y');

            $this->setBars($name, $startDate, $endDate);
        }

        return $this;
    }

    /**
     * @param $days
     * @return mixed
     */
    private function getGraphDaily($days)
    {
        $this->setTotal(($days - 1) . ' days ago midnight');

        for ($i = 0; $i < $days; $i++) {
            $startDate = $i . ' days ago midnight';
            $endDate = ($i - 1) . ' days ago midnight -1 sec';
            $name = (new \DateTime($startDate))->format('d/M');

            $this->setBars($name, $startDate, $endDate);
        }

        return $this;
    }

    public function getTotal()
    {
        return number_format($this->total ?? 0, 2, ',', '.');
    }

    /**
     * @return mixed
     */
    public function getBars()
    {
        return $this->bars;
    }

    /**
     * @return mixed
     */
    public function getMoeda()
    {
        return $this->moeda;
    }
}