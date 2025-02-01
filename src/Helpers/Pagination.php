<?php

namespace Fiado\Helpers;

use Fiado\Enums\FormDataType;
use Fiado\Enums\InputType;

class Pagination
{
    private int $itensPerPage;
    private int $currentPage;
    private int $totalPages;
    private string $baseUrl;
    private array $pages = [];

    /**
     * @param int $totalItens
     * @param string $baseUrl
     * @param int $itensPerPage
     */
    public function __construct(int $totalItens, string $baseUrl, int $itensPerPage = null)
    {
        $form = new FormData();

        $form->setItem('page', FormDataType::Int)->getValueFrom('pagina', 1, InputType::Get);

        $this->currentPage = $form->page;
        $this->itensPerPage = $itensPerPage ?? $_SERVER["LIST_ITEM_PER_PAGE"];
        $this->totalPages = ceil($totalItens / $this->itensPerPage);
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param int $page
     * @return string
     */
    private function getUrl(int $page)
    {
        if (str_contains($this->baseUrl, '?')) {
            return $this->baseUrl . "&pagina={$page}";
        }

        return $this->baseUrl . "?pagina={$page}";
    }

    /**
     * @param int $number
     * @return bool
     */
    public function isCurrent(int $number)
    {
        return $this->currentPage == $number;
    }

    /**
     * @return array
     */
    public function getPages()
    {
        for ($i = 1; $i <= $this->totalPages; $i++) {
            $this->pages[$i] = $this->getUrl($i);
        }

        return $this->pages;
    }

    /**
     * @return bool
     */
    public function hasPrevious()
    {
        return $this->currentPage > 1;
    }

    /**
     * @return bool
     */
    public function hasNext()
    {
        return $this->currentPage < $this->totalPages;
    }

    public function getFirstItemIndex()
    {
        return ($this->currentPage - 1) * $this->itensPerPage;
    }

    /**
     * @return int
     */
    public function getItensPerPage()
    {
        return $this->itensPerPage;
    }

    /**
     * @return string
     */
    public function getFirstPage()
    {
        return $this->getUrl(1);
    }

    /**
     * @return string
     */
    public function getNextPage()
    {
        return $this->getUrl($this->currentPage + 1);
    }

    /**
     * @return string
     */
    public function getPreviousPage()
    {
        return $this->getUrl($this->currentPage - 1);
    }

    /**
     * @return string
     */
    public function getLastPage()
    {
        return $this->getUrl($this->totalPages);
    }
}