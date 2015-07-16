var displayFormDuration = 500;

$(document).ready(function() {

    //Show Reply Form
    $('.comment .reply-button').on('click', function(event) {
        event.preventDefault();

       

        var currentForm = $(this).closest('.comment').find('> .reply-form');
        var currentFields = $(currentForm).find('.comment-fields-more');

        $.post("/comments/default/get-form", {reply_to: $(this).attr('data-reply-to')})
                .done(function(data) {
                    $('.comments .reply-form').not($(currentForm)).hide(displayFormDuration);
                    //$('.comments .comment-fields-more').not($(currentFields)).hide(displayFormDuration);
                    $(this).closest('.comment').find('> .reply-form').show(displayFormDuration);

                    $(currentForm).hide().html(data).show(displayFormDuration);

                    //$('.comments .has-error').closest('.comment');
                });





    });

    //Show Username and Email fields in main form
    $('.comments-main-form .field-comment-content').on('click', function(event) {
        event.preventDefault();
        $(this).closest('.comments-main-form').find('.comment-fields-more').show(displayFormDuration);
    });

    //Show Username and Email fields in reply forms
    $('.field-comment-content').on('click', function(event) {
        event.preventDefault();

        var currentForm = $(this).closest('.reply-form');
        var currentFields = $(currentForm).find('.comment-fields-more');

        $('.comments .reply-form').not($(currentForm)).hide(displayFormDuration);
        $('.comments .comment-fields-more').not($(currentFields)).hide(displayFormDuration);
        $(currentFields).show(displayFormDuration);
    });

    //Hide Reply form on Cancel click
    $('.reply-cancel').on('click', function(event) {
        event.preventDefault();
        $(this).closest('.reply-form').hide(displayFormDuration);
    });

});