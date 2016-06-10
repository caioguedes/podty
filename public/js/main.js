'use strict';

const brandImageTag = $('#brand-img');
$('.navbar-brand')
    .mouseover(function() {
        brandImageTag.attr('src', 'podcast-logo-blue.png')
    })
    .mouseleave(function() {
        brandImageTag.attr('src', 'podcast-logo-red.png')
    });

const inputFindPodcast = $('.find-podcast-search');
inputFindPodcast.val('').attr('placeholder', 'Type nerdcast . .').focus();

const findPodcastResults = $('.find-podcast-results');
const handleViewRender = function(response) {
    findPodcastResults.children(this).remove();
    response.forEach(function(param){
        let url = '/podcast/' + param.id;
        let ahref = '<a href="' + url + '" class="feed-url" target="_blank">';
        let name = param.name + ' (' + param.total_episodes + ')';
        let img = '<img src="' + param.thumbnail_100 + '" class="feed-img"> ' + name + ' </a>';

        findPodcastResults.append('<div>' + ahref + img + '</div>');
    });
};

inputFindPodcast.keypress(function(e) {
    if(e.which != 13) {
        return;
    }
    const searchInput = e.currentTarget.value;
    const searchUrl = 'http://brnpodapi-env.us-east-1.elasticbeanstalk.com/v1/feeds/name/' + searchInput;
    $.ajax({
        type: 'GET',
        url: searchUrl,
        success: function(response) {
            handleViewRender(response)
        }
    })
});

