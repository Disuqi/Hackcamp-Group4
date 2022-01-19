<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/CategoryDataSet.php";

//Returns dataset from cells that contain single values (one cell in database without semicolons)

function getSingleValues($attributeName) : array
{

    $catDataSet = new CategoryDataSet();
    $dataSet = $catDataSet->fetchSingleCategories($attributeName);
    return $dataSet;
}

//Returns dataset from cells that contain multiple values (one cell in database with semicolons)
function getMultipleValues($attributeName) : array
{
    $catDataSet = new CategoryDataSet();
    $dataSet = $catDataSet->fetchMultiCategories($attributeName);
    return $dataSet;
}

//Returns appid of items where their values fit the range of numbers passed in parameter (min number, max number)
//For example get ID of items with positive ratings from 0 to 1000
function getAppIdByRange($attributeName, $min, $max) : array
{
    $catDataSet = new CategoryDataSet();
    $dataSet = $catDataSet->fetchItemsByRange($attributeName, $min, $max);
    return $dataSet;
}

function getFavourites()
{
    $catDataSet = new CategoryDataSet();
    $dataSet = $catDataSet->fetchAllFavourites();
    return $dataSet;
}
require_once $_SERVER['DOCUMENT_ROOT'] . "/views/leftPanel.phtml";





