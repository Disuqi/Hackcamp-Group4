<?php
$view = new stdClass();

require_once('../models/ItemDataSet.php');
//this is a more view details page
if(isset($_POST['checking-view-btn'])){
    $appid = $_POST['app-id'];// storing app id
    $app_id = (int) filter_var($appid, FILTER_SANITIZE_NUMBER_INT);//converting appid from string to int and removing alphabets

    $dataSet = new ItemDataSet();// creates new itemDataSet object.
    $sqlQuery = "SELECT * FROM gamesales WHERE appid = $app_id"; //it is a query to get data matches the appid
    $view->items = $dataSet->getObjectsFromQuery($sqlQuery);//passing query to ItemDataSet class.

    //running a for loop to get each cell of the row
    if($view->items >0){

        foreach($view->items as $item){
            //removes the semi-colon from the string
            $remove = array(';');
            //removes the semi-colon from the string
            $categories = str_replace($remove,', ',basename($item->getCategories()));
            //removes the semi-colon from the string
            $tags = str_replace($remove,', ',basename($item->getTags()));
            //removes the semi-colon from the string
            $platforms = str_replace($remove,', ',basename($item->getPlatforms()));
            //removes the semi-colon from the string
            $genres = str_replace($remove,', ',basename($item->getGenres()));
            //echos the html table back to view page
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
            <h5><span style="font-weight: bold">Price: </span>??'.$item->getPrice().' </h5>';
        }
    }else{
        echo $return = "<h5>No Record Found</h5>";
    }

}
//this is an Edit details page
if(isset($_POST['checking-edit-btn'])){
    $appid = $_POST['app-id'];// storing app id
    $app_id = (int) filter_var($appid, FILTER_SANITIZE_NUMBER_INT);//converting appid from string to int and removing alphabets

    $dataSet = new ItemDataSet();// creates new itemDataSet object.
    $sqlQuery = "SELECT * FROM gamesales WHERE appid = $app_id";//it is a query to get data matches the appid
    $view->items = $dataSet->getObjectsFromQuery($sqlQuery);//passing query to ItemDataSet class.

    //running a for loop to get each cell of the row
    if($view->items >0){

        foreach($view->items as $item){
            //it returns a html page layout for edit page view.
            echo $return = '
            <form>
  <div class="row">
    <div class="form-group col-md-auto col-sm-auto ">
      <label><span style="font-weight: bold">App ID</span></label>
      <input type="text" class="form-control" id="inputEmail4" value="'.$item->getAppId().'">
    </div>
    <div class="form-group col-md-auto col-sm-auto">
      <label class="d-inline"><span style="font-weight: bold">Release Date</span></label>
      <input type="text" class="form-control" value="'.$item->getReleaseDate().'">
    </div>
    <div class="form-group col-md-auto col-sm-auto ">
      <label class="d-inline"><span style="font-weight: bold">Status</span></label>
      <input type="text" class="form-control" value="'.$item->getStatus().'">
    </div>
    <div class="form-group col-md-auto col-sm-auto ">
      <label class="d-inline"><span style="font-weight: bold">Platforms</span></label>
      <input type="text" class="form-control" value="'.$item->getPlatforms().'">
    </div>
     <div class="form-group col-md-auto col-sm-auto ">
      <label class="d-inline"><span style="font-weight: bold">Required Age</span></label>
      <input type="text" class="form-control" value="'.$item->getRequiredAge().'">
    </div>
  </div>
  
  <div class="form-group">
      <label class="d-inline"><span style="font-weight: bold">Categories</span></label>
      <input type="text" class="form-control col-md-auto" value="'.$item->getCategories().'">
  </div>

  <div class="form-group">
   <label class="d-inline"><span style="font-weight: bold">Genres</span></label>
      <input type="text" class="form-control" value="'.$item->getGenres().'">
      <label class="d-inline"><span style="font-weight: bold">Tags</span></label>
      <input type="text" class="form-control col-md-auto" value="'.$item->getTags().'">
  </div>
  
  <div class="row">
    <div class="form-group col-md-auto col-sm-auto ">
      <label class="d-inline"><span style="font-weight: bold">Achievements</span></label>
      <input type="text" class="form-control" value="'.$item->getAchievements().'">
    </div>
    <div class="form-group col-md-auto col-sm-auto ">
      <label class="d-inline"><span style="font-weight: bold">Positive Ratings</span></label>
      <input type="text" class="form-control" value="'.$item->getPositiveRatings().'">
    </div>
    <div class="form-group col-md-auto col-sm-auto ">
      <label class="d-inline"><span style="font-weight: bold">Negative Ratings</span></label>
      <input type="text" class="form-control" value="'.$item->getNegativeRatings().'">
    </div>
    <div class="form-group col-md-auto col-sm-auto ">
      <label class="d-inline"><span style="font-weight: bold">Average Playtime</span></label>
      <input type="text" class="form-control" value="'.$item->getAveragePlaytime().'">
    </div>
    <div class="form-group col-md-auto col-sm-auto ">
      <label class="d-inline"><span style="font-weight: bold">Median Playtime</span></label>
      <input type="text" class="form-control" value="'.$item->getMedianPlaytime().'">
    </div>
    <div class="form-group col-md-auto col-sm-auto ">
      <label class="d-inline"><span style="font-weight: bold">Physical</span></label>
      <input type="text" class="form-control" value="'.$item->getPhysical().'">
    </div>
    <div class="form-group col-md-auto col-sm-auto ">
      <label class="d-inline"><span style="font-weight: bold">Units Available</span></label>
      <input type="text" class="form-control" value="'.$item->getUnitsAvailable().'">
    </div>
    <div class="form-group col-md-auto col-sm-auto ">
      <label class="d-inline"><span style="font-weight: bold">Units Sold</span></label>
      <input type="text" class="form-control" value="'.$item->getUnitsSold().'">
    </div>
    <div class="form-group col-md-auto col-sm-auto ">
      <label class="d-inline"><span style="font-weight: bold">Price</span></label>
      <input type="text" class="form-control" value="'.$item->getPrice().'">
    </div>
  </div>
  
  
</form>
           ';
        }
    }else{
        echo $return = "<h5>No Record Found</h5>";
    }

}
