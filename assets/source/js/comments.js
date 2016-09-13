var displayFormDuration = 500;

$(document).ready(function () {

    //Show reply form
    $(document).on('click', '.comment .reply-button', function (event) {
        event.preventDefault();
        var currentForm = $(this).closest('.comment').find('> .reply-form');

        $.post(commentsFormLink, {reply_to: $(this).attr('data-reply-to')})
            .done(function (data) {
                $('.comments .reply-form').not($(currentForm)).hide(displayFormDuration);
                $(this).closest('.comment').find('> .reply-form').show(displayFormDuration);
                $(currentForm).hide().html(data).show(displayFormDuration);
            });
    });

    //Show 'username' and 'email' fields in main form and hide all reply forms
    $(document).on('click', '.comments-main-form .field-comment-content', function (event) {
        event.preventDefault();
        $('.comments-main-form').find('.comment-fields-more').show(displayFormDuration);
        $('.reply-form').hide(displayFormDuration);
    });

    //Hide reply form on 'Cancel' click
    $(document).on('click', '.reply-cancel', function () {
        $(this).closest('.reply-form').hide(displayFormDuration);
    });

    //Disable double button submit after submit
    $(document).on('beforeSubmit', ".comments-main-form form, .comment-form form", function (event, messages) {
        $(this).find("[type=submit]").prop('disabled', true);
    });

});
