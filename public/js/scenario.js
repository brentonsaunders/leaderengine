$(function() {
    $('#close-button').click(function() {
        $('#add-response').hide();
    });

    let requests = 0;

    $('.num-likes').click(function() {
        if(requests > 0) {
            return false;
        }

        let numLikes = parseInt($(this).text());

        if($(this).parent('.likes').hasClass('liked')) {
            $(this).text(numLikes - 1);

            $(this).parent('.likes').removeClass('liked');
        } else {
            $(this).text(numLikes + 1);

            $(this).parent('.likes').addClass('liked');
        }

        const responseId = $(this).parent('.likes').data('response-id');

        ++requests;

        $.get(
            '?controller=scenarios&action=like',
            {responseId: responseId},
            function(data) {
                --requests;
            }
        );
    });
});