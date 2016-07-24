'use strict';

const getAudioTag = (mediaUrl, mediaType) => '<audio controls src="' + mediaUrl + '" type="' + mediaType + ' "></audio>';

const removeChildren = (e) => e.children().remove();

const playButton = $('.play-on');
const playerFooter = $('.audioplayer-footer');
playButton.click(function() {
    const mediaUrl = $(this).parent().find('#url').val();
    const mediaType = $(this).parent().find('#type').val();
    removeChildren(playerFooter);
    playerFooter
        .attr('hidden', false)
        .append(getAudioTag(mediaUrl, mediaType));

    $(() => $('audio').audioPlayer());
});

const addPlaceholder = (e, p = '') => $(e).attr('placeholder', p);
const placeholderDefault = 'Search for episode';

const inputFindEpisodes = $('.find-episode-search');

inputFindEpisodes.val('');
addPlaceholder(inputFindEpisodes, placeholderDefault);
inputFindEpisodes
    .click(function() { addPlaceholder(this)})
    .blur(function() { addPlaceholder(this, placeholderDefault) });

const findEpisodesResults = $('.podcasts-episodes');
const handleViewRender = (response) => {
    response.data.forEach((param) => {
        let content = fulfillInputResult(param)
        findEpisodesResults.append(content);
    });
};

inputFindEpisodes.keypress((e) => {
    const KEYBOARD_KEY_ENTER = 13;
    if(e.which != KEYBOARD_KEY_ENTER) {
        return;
    }

    const searchInput = e.currentTarget.value.trim();
    const podcastId = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);

    if (!searchInput || !podcastId) {
        return;
    }

    $.ajax({
        type: 'GET',
        url: 'http://brnpodapi-env.us-east-1.elasticbeanstalk.com/v1/episodes/feedId/' + podcastId + '?term=' + searchInput,
        success: response => {
            removeChildren(findEpisodesResults);
            handleViewRender(response)
        }
    })
});

$('.more-podcasts').click(function(){
    const offset = $(this).val();
    $.ajax({
        type: 'GET',
        url: 'http://brnpodapi-env.us-east-1.elasticbeanstalk.com/v1/episodes/feedId/' + getCurrentUrlId() + '?limit=8&offset=' + offset,
        success: response => {
            removeChildren(findEpisodesResults);
            handleViewRender(response)
            $(this).val(parseInt(offset) + response.data.length);
            if (response.data.length < 8) {
                $(this).attr('hidden', true);
            }
        }
    })
});

const fulfillInputResult = function(response) {
    const header = "<div class='wrapper col-lg-3 col-md-4 col-sm-6 col-xs-12'><div class='card'><div class='card-content'><div class='card__share'><div class='card__social'><a class='share-icon facebook' href='#'><span class='fa fa-facebook'></span></a><a class='share-icon twitter' href='#'><span class='fa fa-twitter'></span></a><a class='share-icon googleplus' href='#'><span class='fa fa-google-plus'></span></a></div><a id='share' class='share-toggle share-icon' href='#'></a></div><article class='card-article'><h4 class='text-left'>";
    const link = "<a href='" + response.link+ "' target='_blank'>" + response.title + '</a>';
    const publishedAt = '<br><small>' + formatDateTime(response.published_date) + '</small></h4>';
    const content = '<p>' + response.content + '</p>';
    const middle = "</article></div><div class='card-play'><button class='btn play-on'><i class='fa fa-play-circle fa-3x play' aria-hidden='true'></i></button>";
    const mediaUrl = "<input type='text' value='" + response.media_url + "' id='url' hidden>";
    const mediaType = "<input type='text' value='" + response.media_type + "' id='type' hidden>";
    const footer = '</div></div></div>';
    return header + link + publishedAt + content + middle + mediaUrl + mediaType + footer;
}

const getCurrentUrlId = function(){
    return window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
}

const formatDateTime = function(string){
    const a = string.split('-');
    const b = a[2].split(' ');
    return b[0] + '/' + a[1] + '/' + a[0] + ' ' + b[1];
};


$('.card__share > a').on('click', function(e){
    e.preventDefault() // prevent default action - hash doesn't appear in url
    $(this).parent().find( 'div' ).toggleClass( 'card__social--active' );
    $(this).toggleClass('share-expanded');
});
$('.twitter').on('click', function(){
    const tweetText = 'Hey!%20Check out this  ' + $(location).attr('href');
    window.open('https://twitter.com/intent/tweet?text=' + tweetText,'', "width=600,height=230");
})
