<?php
$view = new stdClass();
$view->items = [];
$view->fields = ['appid', 'release_date', 'english', 'developer', 'publisher', 'status', 'platforms', 'required_age', 'categories', 'genres', 'tags', 'achievements', 'positive_ratings', 'negative_ratings', 'average_playtime', 'median_playtime', 'physical', 'units_available', 'units_sold', 'price'];
$view->defaultFields = ['appid', 'release_date', 'developer', 'status'];

require_once  $_SERVER['DOCUMENT_ROOT'] . "/models/itemDataSet.php";

if(isset($_POST['mainSearch']) && trim($_POST['mainSearch']) != ""){
    $dataSet = new ItemDataSet();
    $view->items = $dataSet->search($_POST['mainSearch']);
}

if(isset($_POST['checking-view-btn'])){
    $app_id = $_POST['app-id'];
    echo $return = $app_id;
    $dataSet = new ItemDataSet();
    $sqlQuery = "SELECT * FROM gamesales WHERE appid = $app_id";
    $view->items = $dataSet->getObjectsFromQuery($sqlQuery);

}


require_once $_SERVER['DOCUMENT_ROOT'] . "/views/index.phtml";