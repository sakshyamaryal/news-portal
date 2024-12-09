$(document).ready(function() {
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('collapsed');
        $('.content').toggleClass('full-width');
    });

    $('.nav-link[data-toggle="collapse"]').on('click', function() {
        const target = $(this).attr('data-target');
        $(target).collapse('toggle');
    });

    $('.nav-link').on('click', function() {
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
    });
});