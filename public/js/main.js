'use strict';

const brandImageTag = $('#brand-img');
$('.navbar-brand')
    .mouseover(() => brandImageTag.attr('src', '/img/podcast-logo-red.png'))
    .mouseleave(() => brandImageTag.attr('src', '/img/podcast-logo-blue.png'));


const toggleColor = $('.toggle-color');
toggleColor.click(function(){
    // main nav-bar
    $('.navbar-default').css('background-color', '#34495e');
    $('body').css('background-color', '#2c3e50');
    $('.panel').css('background-color', '#2c3e50');
    $('.navbar-default .navbar-brand').css('color', '#e74c3c')
    $('.navbar-default .navbar-brand').hover(function(){
        $(this).css('color', '#2980b9')
    }, function(){
        $(this).css('color', '#e74c3c');
    });
    $('.navbar-default .navbar-nav > li > a').css('color', '#e74c3c')
    $('.navbar-default .navbar-nav > li > a').hover(function(){
       $(this).css('color', '#2980b9')
    }, function(){
        $(this).css('color', '#e74c3c');
    });

    // /home
    $('.find-podcast-search').css('background-color', '#34495e');
    $('.find-podcast-search').css('border-bottom:', 'none');
    

    // /podcast/podcastId
    $('.audioplayer').css('color', '#95a5a6');
    $('.audioplayer').css('background', '#34495e');
    $('.audioplayer-time-duration').css('border-right', '1px solid #555');
    $('.audioplayer-playpause').hover(function(){
        $(this).css('background-color', '#2c3e50');
    }, function(){
        $(this).css('background-color', '#34495e');
    });
    $('.audioplayer-volume').hover(function(){
        $(this).css('background-color', '#2c3e50');
    }, function(){
        $(this).css('background-color', '#34495e');
    });
    $('.audioplayer-volume-adjust').css('background-color', '#2c3e50');
    $('.audioplayer-volume-adjust > div').css('background-color', '#2c3e50');
    $('.audioplayer-bar').css('background-color', '#2c3e50');
});
