$(function () {

    function isInventoryActionsAuthorize(rooms, action, position, number) {

        var lowerCaseActionName = action.toLowerCase();

        if(rooms == "all") {
            $('.inventoryActions').append('<li><a class="inventoryContentBtn" href="inventoryitemcontroller" action="'+lowerCaseActionName+'Item" number="'+number+'">'+action+'</a></li>');
        } else {
            for(var j = 0; j < rooms.length; j++) {
                if(position == rooms[j] && action == "Drop") {
                    $('.inventoryActions').append('<li><a class="inventoryContentBtn" href="inventoryitemcontroller" action="'+lowerCaseActionName+'Item" number="'+number+'">'+action+'</a></li>');
                }
            }
        }
    }

    function generateActionButtonItem(actions, enabled_actions, itemNumber, position) {
        for(var i = 0;i<actions.length;i++) {
            switch(actions[i]) {
                case "Use":
                    isInventoryActionsAuthorize(enabled_actions[itemNumber].Use, actions[i], position, itemNumber);
                    break;
                case "Inspect":
                    isInventoryActionsAuthorize(enabled_actions[itemNumber].Inspect, actions[i], position, itemNumber);
                    break;
                case "Drop":
                    isInventoryActionsAuthorize(enabled_actions[itemNumber].Drop, actions[i], position, itemNumber);
                    break;
            }
        }
    }

    $(document).on("click", ".inventoryContentBtn", function() {
        $.ajax({
            type: "GET",
            url: "inventoryitemcontroller?action="+$(this).attr('action')+"&number="+$(this).attr('number'),
            datatype: "json",
            data: $(this).serialize(),
            success: function(data) {
                var obj = JSON.parse(data);

                if(obj.info.chooseItem) {
                    var inventoryActions = obj.info.inventory_actions[obj.info.itemNumber];


                    $('.inventoryActions').html('<li>Actions for '+obj.info.inventoryContent[obj.info.itemNumber]+'</li>')

                    generateActionButtonItem(inventoryActions, obj.info.enabled_actions, obj.info.itemNumber, obj.info.move);
                }


                // Inspect Action
                if(obj.info.inspect) {
                    // Display the description of the object when your click on Inspect.
                    alert(obj.info.inspect[obj.info.itemNumber]);
                }

                if(obj.info.dropItem) {
                    var inventoryContent = obj.info.inventoryContent;
                    var inventoryActions = obj.info.inventory_actions;

                    $('.inventoryContent').html('');
                    $('.inventoryActions').html('');

                    for(var i = 0; i < inventoryContent.length; i++) {
                        $('.inventoryContent').append('<li><a class="inventoryContentBtn" href="inventoryitemcontroller" action="item" number="'+i+'">'+obj.info.inventoryContent[i]+'</a></li>');
                    }

                    generateActionButtonItem(inventoryActions, obj.info.enabled_actions, obj.info.itemNumber, obj.info.move);
                }

            },
            error: function() {
                console.log('error');
            }
        });
        return false;
    });
});