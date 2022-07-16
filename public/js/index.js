$(function() {
    $('#menu-button').click(function() {
        $('#app').toggleClass('menu-open');
    });

    $('#close-button, main').click(function() {
        $('#app').removeClass('menu-open');
    });
});