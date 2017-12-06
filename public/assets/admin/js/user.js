// hack -> User can select only one role "Editor"

$("#is_editor").change(function () {
    if ($(this).is(':checked')) {
        $("#is_author, #is_admin, #is_executive_editor, #is_directory_editor").prop("checked", false);
    }
});

$("#is_executive_editor").change(function () {
    if ($(this).is(':checked')) {
        $("#is_author, #is_admin, #is_editor, #is_directory_editor").prop("checked", false);
    }
});


$("#is_directory_editor").change(function () {
    if ($(this).is(':checked')) {
        $("#is_author, #is_admin, #is_editor, #is_executive_editor").prop("checked", false);
    }
});

$("#is_author, #is_admin").change(function () {
    if ($(this).is(':checked')) {
        $("#is_editor, #is_executive_editor, #is_directory_editor").prop("checked", false);
    }
});

//image preview

var imagePreview = $('#current-user-image').removeClass('hide').prop('outerHTML');

if (imagePreview) {
    $('#current-user-image').addClass('hide');
    $("input[name='new-image']").fileinput(
        {
            initialPreview: [
                imagePreview
            ]
        }
    );
}
