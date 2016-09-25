'use strict';

var getAudioTag = function getAudioTag(mediaUrl, mediaType) {
    return '<audio controls src="' + mediaUrl + '" type="' + mediaType + ' "></audio>';
};

var removeChildren = function removeChildren(e) {
    return e.children().remove();
};

var playButton = $('.play-on');
var playerFooter = $('.audioplayer-footer');
playButton.click(function () {
    var mediaUrl = $(this).parent().find('#url').val();
    var mediaType = $(this).parent().find('#type').val();
    removeChildren(playerFooter);
    playerFooter.attr('hidden', false).append(getAudioTag(mediaUrl, mediaType));

    $(function () {
        return $('audio').audioPlayer();
    });
});

var addPlaceholder = function addPlaceholder(e) {
    var p = arguments.length <= 1 || arguments[1] === undefined ? '' : arguments[1];
    return $(e).attr('placeholder', p);
};
var placeholderDefault = 'Search for episode';

var inputFindEpisodes = $('.find-episode-search');

inputFindEpisodes.val('');
addPlaceholder(inputFindEpisodes, placeholderDefault);
inputFindEpisodes.click(function () {
    addPlaceholder(this);
}).blur(function () {
    addPlaceholder(this, placeholderDefault);
});

var findEpisodesResults = $('.podcasts-episodes');
var handleViewRender = function handleViewRender(response) {
    response.data.forEach(function (param) {
        var content = fulfillInputResult(param);
        findEpisodesResults.append(content);
    });
};

inputFindEpisodes.keypress(function (e) {
    var KEYBOARD_KEY_ENTER = 13;
    if (e.which != KEYBOARD_KEY_ENTER) {
        return;
    }

    var searchInput = e.currentTarget.value.trim();
    var podcastId = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);

    if (!searchInput || !podcastId) {
        return;
    }

    $.ajax({
        url: '/episodes/feed/' + podcastId + '?term=' + searchInput,
        success: function success(response) {
            removeChildren(findEpisodesResults);
            handleViewRender(JSON.parse(response));
        }
    });
});

$('.more-podcasts').click(function () {
    var _this = this;

    var offset = $(this).val();
    $.ajax({
        type: 'GET',
        url: 'http://brnpodapi-env.us-east-1.elasticbeanstalk.com/v1/episodes/feedId/' + getCurrentUrlId() + '?limit=8&offset=' + offset,
        success: function success(response) {
            removeChildren(findEpisodesResults);
            handleViewRender(response);
            $(_this).val(parseInt(offset) + response.data.length);
            if (response.data.length < 8) {
                $(_this).attr('hidden', true);
            }
        }
    });
});

var fulfillInputResult = function fulfillInputResult(response) {
    var header = "<div class='wrapper col-lg-3 col-md-4 col-sm-6 col-xs-12'><div class='card'><div class='card-content'><div class='card__share'><div class='card__social'><a class='share-icon facebook' href='#'><span class='fa fa-facebook'></span></a><a class='share-icon twitter' href='#'><span class='fa fa-twitter'></span></a><a class='share-icon googleplus' href='#'><span class='fa fa-google-plus'></span></a></div><a id='share' class='share-toggle share-icon' href='#'></a></div><article class='card-article'><h4 class='text-left'>";
    var link = "<a href='" + response.link + "' target='_blank'>" + response.title + '</a>';
    var publishedAt = '<br><small>' + formatDateTime(response.published_date) + '</small></h4>';
    var content = '<p>' + response.content + '</p>';
    var middle = "</article></div><div class='card-play'><button class='btn play-on'><i class='fa fa-play-circle fa-3x play' aria-hidden='true'></i></button>";
    var mediaUrl = "<input type='text' value='" + response.media_url + "' id='url' hidden>";
    var mediaType = "<input type='text' value='" + response.media_type + "' id='type' hidden>";
    var footer = '</div></div></div>';
    return header + link + publishedAt + content + middle + mediaUrl + mediaType + footer;
};

var getCurrentUrlId = function getCurrentUrlId() {
    return window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
};


$(document).ready(function(){
    $(document).on('click', '.play-me', function(){
        var audio = document.getElementById('player');
        var source = document.getElementById('source');
        source.src = $(this).find('input').val();

        var inputData = $(this).find('input');

        $('#playing span').text(inputData.attr('data-title'));
        $('.podcast-image').attr('src', inputData.attr('data-image'));
        audio.load();
        $('#audio').attr('hidden', false);
        audio.play();
    });
});




















(function($) {
    $.fn.clickToggle = function(func1, func2) {
        var funcs = [func1, func2];
        this.data('toggleclicked', 0);
        this.click(function() {
            var data = $(this).data();
            var tc = data.toggleclicked;
            $.proxy(funcs[tc], this)();
            data.toggleclicked = (tc + 1) % 2;
        });
        return this;
    };
}(jQuery));

$('.btn-fllw').clickToggle(function(){
    $.ajax({
        url: '/ajax/followPodcast/' + getCurrentUrlId(),
        success: function success() {

        }
    });
    $(this).text('Unfollow');
}, function(){
    $.ajax({
        url: '/ajax/unfollowPodcast/' + getCurrentUrlId(),
        success: function success() {

        }
    });
    $(this).text('Follow');
});



$('.btn-ufllw').clickToggle(function(){
    $.ajax({
        url: '/ajax/unfollowPodcast/' + getCurrentUrlId(),
        success: function success() {

        }
    });
    $(this).text('Follow');
}, function(){
    $.ajax({
        url: '/ajax/followPodcast/' + getCurrentUrlId(),
        success: function success() {

        }
    });
    $(this).text('Unfollow');
})
