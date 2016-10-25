'use strict';

$(window).load(function(){
    getHome();
    (function() {$.ajax({url: '/ajax/touchUser'});})()
});


var removeChildren = function(e) {
    return e.children().remove()
};

var canSearchForPodcasts = true;
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

    if (!searchInput || !canSearchForPodcasts) {
        return;
    }

    $.ajax({
        url: 'feed/' + encodeURI(searchInput.trim()),
        beforeSend: function() {
            $('#home-title').text('Discover Podcasts');
            removeChildren(findPodcastResults);
            showLoader(true);
            canSearchForPodcasts = false;
        },
        complete: function() {
            showLoader(false)
        },
        success: function success(response) {
            canSearchForPodcasts = true;
            return handleViewRender(JSON.parse(response));
        },
        error: function(a, b, c){
        }
    });
};


function handleViewRender(response) {
    response.data.forEach(function (param) {
        var a = '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="item"><div class="pos-rlt"><div class="bottom"><span class="badge bg-info m-l-sm m-b-sm">' +  param.total_episodes +  '</span></div><div class="item-overlay opacity r r-2x bg-black"><div class="center text-center m-t-n"><a href="podcast/'+param.id+'"><i class="icon-action-redo i-2x"></i></a></div><div class="bottom padder m-b-sm"><a href="#" class="pull-right"><i class="fa fa-plus-circle"></i></a></div></div><a href="#">';
        var b = a + '<img src="' + param.thumbnail_600 + '" class="r r-2x img-full"></a></div><div class="padder-v" style="padding-top: 5px"><a href="/podcast/' + param.id + '" class="text-ellipsis">' + param.name + '</a></div></div></div>';
        findPodcastResults.append(b);
    });
}

function showLoader(flag) {
    $('#loading').attr('hidden', !flag);
}


function getHome(){
    $.ajax({
        url: 'ajax/home',
        beforeSend: function() {
            showLoader(true)
        },
        success: function success(response) {
            showLoader(false);
            $('#home-title').text(response.type == 'no-feeds' ? 'Top Podcasts' : 'Your Library');
            return handleViewRenderHome(response.content);
        },
        error: function(){
            findPodcastResults.append('<div class="col-lg-12 col-md-6 col-sm-12"><p>service not available.</p></div>');
        }
    });
}

function handleViewRenderHome(response) {
    response.forEach(function (param) {
        var a = '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="item"><div class="pos-rlt"><div class="bottom"><span class="badge bg-info m-l-sm m-b-sm">'+param.total_episodes + ' Episodes</span></div><div class="item-overlay opacity r r-2x bg-black">';
        var b = a + '<div class="center text-center m-t-n"><a href="/podcast/'+param.id+'"><i class="icon-action-redo i-2x"></i></a></div></div>';
        var c = b + '<a href="#"><img src="'+param.thumbnail_600+'" class="r r-2x img-full"></a></div><div class="padder-v">';
        var d = c + '<a href="/podcast/'+param.id+'" class="text-ellipsis">' + param.name + '</a>';
        var e = d + '<a href="/podcast/'+param.id+'" class="text-ellipsis text-xs text-muted"></a></div></div></div>';
        findPodcastResults.append(e);
    });
}
