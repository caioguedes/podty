'use strict';

$(window).load(function(){
    getHome();
    $.ajax({
        url: 'ajax/sidebar',
        success: function success(response) {
            $('#podcasts-count').text(response.podcasts_count || '-');
            $('#friends-count').text(response.friends_count || '-');
        }
    });
});


var removeChildren = function(e) {
    return e.children().remove()
};

var inputFindPodcast = $('#find-cast');
var btnFindPodcast = $('.btn-find-cast');
var findPodcastResults = $('.podcasts-episodes-home');

inputFindPodcast.keypress(function (e) {
    var KEYBOARD_KEY_ENTER = 13;
    if (e.which != KEYBOARD_KEY_ENTER) {
        return;
    }
    findPodcast(e.currentTarget.value);
});

btnFindPodcast.click(function(){
    if (!inputFindPodcast.val()) {
        return;
    }
    findPodcast(inputFindPodcast.val())
});


var findPodcast = function(searchInput){

    if (!searchInput) {
        return;
    }

    searchInput = searchInput.trim();

    $.ajax({
        url: 'feed/' + searchInput,
        beforeSend: function() {
            $('#home-title').text('Discover Podcasts')
            removeChildren(findPodcastResults)
            showLoader(true)
        },
        complete: function() {
            showLoader(false)
        },
        success: function success(response) {
            return handleViewRender(JSON.parse(response));
        },
        error: function(a, b, c){
            console.log(a, b, c)
        }
    });
};


var handleViewRender = function handleViewRender(response) {
    response.data.forEach(function (param) {
        var a = '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="item"><div class="pos-rlt"><div class="bottom"><span class="badge bg-info m-l-sm m-b-sm">' +  param.total_episodes +  '</span></div><div class="item-overlay opacity r r-2x bg-black"><div class="center text-center m-t-n"><a href="#"><i class="icon-control-play i-2x"></i></a></div><div class="bottom padder m-b-sm"><a href="#" class="pull-right"><i class="fa fa-plus-circle"></i></a></div></div><a href="#">';
        var b = a + '<img src="' + param.thumbnail_600 + '" class="r r-2x img-full"></a></div><div class="padder-v" style="padding-top: 5px"><a href="/podcast/' + param.id + '" class="text-ellipsis">' + param.name + '</a></div></div></div>';
        findPodcastResults.append(b);
    });
};

function showLoader(flag) {
    $('#loading').attr('hidden', !flag);
}


function getHome(){
    $.ajax({
        url: 'ajax/home',
        beforeSend: function() {
            showLoader(true)
        },
        complete: function() {
            showLoader(false)
        },
        success: function success(response) {
            return handleViewRenderHome(response);
        },
        error: function(){
            findPodcastResults.append('<div class="col-lg-12 col-md-6 col-sm-12"><p>service not available.</p></div>');
        }
    });
}

function handleViewRenderHome(response) {
    response.forEach(function (param) {
        var a = '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="item"><div class="pos-rlt"><div class="bottom"><span class="badge bg-info m-l-sm m-b-sm">03:20</span></div><div class="item-overlay opacity r r-2x bg-black"><div class="center text-center m-t-n"><a href="#"><i class="icon-control-play i-2x"></i></a></div></div><a href="#">';
        var b = a + '<img src="'+param.thumbnail+'" class="r r-2x img-full"></a></div><div class="padder-v">';
        var c = b + '<a href="#" class="text-ellipsis">' + param.title + '</a>';
        var d = c + '<a href="/podcast/'+param.podcast_id+'" class="text-ellipsis text-xs text-muted">'+param.podcast_name+'</a></div></div></div>';
        findPodcastResults.append(d);
    });
}

