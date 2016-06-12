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
    if(e.which != 13) {
        return;
    }
    const searchInput = e.currentTarget.value;
    $.ajax({
        type: 'GET',
        url: 'http://brnpodapi-env.us-east-1.elasticbeanstalk.com/v1/feeds/name/' + searchInput,
        beforeSend: () => findPodcastResults.children(this).remove(),
        success: response => handleViewRender(response)
    })
});
