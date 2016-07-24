'use strict';

var addPlaceholder = function addPlaceholder(e) {
    var p = arguments.length <= 1 || arguments[1] === undefined ? '' : arguments[1];
    return $(e).attr('placeholder', p);
};
var placeholderDefault = 'Type nerdcast . .';

var inputFindPodcast = $('.find-podcast-search');

inputFindPodcast.val('');
addPlaceholder(inputFindPodcast, placeholderDefault);
inputFindPodcast.focus().click(function () {
    addPlaceholder(this);
}).blur(function () {
    addPlaceholder(this, placeholderDefault);
});

var findPodcastResults = $('.find-podcast-results');
var handleViewRender = function handleViewRender(response) {

    response.data.forEach(function (param) {
        var url = '/podcast/' + param.id;
        var ahref = '<a href="' + url + '" target="_blank">';
        var name = '<span>' + param.name + ' (' + param.total_episodes + ')' + '</span>';
        var img = '<img src="' + param.thumbnail_100 + '"> ' + name + ' </a>';

        findPodcastResults.append('<li>' + ahref + img + '</li>');
    });
};

inputFindPodcast.keypress(function (e) {
    var KEYBOARD_KEY_ENTER = 13;
    if (e.which != KEYBOARD_KEY_ENTER) {
        return;
    }
    findPodcastResults.children(undefined).remove();
    var searchInput = e.currentTarget.value.trim();
    if (!searchInput) {
        return;
    }

    $.ajax({
        url: 'feed/' + searchInput,
        success: function success(response) {
            return handleViewRender(JSON.parse(response));
        },
        error: function(a, b, c){
            console.log(a, b, c)
        }
    });
});
