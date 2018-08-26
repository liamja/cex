<?php declare(strict_types=1);

namespace Liamja\Cex;

class SearchParameters
{
    public const SEARCH_TERM = 'q';
    public const IN_STOCK = 'inStock';
    public const STORE_IDS = 'storeIds';
    public const CATEGORY_IDS = 'categoryIds';
    public const FIRST_RECORD = 'firstRecord';
    public const COUNT = 'count';
    public const SORT_BY = 'sortBy';
    public const SORT_ORDER = 'sortOrder';

    private $searchTerm;
    private $inStock;
    private $storeIds = [];
    private $categoryIds = [];
    private $firstRecord;
    private $count;
    private $sortBy;
    private $sortOrder;

    public function get($parameter)
    {
        return $this->$parameter;
    }

    public function getPreparedParameters(): array
    {
        $preparedParameters = [];

        if ($this->searchTerm !== null) {
            $preparedParameters[self::SEARCH_TERM] = $this->searchTerm;
        }

        if ($this->inStock !== null) {
            $preparedParameters[self::IN_STOCK] = $this->inStock;
        }

        if ($this->storeIds !== []) {
            $preparedParameters[self::STORE_IDS] = '[' . implode(',', $this->storeIds) . ']';
        }

        if ($this->categoryIds !== []) {
            $preparedParameters[self::CATEGORY_IDS] = '[' . implode(',', $this->categoryIds) . ']';
        }

        if ($this->firstRecord !== null) {
            $preparedParameters[self::FIRST_RECORD] = $this->firstRecord;
        }

        if ($this->count !== null) {
            $preparedParameters[self::COUNT] = $this->count;
        }

        if ($this->sortBy !== null) {
            $preparedParameters[self::SORT_BY] = $this->sortBy;
        }

        if ($this->sortOrder !== null) {
            $preparedParameters[self::SORT_ORDER] = $this->sortOrder;
        }

        return $preparedParameters;
    }

    public function setSearchTerm(string $value): self
    {
        $this->searchTerm = $value;

        return $this;
    }

    public function setInStock(bool $value): self
    {
        $this->inStock = $value;

        return $this;
    }

    public function isInStock(): self
    {
        $this->inStock = true;

        return $this;
    }

    public function isNotInStock(): self
    {
        $this->inStock = false;

        return $this;
    }

    public function setStoreIds(array $value): self
    {
        $this->storeIds = $value;

        return $this;
    }

    public function setStoreId(int $value): self
    {
        $this->storeIds = [$value];

        return $this;
    }

    public function addStoreId(int $value): self
    {
        $this->storeIds[] = $value;

        return $this;
    }

    public function setCategoryIds(array $value): self
    {
        $this->categoryIds = $value;

        return $this;
    }

    public function setCategoryId(int $value): self
    {
        $this->categoryIds = [$value];

        return $this;
    }

    public function addCategoryId(int $value): self
    {
        $this->categoryIds[] = $value;

        return $this;
    }

    public function setFirstRecord(int $value): self
    {
        $this->firstRecord = $value;

        return $this;
    }

    public function setCount(int $value): self
    {
        $this->count = $value;

        return $this;
    }

    public function setSortBy(string $value): self
    {
        $this->sortBy = $value;

        return $this;
    }
}
