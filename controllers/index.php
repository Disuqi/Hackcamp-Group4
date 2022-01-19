<?php
$view = new stdClass();
$view->items = [];
$view->fields = ['appid', 'release_date', 'english', 'developer', 'publisher', 'status', 'platforms', 'required_age', 'categories', 'genres', 'tags', 'achievements', 'positive_ratings', 'negative_ratings', 'average_playtime', 'median_playtime', 'physical', 'units_available', 'units_sold', 'price'];
$view->defaultFields = ['appid', 'release_date', 'developer', 'status'];

require_once  $_SERVER['DOCUMENT_ROOT'] . "/models/itemDataSet.php";

//$dataSet = new ItemDataSet();
//$view->items = $dataSet->getObjectsFromQuery('SELECT * FROM gamesales LIMIT 100');

require_once $_SERVER['DOCUMENT_ROOT'] . "/views/index.phtml";
