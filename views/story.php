<?php
    $story_informations = file_get_contents('../app/data.json');
    $data = json_decode($story_informations);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta param="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Home</title>
    <script
        src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
    <script src="direction"></script>

</head>
<body>

    <h1>Hello Random Story !</h1>

    <div class="message-box">
        <p><?php echo $data->roomText->initial ?></p>
    </div>

    <h3>Places :</h3>

    <ul class="allDirections">
        <?php
            foreach ($data->directions as $key => $direction) {
                if($key != "initial") {
                    echo "<li><a class='choiceBtn' href='directioncontroller' param='".$key."'>".ucfirst($direction)."</a></li>";
                }
            }
        ?>
    </ul>


</body>
</html>
