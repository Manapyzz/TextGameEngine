<?php

session_start();

$general_informations = file_get_contents('../app/data/general.json');
$places_informations = file_get_contents('../app/data/inventory.json');
$general = json_decode($general_informations);
$inventory = json_decode($places_informations);

//params in url
$actionInventory = $_GET['action'];
$itemNumber = $_GET['number'];

// reset inventory open
$_SESSION['status'] = "open";
$info['status'] = "open";

// reset default value
$info['dropItem'] = false;
$info['chooseItem'] = false;

if(!isset($_SESSION['description'])) {
    $_SESSION['description'] = $inventory->inventory->description;
}

if($actionInventory == "item") {

    if(isset($_SESSION['inventory_actions'])) {
        $info['inventory_actions'] = $_SESSION['inventory_actions'];
    } else {
        $info['inventory_actions'] = $inventory->inventory->inventory_actions;
    }

    if(isset($_SESSION['enabled_actions'])) {
        $info['enabled_actions'] = $_SESSION['enabled_actions'];
    } else {
        $info['enabled_actions'] = $inventory->inventory->enabled_actions;
    }

    $info['inventoryContent'] = $_SESSION['inventoryContent'];
    $info['chooseItem'] = true;
}

if($actionInventory == "useItem") {

} else if ($actionInventory== "dropItem") {

    $decode_inventory = json_decode(json_encode($_SESSION['inventoryContent']), True);
    $decode_description = json_decode(json_encode($inventory->inventory->description), True);
    $decode_inventory_actions = json_decode(json_encode($inventory->inventory->inventory_actions), True);
    $decode_enabled_actions = json_decode(json_encode($inventory->inventory->enabled_actions), True);

    unset($decode_inventory[$itemNumber]);
    unset($decode_description[$itemNumber]);
    unset($decode_inventory_actions[$itemNumber]);
    unset($decode_enabled_actions[$itemNumber]);

    $decode_inventory = array_values($decode_inventory);
    $decode_description = array_values($decode_description);
    $decode_inventory_actions = array_values($decode_inventory_actions);
    $decode_enabled_actions = array_values($decode_enabled_actions);

    $_SESSION['inventoryContent'] = $decode_inventory;
    $info['inventoryContent'] = $_SESSION['inventoryContent'];

    $_SESSION['description'] = $decode_description;
    $info['description'] = $_SESSION['description'];

    $_SESSION['inventory_actions'] = $decode_inventory_actions;
    $info['inventory_actions'] = $_SESSION['inventory_actions'];

    $_SESSION['enabled_actions'] = $decode_enabled_actions;
    $info['enabled_actions'] = $_SESSION['enabled_actions'];

    $info['dropItem'] = true;
} else if ($actionInventory == "inspectItem") {
    $info['inspect'] = $_SESSION['description'];
}

if(isset($itemNumber)) {
    $info['itemNumber'] = $itemNumber;
}

if(isset($_SESSION['move'])) {
    $info['move'] = $_SESSION['move'];
}

if(isset($info)) {
    echo json_encode(array('info' => $info));
} else {
    echo json_encode(array('error' => 'no places sent'));
}