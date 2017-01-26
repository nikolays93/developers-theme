jq = jQuery.noConflict();
jq(function( $ ) {
	//on.load
  $(function(){
  	/* back to top button */
  	var offset = 200;
  	var selector = '.back-top';
  	
  	$(window).scroll(function() {
  		if ($(this).scrollTop() > offset) {
  			$(selector).fadeIn(400);
  		} else {
  			$(selector).fadeOut(400);
  		}
  	});
  	$(selector).click(function(event) {
  		event.preventDefault();
  		$('html, body').animate({scrollTop: 0}, 600);
  		return false;
  	});

    /*get message (wpcf7)*/
    $( '#get-recall, #get-product' ).on('click', function(){
      $('[name="from-page"]').val( $('.entry-title').text() );
      $('[name="from-url"]').val( document.URL );
    });

    $( '#get-product' ).on('click', function(){
      var title = $('.product_title').text();
      // var params = '';
      // var n = 1;
      // $('.variations tr').each(function(i){
      //   var key = $('label', this).text();
      //   var $val = $('select option:selected', this);
      //   if ($val.val() != 'undefined' && $val.val() != ''){
      //     params+= n+'. '+key+': '+$val.text()+'.\n';
      //     n++;
      //   }
      // });
      $( '[name="your-message"]' ).val( 'Доброго времени суток, хочу приобрести '+title+'. \n\nПожалуйста, перезвоните мне.');
      //\n\n Выбраные параметры:\n'+params )
    });

    // end on.load
  });
});