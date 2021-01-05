<?php

namespace Startcode\Collection;

class PaginatedCollection extends Collection
{

    /**
     * @var int
     */
    private $currentItemsCount;

    /**
     * @var int
     */
    private $currentPageNumber;

    /**
     * @var int
     */
    private $itemsCountPerPage;

    /**
     * @var int
     */
    private $pageCount;

    /**
     * @var int
     */
    private $totalItemsCount;

    public function getCurrentItemsCount() : int
    {
        return $this->currentItemsCount;
    }

    public function getCurrentPageNumber() : int
    {
        return $this->currentPageNumber;
    }

    public function getItemsCountPerPage() : int
    {
        return $this->itemsCountPerPage;
    }

    public function getPageCount() : int
    {
        return $this->pageCount;
    }

    public function getTotalItemsCount() : int
    {
        return $this->totalItemsCount;
    }

    public function setCurrentItemsCount(int $currentItemsCount) : self
    {
        $this->currentItemsCount = $currentItemsCount;
        return $this;
    }

    public function setCurrentPageNumber(int $currentPageNumber) : self
    {
        $this->currentPageNumber = $currentPageNumber;
        return $this;
    }

    public function setItemsCountPerPage(int $itemsCountPerPage) : self
    {
        $this->itemsCountPerPage = $itemsCountPerPage;
        return $this;
    }

    public function setPageCount(int $pageCount) : self
    {
        $this->pageCount = $pageCount;
        return $this;
    }

    public function setTotalItemsCount(int $totalItemsCount) : self
    {
        $this->totalItemsCount = $totalItemsCount;
        return $this;
    }

    public function map() : array
    {
        return [
            Constants::CURRENT_ITEMS       => $this->getRawData(),
            Constants::CURRENT_PAGE_NUMBER => $this->getCurrentPageNumber(),
            Constants::TOTAL_ITEM_COUNT    => $this->getTotalItemsCount(),
            Constants::ITEM_COUNT_PER_PAGE => $this->getItemsCountPerPage(),
            Constants::CURRENT_ITEM_COUNT  => $this->getCurrentItemsCount(),
            Constants::PAGE_COUNT          => $this->getPageCount(),
        ];
    }
}
