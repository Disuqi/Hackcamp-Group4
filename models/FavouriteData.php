<?php

class FavouriteData
{
    protected $category_value, $category_name, $isFavourite;

    public function __construct($dbRow)
    {
        $this->category_value = $dbRow['catValues'];
        $this->category_name = $dbRow['category_name'];
        $this->isFavourite = $dbRow['favourite'];
    }

    /**
     * @return mixed
     */
    public function getCategoryValue(): mixed
    {
        return $this->category_value;
    }

    /**
     * @return mixed
     */
    public function getCategoryName(): mixed
    {
        return $this->category_name;
    }

    /**
     * @return mixed
     */
    public function getIsFavourite(): mixed
    {
        return $this->isFavourite;
    }


}