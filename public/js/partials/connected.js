$(window).load(function(){
    renderConnections();
});


function renderConnections() {
    $.ajax({
        url: '/ajax/allFriends',
        success: function success(response) {
            renderHTML(response)
        }
    });
}

function renderHTML(data) {

    var list = $('.connect-friends-list');

    data.forEach(function(friend){
        var a = '<li class="list-group-item"><span class="pull-left thumb-xs m-t-xs avatar m-l-xs m-r-sm">';
        var b = a + '<img src="https://www.gravatar.com/avatar/' + friend.email_hash + '?d=retro" alt="..." class="img-circle">';
        var c = b + '</span><div class="clear">';
        var d = c + '<div><a href="/' + friend.profile_url + '">' + friend.username + '</a></div>';
        var e = d + '<small class="text-muted">Coffee</small></div></li>';
        list.append(e);
    });



}

