$(function () {
    function capitalize(string) {
        return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
    }

    $(document).on("click", ".choiceBtn", function() {
        $.ajax({
            type: "GET",
            url: "directioncontroller?move="+$(this).attr('param'),
            datatype: "json",
            data: $(this).serialize(),
            success: function(data) {
                var obj = JSON.parse(data);
                $('.allDirections').empty();

                if(obj.info.move == "initial") {
                    var buttons = obj.info.buttons;
                    $('.allDirections').empty();
                    $('.actions').empty();
                    for (var key in buttons) {
                        if (buttons.hasOwnProperty(key)) {
                            if(key != "initial") {
                                $('.allDirections').append("<li id='"+key+"'><a class='choiceBtn' href='directioncontroller' param='"+key+"'><img src='"+key+"' alt='"+buttons+"'></a></li>");
                            }
                        }
                    }
                    if(obj.info.inventory) {
                        $('.actions').append("<div><a class='inventoryBtn' href='inventorycontroller' param='open'>Open Inventory</a></div>");
                    }
                } else {
                    if(obj.info.inventory) {
                        $('.actions').html("<div><a class='inventoryBtn' href='inventorycontroller' param='open'>Open Inventory</a></div>");
                    }
                    $('.actions').append("<div id='"+key+"'><a class='choiceBtn' href='directioncontroller' param='goBack'>Go Back</a></div>");
                }
                $('.message-box').html('<p>'+obj.info.message+'</p>');
            },
            error: function() {
                console.log('error');
            }
        });
        return false;
    });
});