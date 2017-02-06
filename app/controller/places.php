<?php

session_start();

$general_informations = file_get_contents('../app/data/general.json');
$places_informations = file_get_contents('../app/data/places.json');
$inventory_informations = file_get_contents('../app/data/inventory.json');
$win_loose_informations = file_get_contents('../app/data/winLooseConditions.json');
$general = json_decode($general_informations);
$places = json_decode($places_informations);
$winLoose = json_decode($win_loose_informations);
$inventory = json_decode($inventory_informations);

$param = $_GET['move'];

$info['inventory'] = $general->inventory->is_enabled;

if($general->activate_css->is_enabled) {
    $info['activate_css'] = true;
} else {
    $info['activate_css'] = false;
}

if($general->inventory->is_enabled) {
    if(!isset($_SESSION['inventoryContent'])) {
        $_SESSION['inventoryContent'] = $inventory->inventory->content;
    }
}


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

checkWinOrLoosePlaces($winLoose->conditions->win->places, "win", $info);
checkWinOrLoosePlaces($winLoose->conditions->loose->places, "loose", $info);

if($general->inventory->is_enabled) {
    checkWinOrLooseInventory($winLoose->conditions->win->inventory, $info);
}

checkRequiredConditions($winLoose->required_conditions->loose, "loose", $info);
checkRequiredConditions($winLoose->required_conditions->win, "win", $info);

if(isset($info['winConditions']) && isset($info['looseConditions'])) {
    $info['winMessage'] = $winLoose->descriptions->win;
    $info['looseMessage'] = $winLoose->descriptions->loose;
}

function checkWinOrLooseInventory($conditionType, &$info) {
    if(isset($conditionType)) {
        $inventoryConditions = $conditionType;
        $decode_winningConditions = json_decode(json_encode($inventoryConditions), True);
        if(isset($_SESSION['isDropped'])) {
            $info['isDropped'] = $_SESSION['isDropped'];
        }

        foreach ($decode_winningConditions as $key => $value) {
            switch($key) {
                case "isDropped":
                    $isDropped = true;
                    $decode_inventoryContent = json_decode(json_encode($_SESSION['inventoryContent']), True);

                    for($i = 0; $i < count($value); $i++) {
                        if(in_array($value[$i], $decode_inventoryContent)) {
                            $isDropped = false;
                        }
                    }

                    if($isDropped) {
                        $_SESSION['isDropped'] = true;
                        $info['isDropped'] = $_SESSION['isDropped'];
                    }
                    break;
                // We let a switch to allow some other case in the future
            }
        }
    }
}

function checkWinOrLoosePlaces($conditionType, $winOrLose, &$info) {
    if(isset($conditionType)) {

        $winOrLoseConditions = $conditionType;
        $decode_winOrLoseConditions = json_decode(json_encode($winOrLoseConditions), True);

        foreach ($decode_winOrLoseConditions as $key => $value) {
            switch($key) {
                case "isCharacterHere":
                    if($_SESSION['move'] == $value) {
                        $info[$winOrLose.'Room'] = true;
                    }
                    break;
                case "howMuchTimeWasHere":
                    if(!isset($_SESSION[$winOrLose.'Counter'])) {
                        $_SESSION[$winOrLose.'Counter'] = 0;
                    }

                    if($_SESSION['move'] == $value['room']) {
                        $_SESSION[$winOrLose.'Counter']++;
                    }

                    if($_SESSION[$winOrLose.'Counter'] >= $value['number']) {
                        $info[$winOrLose.'Counter'] = true;
                    }
                    break;
            }
        }
    }
}

//$required_conditions = $winLoose->required_conditions->loose;
//$decode_required_conditions = json_decode(json_encode($required_conditions), True);
//
//foreach ($decode_required_conditions as $key => $value) {
//    if($value) {
//        $info['looseConditions'][] =  $key;
//    }
//}

function checkRequiredConditions($conditionType, $winOrLose, &$info) {
    $required_conditions = $conditionType;
    $decode_required_conditions = json_decode(json_encode($required_conditions), True);

    foreach ($decode_required_conditions as $key => $value) {
        if($value) {
            $info[$winOrLose.'Conditions'][] =  $key;
        }
    }
}

if(isset($info)) {
    echo json_encode(array('info' => $info));
} else {
    echo json_encode(array('error' => 'no places sent'));
}