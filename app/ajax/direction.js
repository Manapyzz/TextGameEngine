$(function () {
    function capitalize(string) {
        return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
    }

    function checkRequiredConditions(conditions, room, counter, isDropped ) {
        var checker = true;

        if(conditions) {
            for(var i = 0; i < conditions.length; i++) {
                switch (conditions[i]) {
                    case "isCharacterHere" :
                        if(checker) {
                            checker = false;
                            if(room) {
                                checker = true
                            }
                        }
                        break;
                    case "howMuchTimeWasHere":
                        if(checker) {
                            checker = false;
                            if(counter) {
                                checker = true;
                            }
                        }
                        break;
                    case "isDropped":
                        if(checker) {
                            checker = false;
                            if(isDropped) {
                                checker = true;
                            }
                        }
                        break;
                }
            }
        }

        return checker;
    }

    $(document).on("click", ".choiceBtn", function() {
        $.ajax({
            type: "GET",
            url: "directioncontroller?move="+$(this).attr('param'),
            datatype: "json",
            data: $(this).serialize(),
            success: function(data) {
                var obj = JSON.parse(data);
                var endGame = false;

                $('.allDirections').empty();

                if(obj.info.move == "initial") {
                    var buttons = obj.info.buttons;
                    $('.allDirections').empty();
                    for (var key in buttons) {
                        if (buttons.hasOwnProperty(key)) {
                            if(key != "initial") {
                                $('.allDirections').append("<li><a class='choiceBtn' href='directioncontroller' param='"+key+"'>"+capitalize(buttons[key])+"</a></li>");
                            }
                        }
                    }
                    if(obj.info.inventory) {
                        $('.allDirections').append("<li><a class='inventoryBtn' href='inventorycontroller' param='open'>Open Inventory</a></li>");
                    }
                } else {
                    if(obj.info.inventory) {
                        $('.allDirections').html("<li><a class='inventoryBtn' href='inventorycontroller' param='open'>Open Inventory</a></li>");
                    }
                    $('.allDirections').append("<li><a class='choiceBtn' href='directioncontroller' param='goBack'>Go Back</a></li>");
                }
                $('.message-box').html('<p>'+obj.info.message+'</p>');

                if(checkRequiredConditions(obj.info.looseConditions, obj.info.looseRoom, obj.info.looseCounter, obj.info.isDropped) && !endGame){
                    alert(obj.info.looseMessage);
                    endGame = true;
                    window.location.replace("/restartcontroller");
                }

                if(checkRequiredConditions(obj.info.winConditions, obj.info.winRoom, obj.info.winCounter, obj.info.isDropped) && !endGame){
                    alert(obj.info.winMessage);
                    endGame = true;
                    window.location.replace("/restartcontroller");
                }
            },
            error: function() {
                console.log('error');
            }
        });
        return false;
    });
});