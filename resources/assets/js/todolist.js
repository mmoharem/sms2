$(document).ready(function(){
    var deleteButton = " <a href='' class='tododelete redcolor'><span class='fa fa-remove'></span></a>";
    var editButton = "<a href='' class='todoedit'><span class='fa fa-edit'></span>  | </a>";
    var checkBox = "<input type='checkbox' class='striked ' autocomplete='off' />";
    var checkBoxChecked = "<input type='checkbox' checked class='striked ' autocomplete='off' />";
    var twoButtons = "<div class='col-md-4 col-sm-4 col-xs-4  pull-right showbtns todoitembtns'>" + editButton + deleteButton + "</div>";
    var oneButtons = "<div class='col-md-4 col-sm-4 col-xs-4  pull-right showbtns todoitembtns'>" + deleteButton + "</div>";

    $('#main_input_box').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $(".add_button").click(function(e){
        $('.add_button').attr("disabled", true);
        e.preventDefault();
        e.stopImmediatePropagation();
        if($('#task_description').val().length<2 ||  $("#task_deadline").val().length<10)
        {
            alert("You didn't fill up the form!");
            $('.add_button').attr("disabled", false);
        }
        else {
            $.ajax({
                type: "POST",
                url: "task/create",
                data: $("form#main_input_box").serialize(),
                success: function (id) {
                    var task_from_user = $("#task_from_user").val();
                    if (task_from_user == $("#user_id").val()) {
                        $(".list_of_items").append("<div class='todolist_list showactions list1' id='" + id + "'>  " + "<div class='col-md-8 col-sm-8 col-xs-8 nopadmar custom_textbox1'> <div class='todoitemcheck'>" + checkBox + "</div>" + "<div class='todotext todoitemjs'>" + $("#task_description").val() + " </div> <span class='label label-default'>" + $("#task_deadline").val() + "</span> <span class='label label-info'>" + $("#full_name").val() + "</span></div>" + twoButtons);
                    }
                    $("#task_description").val('');
                    $("#task_deadline").val('');
                    $("#main_input_box").prepend('<div class="alert alert-success fade in">'+
                        '<a title="close" aria-label="close" data-dismiss="alert" class="close" href="#">×</a>'+
                        '<strong>Task</strong> was successful created!</div>');
                    window.setTimeout(function() {
                        $(".alert").alert('close');
                        $('.add_button').attr("disabled", false);
                    }, 2000);
                }
            });
        }
        return false;
    });

    $.ajax({
        type: "GET",
        url: "task/data",
        success: function (result) {
            $.each(result, function (i, item) {
                $('.list_of_items').append("<div class='todolist_list showactions list1' id='"+ item.id +"'>   " +
                    "<div class='col-md-8 col-sm-8 col-xs-8 nopadmar custom_textbox1'> <div class='todoitemcheck'>" + ((item.finished==1)?checkBoxChecked:checkBox) +
                    "</div> <div class='todotext "+ ((item.finished==1)?"strikethrough":"")+" todoitemjs'>" + item.task_description + "</div> <span class='label label-default'>" +
                    item.task_deadline + "</span> <span class='label label-info'>"+ item.task_from+"</span></div>" + ((item.finished==0)?twoButtons:oneButtons));
            });
        }
    });

});

$(document).on('click', '.tododelete', function (e) {
    e.preventDefault();
    var id = $(this).parent().parent().attr('id');
    $(this).closest('.todolist_list').hide("slow", function(){$(this).remove();});
    $.ajax({
        type: "POST",
        url: "task/" + id + "/delete",
        data: { _token: $('meta[name="_token"]').attr('content')},
    });
});
$(document).on('click', '.striked', function (e) {
    var id = $(this).closest('.todolist_list').attr('id');
    var hasClass = $(this).closest('.todolist_list').find('.todotext').hasClass('strikethrough');
    $.ajax({
        type: "POST",
        url: "task/" + id + "/edit",
        data: { _token: $('meta[name="_token"]').attr('content'),'finished':((hasClass)?0:1)},
    });

    $(this).closest('.todolist_list').find('.todotext').toggleClass('strikethrough');
    //$(this).closest('.todolist_list').find('.showbtns').toggle();
    if(hasClass){
        $(this).closest('.todolist_list').find('.todoitembtns').prepend("<a href='' class='todoedit'><span class='fa fa-edit'></span> | </a>");
    }
    else{
        $(this).closest('.todolist_list').find('.todoedit').remove();
    }
});

$(document).on('click', '.todoedit .fa-edit', function (e) {
    e.preventDefault();
    var text = '';
    text = $(this).closest('.todolist_list').find('.todotext').text();
    text = "<textarea name='text' onkeypress='return event.keyCode != 13;' >"+ text+"</textarea>" ;
    $(this).closest('.todolist_list').find('.todotext').html(text);
    $(this).removeClass('fa-edit').addClass('fa-save hidden-xs');
});

$(document).on('click', '.todoedit .fa-save', function (e) {
    e.preventDefault();
    var text1 = $(this).closest('.todolist_list').find("textarea[name='text']").val();
    if(text1 === '') {
        alert('Come on! you can\'t create a todo without title');
        $(this).closest('.todolist_list').find("textarea[name='text']").focus();

        return;
    }
    var id = $(this).closest('.todolist_list').attr('id');
    $.ajax({
        type: "POST",
        url: "task/" + id + "/edit",
        data: { _token: $('meta[name="_token"]').attr('content'),'task_description':text1},
    });
    $(this).closest('.todolist_list').find('.todotext').html(text1);
    $(this).removeClass('fa-save hidden-xs').addClass('fa-edit');
});