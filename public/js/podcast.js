'use strict';

const getAudioTag = (mediaUrl, mediaType) => '<audio controls src="' + mediaUrl + '" type="' + mediaType + ' "></audio>';

const removeChildren = (e) => e.children().remove();

const playButton = $('.play');
const playerFooter = $('.audioplayer-footer');
playButton.click(function() {
    const mediaUrl = $(this).find('#url').val();
    const mediaType = $(this).find('#type').val();

    removeChildren(playerFooter);

    playerFooter
        .attr('hidden', false)
        .append(getAudioTag(mediaUrl, mediaType));

    $(() => $('audio').audioPlayer());
});


$(document).ready(function($) {
    $('.card__share > a').on('click', function(e){
        e.preventDefault() // prevent default action - hash doesn't appear in url
        $(this).parent().find( 'div' ).toggleClass( 'card__social--active' );
        $(this).toggleClass('share-expanded');
    });
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
    response.forEach((param) => {
        let content = fulfillInputResult(param)
        findEpisodesResults.append(content);
    });
};

inputFindEpisodes.keypress((e) => {
    const KEYBOARD_KEY_ENTER = 13;
    if(e.which != KEYBOARD_KEY_ENTER) {
        return;
    }
    removeChildren(findEpisodesResults);
    const searchInput = e.currentTarget.value.trim();
    const podcastId = $('#podcast-id').val();

    if (!searchInput || !podcastId) {
        return;
    }
    
    $.ajax({
        type: 'GET',
        url: 'http://brnpodapi-env.us-east-1.elasticbeanstalk.com/v1/episodes/feedId/' + podcastId + '?term=' + searchInput,
        success: response => handleViewRender(response)
    })
});


const fulfillInputResult = function(response) {
    const header = "<div class='wrapper col-lg-3 col-md-4 col-sm-6 col-xs-12'><div class='card radius shadowDepth1'><div class='card__content card__padding'><div class='card__share'><div class='card__social'><a class='share-icon facebook' href='#'><span class='fa fa-facebook'></span></a><a class='share-icon twitter' href='#'><span class='fa fa-twitter'></span></a><a class='share-icon googleplus' href='#'><span class='fa fa-google-plus'></span></a></div><a id='share' class='share-toggle share-icon' href='#'></a></div><article class='card__article'><h2>";
    const link = "<a href='" + response.link+ "' target='_blank'>" + response.title + '</a>';
    const publishedAt = '<br><small>' + formatDateTime(response.published_date) + '</small></h2>';
    const content = '<p>' + response.content + '</p>';
    const middle = "</article></div><div class='card__action'><div class='card__author play'><a class='btn center'><i class='fa fa-play-circle fa-2x play' aria-hidden='true'></i>Play</a>";
    const mediaUrl = "<input type='text' value='" + response.media_url + "' id='url' hidden>";
    const mediaType = "<input type='text' value='" + response.media_type + "' id='type' hidden>";
    const footer = '</div></div></div></div>';
    return header + link + publishedAt + content + middle + mediaUrl + mediaType + footer;
}

const formatDateTime = function(string){
    const a = string.split('-');
    const b = a[2].split(' ');
    return b[0] + '/' + a[1] + '/' + a[0] + ' ' + b[1];
};
