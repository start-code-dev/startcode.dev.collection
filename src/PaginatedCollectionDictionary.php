<?php

namespace Startcode\Collection;

use Startcode\ValueObject\IntegerNumber;

class PaginatedCollectionDictionary extends CollectionDictionary
{
    /**
     * @var IntegerNumber
     */
    private $currentItemsCount;

    /**
     * @var IntegerNumber
     */
    private $currentPageNumber;

    /**
     * @var IntegerNumber
     */
    private $itemsCountPerPage;

    /**
     * @var IntegerNumber
     */
    private $pageCount;

    /**
     * @var IntegerNumber
     */
    private $totalItemsCount;

    public function getCurrentItemsCount() : IntegerNumber
    {
        return $this->currentItemsCount;
    }

    public function getCurrentPageNumber() : IntegerNumber
    {
        return $this->currentPageNumber;
    }

    public function getItemsCountPerPage() : IntegerNumber
    {
        return $this->itemsCountPerPage;
    }

    public function getPageCount() : IntegerNumber
    {
        return $this->pageCount;
    }

    public function getTotalItemsCount() : IntegerNumber
    {
        return $this->totalItemsCount;
    }

    public function setCurrentItemsCount(IntegerNumber $currentItemsCount) : self
    {
        $this->currentItemsCount = $currentItemsCount;
        return $this;
    }

    public function setCurrentPageNumber(IntegerNumber $currentPageNumber) : self
    {
        $this->currentPageNumber = $currentPageNumber;
        return $this;
    }

    public function setItemsCountPerPage(IntegerNumber $itemsCountPerPage) : self
    {
        $this->itemsCountPerPage = $itemsCountPerPage;
        return $this;
    }

    public function setPageCount(IntegerNumber $pageCount) : self
    {
        $this->pageCount = $pageCount;
        return $this;
    }

    public function setTotalItemsCount(IntegerNumber $totalItemsCount) : self
    {
        $this->totalItemsCount = $totalItemsCount;
        return $this;
    }

    public function map() : array
    {
        return [
            Constants::CURRENT_ITEMS       => $this->getRawData(),
            Constants::CURRENT_PAGE_NUMBER => $this->getCurrentPageNumber()->getValue(),
            Constants::TOTAL_ITEM_COUNT    => $this->getTotalItemsCount()->getValue(),
            Constants::ITEM_COUNT_PER_PAGE => $this->getItemsCountPerPage()->getValue(),
            Constants::CURRENT_ITEM_COUNT  => $this->getCurrentItemsCount()->getValue(),
            Constants::PAGE_COUNT          => $this->getPageCount()->getValue(),
        ];
    }
}
