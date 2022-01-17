<?php
$view->fields = ['appid', 'release_date', 'developer', 'publisher', 'genres', 'price'];
if(isset($_POST['fields']))
    $view->fields = [];
    foreach($_POST as $field){
        if($field != "") {
            array_push($view->fields, $field);
        }}