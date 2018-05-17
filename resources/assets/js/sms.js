$(document).ready(function () {
    $("#menu").metisMenu();
    $('textarea').not(".no_wysiwyg").summernote({height: 200});
    $('.select2').select2({
        width: '100%',
        theme: 'bootstrap'
    });
    $('#to_email_id').select2({
        width: '100%',
        theme: 'bootstrap',
        placeholder: 'Select'
    });

    $('.tokenfield').tokenfield();

    if ($('#type').val() == 'select' || $('#type').val() == 'radio' || $('#type').val() == 'checkbox'){
        $('.custom-field-option').show();
    }
    else{
        $('.custom-field-option').hide();
        $('#options').val();
    }

    $( "#custom-field-form #type" ).on('change', function() {
        var field = $(this).val();
        if(field == 'select' || field == 'radio' || field == 'checkbox'){
            $('.custom-field-option').show();
        }else {
            $('.custom-field-option').hide();
            $('#options').val();
        }
    });
});