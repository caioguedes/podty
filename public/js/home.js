'use strict';

const addPlaceholder = (e, p = '') => $(e).attr('placeholder', p);
const placeholderDefault = 'Type nerdcast . .';

const inputFindPodcast = $('.find-podcast-search');

inputFindPodcast.val('');
addPlaceholder(inputFindPodcast, placeholderDefault);
inputFindPodcast
    .focus()
    .click(function() { addPlaceholder(this)})
    .blur(function() { addPlaceholder(this, placeholderDefault) });

const findPodcastResults = $('.find-podcast-results');
const handleViewRender = (response) => {
    response.forEach((param) => {
        let url = '/podcast/' + param.id;
        let ahref = '<a href="' + url + '" target="_blank">';
        let name = '<span>' + param.name + ' (' + param.total_episodes + ')' + '</span>';
        let img = '<img src="' + param.thumbnail_100 + '"> ' + name + ' </a>';

        findPodcastResults.append('<li>' + ahref + img + '</li>');
    });
};

inputFindPodcast.keypress((e) => {
    const KEYBOARD_KEY_ENTER = 13;
    if(e.which != KEYBOARD_KEY_ENTER) {
        return;
    }
    findPodcastResults.children(this).remove()
    const searchInput = e.currentTarget.value.trim();
    if (!searchInput) {
        return;
    }
    
    $.ajax({
        type: 'GET',
        url: 'http://brnpodapi-env.us-east-1.elasticbeanstalk.com/v1/feeds/name/' + searchInput,
        success: response => handleViewRender(response)
    })
});
