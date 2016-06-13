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
