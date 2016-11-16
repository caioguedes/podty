$(window).load(function(){
    renderConnections();
});

function renderConnections() {
    $.ajax({
        url: '/ajax/allFriends',
        success: function success(response) {
            response.forEach(function(friend){
                $('.connect-friends-list').append(renderHTML(friend));
            });
        }
    });
}

function renderHTML(friend) {
    var active = (friend.was_recently_active ? 'on' : 'off');
    var a = '<li class="list-group-item"><span class="pull-left thumb-xs m-t-xs avatar m-l-xs m-r-sm">';
    var b = a + '<img src="https://www.gravatar.com/avatar/' + friend.email_hash + '?d=retro" alt="..." class="img-circle">';
    var c = b + '<i class="' + active + ' b-light right sm"></i></span><div class="clear">';
    var d = c + '<div><a href="/' + friend.profile_url + '">' + friend.username + '</a></div>';

    return d + '<small class="text-muted">'+friend.last_seen+'</small></div></li>';
}


var canSearchForUsers = true;
var inputSearchUser = $('#input-search-user');
inputSearchUser.keypress(function (e) {
    var KEYBOARD_KEY_ENTER = 13;
    if (e.which != KEYBOARD_KEY_ENTER) return;
    findUsers(e.currentTarget.value);
});

$('#btn-search-user').click(function(){
    if (!inputSearchUser.val()) return;
    findUsers(inputSearchUser.val());
});


var searchUsers = $('.search-users');
var searchUsersList = $('.search-users-list');
function findUsers(user){
    if (!user || !canSearchForUsers) return;
    $.ajax({
        url: 'ajax/findUser/' + user.trim(),
        beforeSend: function() {
            canSearchForUsers = false;
            searchUsers.attr('hidden', true);
            searchUsersList.empty();
        },
        complete: function() {
        },
        success: function success(user) {
            if (user) {
                searchUsersList.append(renderHTML(user));
                searchUsers.attr('hidden', false);
                $('.friends-list').css('height', '70%');
            }
            canSearchForUsers = true;
        }
    });
}

$('#clear-search-users').click(function(){
    searchUsers.attr('hidden', true);
    searchUsersList.empty();
    $('.friends-list').css('height', '100%').css('overdlow', 'scroll');
});
