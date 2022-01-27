<?php
require_once('CategoryDataSet.php');
class CategoryData
{
    protected $category_value, $category_name, $isFavourite;

    public function __construct($dbRow)
    {
        $this->category_name = key($dbRow);
        $this->category_value = $dbRow[key($dbRow)];
        $this->isFavourite = false;
        $catDataSet = new CategoryDataSet();
        $this->isFavourite = $catDataSet->checkFavourite($this->category_value, $this->category_name);
    }

    /**
     * @return int|string|null
     */
    public function getCategoryName(): int|string|null
    {
        return $this->category_name;
    }

    /**
     * @return mixed
     */
    public function getCategoryValue(): mixed
    {
        return $this->category_value;
    }

    /**
     * @return bool
    */
    public function isFavourite(): bool
    {
        return $this->isFavourite;
    }




}