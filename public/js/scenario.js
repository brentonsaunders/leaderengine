$(function() {
    $('#add-response-close-button').click(function() {
        $('#add-response').hide();
    });

    $('#add-response-button').click(function() {
        $('#add-response').show();
        $('#your-response textarea').val('');
        $('#your-response span.error').text('');
        $('#num-chars').text('0/500');
        $('#add-response').removeClass('done');
    });

    $('#add-response form').submit(function(e) {
        e.preventDefault();

        const text = $('#your-response textarea').val();

        if(text.length === 0) {
            $('#your-response span.error').text('You must enter a response');
        } else if(text.length < 50) {
            $('#your-response span.error').text('Your response is too short');
        } else if(text.length > 500) {
            $('#your-response span.error').text('Your response is too long');
        } else {
            $('main').addClass('loading');

            $.post(
                '?controller=scenarios',
                {
                    scenarioId: $('#add-response form').data('scenario-id'),
                    responseId: 'null',
                    fromYou: $('#add-response form').data('from-you'),
                    text: text
                },
                function(data) {
                    $('main').removeClass('loading');

                    $('#add-response').addClass('done');
                }
            );
        }
    });

    $('#your-response textarea').on('change keyup paste', function() {
        const text = $(this).val();
        let length = text.length;
        const max = 500;
        
        $('#num-chars').text(length + '/' + max);

        $('#your-response span.error').text('');

        if(length > 500) {
            $('#your-response').addClass('too-long');
        } else {
            $('#your-response').removeClass('too-long');
        }
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