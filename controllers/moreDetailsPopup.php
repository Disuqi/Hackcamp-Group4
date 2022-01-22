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
    $appid = $_POST['app-id'];
    $app_id = (int) filter_var($appid, FILTER_SANITIZE_NUMBER_INT);
//    echo $return = $app_id;
//    die();
    $dataSet = new ItemDataSet();
    $sqlQuery = "SELECT * FROM gamesales WHERE appid = $app_id";
    $view->items = $dataSet->getObjectsFromQuery($sqlQuery);
    if($view->items >0){

        foreach($view->items as $item){
            $remove = array(';');
            $categories = str_replace($remove,', ',basename($item->getCategories()));
            $tags = str_replace($remove,', ',basename($item->getTags()));
            $platforms = str_replace($remove,', ',basename($item->getPlatforms()));
            $genres = str_replace($remove,', ',basename($item->getGenres()));
            echo $return = '
            <h5><span style="font-weight: bold">App ID: </span>'.$item->getAppId().' </h5>
            <h5><span style="font-weight: bold">Release Date: </span>'.$item->getReleaseDate().' </h5>
            <h5><span style="font-weight: bold">Status: </span>'.$item->getStatus().' </h5>
            <h5><span style="font-weight: bold">Platforms: </span>'.$platforms.' </h5>
            <h5><span style="font-weight: bold">Required Age: </span>'.$item->getRequiredAge().' </h5>
            
            <h5><span style="font-weight: bold">Categories: </span>'.$categories.' </h5>
            <h5><span style="font-weight: bold">Genres: </span>'.$genres.' </h5>
            <h5><span style="font-weight: bold">Tags: </span>'.$tags.' </h5>
            <h5><span style="font-weight: bold">Achievements: </span>'.$item->getAchievements().' </h5>
            <h5><span style="font-weight: bold">Positive Ratings: </span>'.$item->getPositiveRatings().' <i class="bi bi-hand-thumbs-up"></i></h5>
            <h5><span style="font-weight: bold">Negative Ratings: </span>'.$item->getNegativeRatings().' <i class="bi bi-hand-thumbs-down"></i></h5>
            <h5><span style="font-weight: bold">Average Playtime: </span>'.$item->getAveragePlaytime().' </h5>
            <h5><span style="font-weight: bold">Median Playtime: </span>'.$item->getMedianPlaytime().' </h5>
            <h5><span style="font-weight: bold">Physical: </span>'.$item->getPhysical().' </h5>
            <h5><span style="font-weight: bold">Units Available: </span>'.$item->getUnitsAvailable().' </h5>
            <h5><span style="font-weight: bold">Units Sold: </span>'.$item->getUnitsSold().' </h5>
            <h5><span style="font-weight: bold">Price: </span>£'.$item->getPrice().' </h5>';
        }
    }else{
        echo $return = "<h5>No Record Found</h5>";
    }

}


//require_once $_SERVER['DOCUMENT_ROOT'] . "/views/template/footer.phtml";