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
                } else {
                    $('.allDirections').html("<li><a class='choiceBtn' href='directioncontroller' param='goBack'>Go Back</a></li>");
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