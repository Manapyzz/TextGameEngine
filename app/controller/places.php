<?php

session_start();

$general_informations = file_get_contents('../app/data/general.json');
$places_informations = file_get_contents('../app/data/places.json');
$general = json_decode($general_informations);
$places = json_decode($places_informations);

$param = $_GET['move'];

$info['inventory'] = $general->inventory->is_enabled;

if(empty($_SESSION) || $param == "goBack") {
    $_SESSION['move'] = "initial";
    $info['move'] = "initial";

    $info['message'] = $places->roomText->initial;
    $info['buttons'] = $places->directions;
}

if(isset($param) && !empty($_SESSION) && $param != "goBack") {
    $_SESSION['move'] = $param;
    $info['move'] = $param;

    $info['message'] = $places->roomText->$param;
}

if(isset($info)) {
    echo json_encode(array('info' => $info));
} else {
    echo json_encode(array('error' => 'no places sent'));
}