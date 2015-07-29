var displayFormDuration = 500;

$(document).ready(function () {

    //Show reply form
    $('.comment .reply-button').on('click', function (event) {
        event.preventDefault();
        var currentForm = $(this).closest('.comment').find('> .reply-form');

        $.post("/comments/default/get-form", {reply_to: $(this).attr('data-reply-to')})
            .done(function (data) {
                $('.comments .reply-form').not($(currentForm)).hide(displayFormDuration);
                $(this).closest('.comment').find('> .reply-form').show(displayFormDuration);
                $(currentForm).hide().html(data).show(displayFormDuration);
            });
    });

    //Show 'username' and 'email' fields in main form and hide all reply forms
    $('.comments-main-form .field-comment-content').on('click', function (event) {
        event.preventDefault();
        $('.comments-main-form').find('.comment-fields-more').show(displayFormDuration);
        $('.reply-form').hide(displayFormDuration);
    });

    //Hide reply form on 'Cancel' click
    $(document).on('click', '.reply-cancel', function () {
        $(this).closest('.reply-form').hide(displayFormDuration);
    });

});