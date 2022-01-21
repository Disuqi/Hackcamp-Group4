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
if(sizeof($view->items) == 0) {
    if(!isset($_SESSION['jsonFile'])) {
        $json = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/json/data.json');
        $_SESSION['jsonFile'] = json_decode($json, true);
    }
    $view->items = $_SESSION['jsonFile'];
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/views/index.phtml";