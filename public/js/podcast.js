'use strict';

function getCurrentUrlId(){
    return window.location.href.substring(window.location.href.lastIndexOf('/')+1).replace('#', '');
}

(function($){$.fn.clickToggle=function(func1,func2){var funcs=[func1,func2];this.data('toggleclicked',0);this.click(function(){var data=$(this).data();var tc=data.toggleclicked;$.proxy(funcs[tc],this)();data.toggleclicked=(tc+1)%2;});return this;};}(jQuery));

$(document).ready(function() {
    var page = 1;
    var stopRetrieving = false;

    if (screen.width >= 800) {
        $('#podcast-list').on('scroll', function() {
            if(!stopRetrieving && $(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                getMoreEpisodes()
            }
        });
    } else {
        var win = $(window);
        win.scroll(function() {
            if(!stopRetrieving && $(document).height() - win.height() == win.scrollTop()) {
                getMoreEpisodes()
            }
        });
    }

    function getMoreEpisodes(){
        $.ajax({
            method: 'GET',
            url: '/ajax/moreEpisodes/' + getCurrentUrlId() + '/' + page++,
            success: function(res) {
                renderPodcastView(res);
                stopRetrieving = false;
            },
            beforeSend: function(){
                stopRetrieving = true;
            },
            error: function(){
                stopRetrieving = true;
            }
        });
    }

    var updatingCurrentTimeId = 0;
    var lastCurrentTime = 0;
    $(document).on('click', '.play-me', function(){

        var audio = document.getElementById('player');
        var source = document.getElementById('source');
        source.src = $(this).find('input').val();

        var inputData = $(this).find('input');

        $('#playing span').text(inputData.attr('data-title'));
        $('.podcast-image').attr('src', inputData.attr('data-image'));
        $('.podcast-image-texts').attr('hidden', true);
        audio.load();
        $('#audio').attr('hidden', false);
        $('.musicbar').addClass('animate')
        audio.play();

        /*if (updatingCurrentTimeId) clearInterval(updatingCurrentTimeId);
        updatingCurrentTimeId = setInterval(function(){
            var audioTag = document.getElementsByTagName('audio')[0];

            if (!audioTag.currentSrc) return;

            var currentTime = Math.floor(audioTag.currentTime);
            if (!currentTime) return;
            if (currentTime == lastCurrentTime) return;

            lastCurrentTime = currentTime;

            if (!$('.button-follow button').attr('data-follows')) return false;

            $.ajax({
                url: '/ajax/uptEpisode/' + inputData.attr('data-id') + '/' + currentTime
            });
        }, 25000);*/
    });
});

$('.btn-fllw').clickToggle(function(){
    followCurrentPodcast();
    $(this).text('Unfollow').attr('data-follows', 1);
}, function(){
    unfollowCurrentPodcast();
    $(this).text('Follow').attr('data-follows', 0);;
});
$('.btn-ufllw').clickToggle(function(){
    unfollowCurrentPodcast();
    $(this).text('Follow').attr('data-follows', 1);
}, function(){
    followCurrentPodcast();
    $(this).text('Unfollow').attr('data-follows', 0);
});

function followCurrentPodcast(){
    $.ajax({url: '/ajax/followPodcast/' + getCurrentUrlId()});
}
function unfollowCurrentPodcast(){
    $.ajax({url: '/ajax/unfollowPodcast/' + getCurrentUrlId()});
}

function renderPodcastView(data) {
    data.episodes.map(function(episode){
        $('#podcast-ul').append(render(episode, data.podcast));
    });
}

function render(episode, podcast) {
    return '<li class="list-group-item">'
            + '<div class="pull-right m-l">'
                + '<a href="#" class="m-r-sm m-b-sm btn-fav-ep" data-toggle="class">'
                    + '<i class="fa fa-heart-o text"></i>'
                    + '<i class="fa fa-heart text-active text-danger"></i>'
                + '</a>'
                + '<a href="/episodes/'+ episode.id +'" target="_blank">'
                    + '<i class="icon-action-redo"></i>'
                + '</a>'
            + '</div>'

            + '<a href="#" class="play-me active m-r-sm pull-left" data-toggle="class">'
                + '<input type="hidden" ' +
                    'value="' + episode.media_url + '" ' +
                    'data-title="' + episode.title + '" ' +
                    'data-id="'+ episode.id +'" ' +
                    'data-image="' + (episode.image ? episode.image : podcast.thumbnail_600)
                + '">'
                + '<i class="icon-control-play text-active i-2x"></i>'
                + '<i class="icon-control-pause text  i-2x"></i>'
            + '</a>'

            + '<div class="clear text-ellipsis m-l-xl">'
                + '<span>'
                    + '<a href="#" class="text-ellipsis" data-toggle="modal" data-target="#myModal'+episode.id+'">'
                    + episode.title
                    + '</a>'
                + '</span>'
                + '<span class="text-muted pull-right m-r-lg">'
                    + (!episode.duration ? '' :  episode.duration)
                + '</span>'
            + '</div>'
            + '<div class="m-l-xl m-t-n-sm">'
                + formatDate(episode.published_at)
            + '</div>'
        + '</li>';
}


function formatDate(data)
{
    var dateSplited = data.split(' ')

    var date = dateSplited[0].split('-')
    var time = dateSplited[1].split(':')

    console.log(time)
    return date[2] + '/' + date[1] + '/' + date[0] + ' ' + time[0] + ':' + time[1]
}
