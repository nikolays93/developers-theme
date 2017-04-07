jq = jQuery.noConflict();
jq(function( $ ) {
	//on.load
  $(function(){

    /*get message (wpcf7)*/
    $( '#get-recall, .product #get-product' ).on('click', function(){
      $('[name="from-page"]').val( $('.entry-title').text() );
      $('[name="from-url"]').val( document.URL );
    });

    $( '.product #get-product' ).on('click', function(){
      var title = $('.product_title').text();
      $( '[name="your-message"]' ).val( 'Доброго времени суток, хочу приобрести '+title+'. \n\nПожалуйста, перезвоните мне.');
    });

    $('body').on('click', '[data-off-click]', function(e) {
      e.preventDefault();
    });
    // jQuery.data-actions (data-target required), for ex:
    // <p data-target="this" data-class-toggle="fixed"> <span data-target="modal" data-action="fadeToggle"> button </span> </p>
    $("body").on("click","[data-target]",function(event){var target=$(this).attr("data-target"),action=$(this).attr("data-action");if(void 0!=action)"this"==target&&(target="'"+target+"'"),eval("$( "+target+" )."+action+"();");else if("this"==target)var $target=$(this);else var $target=$(target);var toggleClass=$(this).attr("data-class-toggle");void 0!=toggleClass&&$target.toggleClass(toggleClass);var textToggle=$(this).attr("data-text-toggle");void 0!=textToggle&&($(this).attr("data-text-toggle",$target.text()),$target.text(textToggle))});
    // end on.load
  });
});