<?php

session_start();

$story_informations = file_get_contents('../app/data.json');
$data = json_decode($story_informations);

$param = $_GET['move'];

$info['inventory'] = $data->inventory->is_enabled;

if(empty($_SESSION) || $param == "goBack") {
    $_SESSION['move'] = "initial";
    $info['move'] = "initial";

    $info['message'] = $data->roomText->initial;
    $info['buttons'] = $data->directions;
}

if(isset($param) && !empty($_SESSION) && $param != "goBack") {
    $_SESSION['move'] = $param;
    $info['move'] = $param;

    $info['message'] = $data->roomText->$param;
}

if(isset($info)) {
    echo json_encode(array('info' => $info));
} else {
    echo json_encode(array('error' => 'no data sent'));
}