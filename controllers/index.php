<?php
$view = new stdClass();
$view->items = [];
$view->fields = ['appid', 'release_date', 'english', 'developer', 'publisher', 'status', 'platforms', 'required_age', 'categories', 'genres', 'tags', 'achievements', 'positive_ratings', 'negative_ratings', 'average_playtime', 'median_playtime', 'physical', 'units_available', 'units_sold', 'price'];
$view->defaultFields = ['appid', 'release_date', 'developer', 'status'];
if(session_id() == ""){
    session_start();
}

require_once  $_SERVER['DOCUMENT_ROOT'] . "/models/itemDataSet.php";

if(isset($_POST['mainSearch']) && trim($_POST['mainSearch']) != ""){
    $dataSet = new ItemDataSet();
    $view->items = $dataSet->search($_POST['mainSearch']);
}
if(isset($_GET['cards'])){
    $_SESSION['cards'] = $_GET['cards'];
}

require_once $_SERVER['DOCUMENT_ROOT'] ."/views/template/header.phtml";
require_once $_SERVER['DOCUMENT_ROOT'] ."/views/quickAccessBar.phtml";
require_once $_SERVER['DOCUMENT_ROOT'] ."/views/filterPanel.phtml";
if( isset($_SESSION['cards']) && $_SESSION['cards'] == 'true'){
    require_once $_SERVER['DOCUMENT_ROOT'] ."/views/itemCardLister.phtml";
}else {
    require_once $_SERVER['DOCUMENT_ROOT'] ."/views/itemLister.phtml";
}
require_once $_SERVER['DOCUMENT_ROOT'] ."/views/template/footer.phtml"; ?>