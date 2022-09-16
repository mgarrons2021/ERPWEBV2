
    let checkbox = document.getElementsByClassName("form-check-control");
    let pivot = $('#pivot').val();
    let Json_pivot = JSON.parse(pivot);
    console.log(Json_pivot)
    arrayCheckBox = []
    arrayIndex = []

    $(".form-check-control").attr('checked', false);
    $(".form-check-control").attr('disabled', false);

    if (Json_pivot === 0) {
        $(".form-check-control").attr('checked', false);
        $(".form-check-control").attr('disabled', false);
    }
    for (let i in checkbox) {
        if (checkbox[i].value != undefined) {
            arrayCheckBox.push(checkbox[i].value)
            arrayIndex.push(i)
        }
    }
    //console.log(arrayCheckBox)
    for (let j in Json_pivot) {
        for (let i in arrayCheckBox) {
            if (arrayCheckBox[i] == Json_pivot[j].tarea_id) {
                console.log(checkbox[i].value)
                checkbox[i].checked = true;
                checkbox[i].disabled = true;
            }
        }
    }

    $(document).ready(function() {

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;

        setProgressBar(current);

        $(".next").click(function() {

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(++current);
        });

        $(".previous").click(function() {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(--current);
        });

        function setProgressBar(curStep) {
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
                .css("width", percent + "%")
        }

        $(".submit").click(function() {
            return false;
        })

    });
