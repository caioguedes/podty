$(document).ready(function(){


  $(document).on('click', '.play-me', function(){

      var audio = document.getElementById('player');

      var source = document.getElementById('source');
      source.src = $(this).find('input').val();

      $('#playing span').text($(this).find('input').attr('data-value'));

      audio.load();
      $('#audio').attr('hidden', false);
      audio.play();
  });
});
