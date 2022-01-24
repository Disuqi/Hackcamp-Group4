<?php
$view = new stdClass();
$view->items = [];
$view->fields = ['appid', 'release_date', 'english', 'developer', 'publisher', 'status', 'platforms', 'required_age', 'categories', 'genres', 'tags', 'achievements', 'positive_ratings', 'negative_ratings', 'average_playtime', 'median_playtime', 'physical', 'units_available', 'units_sold', 'price'];
$view->defaultFields = ['appid', 'release_date', 'developer', 'status'];
if(session_id() == ""){
    session_start();
}

require_once('models/ItemDataSet.php');

if(isset($_POST['mainSearch']) && trim($_POST['mainSearch']) != ""){
    $dataSet = new ItemDataSet();
    $view->items = $dataSet->search($_POST['mainSearch']);
}
if(isset($_GET['cards'])){
    $_SESSION['cards'] = $_GET['cards'];
}


if(isset($_GET['platforms'])){
    $dataSet = new ItemDataSet();
    $view->items = $dataSet->search("platforms:" .$_GET['platforms']);
}
if(isset($_GET['developer'])){
    $dataSet = new ItemDataSet();
    $view->items = $dataSet->search("developer:" .$_GET['developer']);
}
if(isset($_GET['status'])){
    $dataSet = new ItemDataSet();
    $view->items = $dataSet->search("status:" .$_GET['status']);
}
if(isset($_GET['categories'])){
    $dataSet = new ItemDataSet();
    $view->items = $dataSet->search("categories:" .$_GET['categories']);
}
if(isset($_GET['tags'])){
    $dataSet = new ItemDataSet();
    $view->items = $dataSet->search("tags:" .$_GET['tags']);
}

require_once('views/index.phtml');