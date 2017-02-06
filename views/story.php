<?php
    $general_informations = file_get_contents('../app/data/general.json');
    $places_informations = file_get_contents('../app/data/places.json');
    $general = json_decode($general_informations);
    $places = json_decode($places_informations);

    if($general->inventory->is_enabled) {
        $inventory_informations = file_get_contents('../app/data/inventory.json');
        $inventory = json_decode($general_informations);
    }

    session_start();
    $_SESSION['move'] = "initial";

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta param="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
    <link rel="stylesheet" href="css">
    <script
        src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
    <script src="directionajax"></script>
    <script src="inventoryajax"></script>
    <script src="inventoryitemajax"></script>
</head>
<body>

<main class="storymain">

    <div class="background">
        <ul class="allDirections">
            <?php
            foreach ($places->directions as $key => $direction) {
                if($key != "initial") {
                    echo "<li id='".$key."'><a class='choiceBtn' href='directioncontroller' param='".$key."'><img src=".$key." alt=".$direction."></a></li>";
                }
            }
            ?>
        </ul>
        <img class="character" src="char" alt="character">
    </div>


    <div class="container">
        <div class="message-box">
            <p><?php echo $places->roomText->initial ?></p>
        </div>
        <?php

        if($general->inventory->is_enabled == "true") {
            echo "<ul class='inventoryContent'></ul>";

                echo "<ul class='inventoryActions'></ul>";
            }
        ?>
        <div class="actions">

            <?php
            if($general->inventory->is_enabled == "true") {
                echo "<div><a class='inventoryBtn' href='inventorycontroller' param='open'>Open Inventory</a></div>";
            }
            ?>
        </div>
    </div>


    <div class="dangerzone">
        <h4>DANGER ZONE:</h4>
        <a href="restartcontroller">Restart Game !</a>
    </div>

</main>
</body>
</html>
