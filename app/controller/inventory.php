<?php

session_start();

$story_informations = file_get_contents('../app/data.json');
$data = json_decode($story_informations);

$param = $_GET['status'];

if(empty($_SESSION['status'])) {
    $_SESSION['status'] = "closed";
    $info['status'] = "closed";
}

if(isset($param) && !empty($_SESSION)) {
    $_SESSION['status'] = $param;
    $info['status'] = $param;

    if($param == "open") {
        $info['message'] = $data->inventory->inventory_open_msg;

        if(!isset($_SESSION['inventoryContent'])){
            $_SESSION['inventoryContent'] = $data->inventory->content;
            $info['inventoryContent'] = $_SESSION['inventoryContent'];
        } else {
            $info['inventoryContent'] = $_SESSION['inventoryContent'];
        }

        $info['items'] = $data->inventory->inventory_actions;
        $info['enabled_actions'] = $data->inventory->enabled_actions;
    }

    if($param == "close") {
        $move = $_SESSION['move'];
        $info['message'] = $data->roomText->$move;
        $info['buttons'] = $data->directions;
    }

    if(isset($_SESSION['move'])) {
        $info['move'] = $_SESSION['move'];
    }
}

if(isset($info)) {
    echo json_encode(array('info' => $info));
} else {
    echo json_encode(array('error' => 'no data sent'));
}

