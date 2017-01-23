$(function () {
    function capitalize(string) {
        return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
    }

    Object.size = function(obj) {
        var size = 0, key;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) size++;
        }
        return size;
    };

    $(document).on("click", ".inventoryBtn", function() {
        $.ajax({
            type: "GET",
            url: "inventorycontroller?status="+$(this).attr('param'),
            datatype: "json",
            data: $(this).serialize(),
            success: function(data) {
                var obj = JSON.parse(data);
                var itemNumber = 0;

                $('.message-box').html(obj.info.message);

                if(obj.info.status == "open") {
                    var inventoryContent = obj.info.inventoryContent;

                    $('.allDirections').html('<li><a class="inventoryBtn" href="inventorycontroller" param="close">Close Inventory</a></li>');

                    $('.inventoryContent').html('');
                    $('.inventoryActionsContent').html('');

                    for(var i = 0;i<Object.size(inventoryContent);i++) {
                        $('.inventoryContent').append('<li><a class="inventoryBtn" href="inventorycontroller" param="item">'+obj.info.inventoryContent[i]+'</a></li>');
                    }

                    console.log(obj.info.items);

                    $(".inventoryContent li").click(function(){
                        var itemNumber = $(this).index();

                        var inventoryActions = obj.info.items[itemNumber];

                        $('.inventoryActions').html('<li>Actions for '+inventoryContent[itemNumber]+'</li>')

                        console.log(obj.info.enabled_actions);

                        for(var i = 0;i<inventoryActions.length;i++) {

                            switch(inventoryActions[i]) {
                                case "Use":
                                    $('.inventoryActions').append('<li><a class="inventoryBtn" href="inventorycontroller" param="useItem">'+inventoryActions[i]+'</a></li>');
                                    break;
                                case "Inspect":
                                    $('.inventoryActions').append('<li><a class="inventoryBtn" href="inventorycontroller" param="inspectItem">'+inventoryActions[i]+'</a></li>');
                                    break;
                                case "Drop":
                                    $('.inventoryActions').append('<li><a class="inventoryBtn" href="inventorycontroller" param="dropItem">'+inventoryActions[i]+'</a></li>');
                            }
                        }
                    });
                }

                if(obj.info.status == "close") {
                    var buttons = obj.info.buttons;

                    $('.inventoryContent').html('');
                    $('.allDirections').html('');
                    $('.inventoryActions').html('');

                    if(obj.info.move == "initial") {
                        for (var key in buttons) {
                            if (buttons.hasOwnProperty(key)) {
                                if(key != "initial") {
                                    $('.allDirections').append("<li><a class='choiceBtn' href='directioncontroller' param='"+key+"'>"+capitalize(buttons[key])+"</a></li>");
                                }
                            }
                        }
                    }

                    $('.allDirections').append("<li><a class='inventoryBtn' href='inventorycontroller' param='open'>Open Inventory</a></li>");

                    if(obj.info.move !== "initial") {
                        $('.allDirections').append("<li><a class='choiceBtn' href='directioncontroller' param='goBack'>Go Back</a></li>");
                    }
                }
            },
            error: function() {
                console.log('error');
            }
        });
        return false;
    });
});