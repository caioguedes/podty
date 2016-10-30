$(window).load(function(){
    renderSideBar();
    setInterval(function(){
        (function() {$.ajax({url: '/ajax/touchUser'});})()
    }, 20000);
});

function renderSideBar() {
    $.ajax({
        url: '/ajax/sidebar',
        success: function success(response) {
            $('#podcasts-count').text(response.podcasts_count || '-');
            $('#friends-count').text(response.friends_count || '-');
        }
    });
}
