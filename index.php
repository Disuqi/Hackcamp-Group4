<?php
$view = new stdClass();
$view->items = [];
$view->fields = ['appid', 'release_date', 'english', 'developer', 'publisher', 'status', 'platforms', 'required_age', 'categories', 'genres', 'tags', 'achievements', 'positive_ratings', 'negative_ratings', 'average_playtime', 'median_playtime', 'physical', 'units_available', 'units_sold', 'price'];
$view->defaultFields = ['appid', 'release_date', 'developer', 'status'];
if(session_id() == ""){
    session_start();
}

require_once('models/ItemDataSet.php');
$dataSet = new ItemDataSet();

//if the main search box has been used, use the search method to get the data
if(isset($_POST['mainSearch']) && trim($_POST['mainSearch']) != ""){
    $view->items = $dataSet->search($_POST['mainSearch']);
}

//if GET is set then it is a category search
if(isset($_GET)){
    $key = key($_GET);
    switch($key){
        case 'cards':
            //the view will check for this session variable and display the cards instead of the list
            $_SESSION[$key] = $_GET[$key];
            break;
        default:
            //search for the category
            $view->items = $dataSet->search( $key .":" .$_GET[$key]);
            break;
    }
}

require_once('views/index.phtml');