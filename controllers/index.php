<?php
$view = new stdClass();
require_once "itemLister.php";
require_once  $_SERVER['DOCUMENT_ROOT'] . "/models/itemDataSet.php";

$dataSet = new ItemDataSet();
$view->items = $dataSet->getObjectsFromQuery('SELECT * FROM gamesales LIMIT 100');

require_once $_SERVER['DOCUMENT_ROOT'] . "/views/index.phtml";
