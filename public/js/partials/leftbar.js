$(window).load(function(){
    setInterval(function(){
        (function() {$.ajax({url: '/ajax/touchUser'});})()
    }, 20000);
});
