(function($) {
    $.fn.clickToggle = function(func1, func2) {
        var funcs = [func1, func2];
        this.data('toggleclicked', 0);
        this.click(function() {
            var data = $(this).data();
            var tc = data.toggleclicked;
            $.proxy(funcs[tc], this)();
            data.toggleclicked = (tc + 1) % 2;
        });
        return this;
    };
}(jQuery));

function getUser() {
    return removeLastSlashChar(window.location.href.substring(removeLastSlashChar(window.location.href).lastIndexOf('/') + 1))
}

function removeLastSlashChar(string){
    return string.replace(/\/$/, '');
}

$('.btn-fllw').clickToggle(function(){
    $.ajax({
        url: '/ajax/followUser/' + getUser(),
        success: function success() {

        }
    });
    $(this).text('Unfollow');
}, function(){
    $.ajax({
        url: '/ajax/unfollowUser/' + getUser(),
        success: function success() {

        }
    });
    $(this).text('Follow');
});



$('.btn-ufllw').clickToggle(function(){
    $.ajax({
        url: '/ajax/unfollowUser/' + getUser(),
        success: function success() {

        }
    });
    $(this).text('Follow');
}, function(){
    $.ajax({
        url: '/ajax/followUser/' + getUser(),
        success: function success() {

        }
    });
    $(this).text('Unfollow');
});
