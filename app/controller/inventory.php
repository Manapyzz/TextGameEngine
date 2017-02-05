<?php

session_start();

$general_informations = file_get_contents('../app/data/general.json');
$places_informations = file_get_contents('../app/data/places.json');
$inventory_informations = file_get_contents('../app/data/inventory.json');
$general = json_decode($general_informations);
$places = json_decode($places_informations);
$inventory = json_decode($inventory_informations);

$param = $_GET['status'];

if(empty($_SESSION['status'])) {
    $_SESSION['status'] = "closed";
    $info['status'] = "closed";
}

if(isset($param) && !empty($_SESSION['status'])) {

    if($param == "open" || $param == "close") {
        $_SESSION['status'] = $param;
        $info['status'] = $_SESSION['status'];
    }

    if($_SESSION['status'] == "open") {
        $info['message'] = $inventory->inventory->inventory_open_msg;

        if(!isset($_SESSION['inventoryContent'])){
            $_SESSION['inventoryContent'] = $inventory->inventory->content;
            $info['inventoryContent'] = $_SESSION['inventoryContent'];
        } else {
            $info['inventoryContent'] = $_SESSION['inventoryContent'];
        }
    }

    if($_SESSION['status'] == "close") {
        $move = $_SESSION['move'];
        $info['message'] = $places->roomText->$move;
        $info['buttons'] = $places->directions;
    }

    if(isset($_SESSION['move'])) {
        $info['move'] = $_SESSION['move'];
    }
}

if(isset($info)) {
    echo json_encode(array('info' => $info));
} else {
    echo json_encode(array('error' => 'no inventory sent'));
}

