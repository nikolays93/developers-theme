jq = jQuery.noConflict();
jq(function( $ ) {
  //on.load
  $(function(){
    $('body').on('click', '[data-off-click]', function(e) {
      e.preventDefault();
    });
    /*!
     * Script name: data-actions
     * Script URI: https://github.com/nikolays93/jquery.data-actions/
     */
    function replaceTextOnly(a,b,c){for(var d=a.get(0),e=d.childNodes,f=0;f<e.length;f++)3==e[f].nodeType&&(e[f].textContent?e[f].textContent=e[f].textContent.replace(b,c):e[f].nodeValue=e[f].nodeValue.replace(b,c))}$("[data-target]").each(function(index,el){var trigger=$(this).attr("data-trigger"),target=$(this).attr("data-target"),action=$(this).attr("data-action"),loadAction=$(this).attr("data-load-action");trigger||(trigger="click"),target="this"!==target?"'"+target+"'":"this",loadAction&&eval("$( "+target+" )."+action+"();"),$(this).on(trigger,function(event){var $target=$(this);action&&eval("$( "+target+" )."+action+"();");var toggleClass=$(this).attr("data-class-toggle");toggleClass&&$target.toggleClass(toggleClass);var textReplace=$(this).attr("data-text-replace"),textReplaceTo=$(this).attr("data-text-replace-to");textReplace&&textReplaceTo?$(this).attr("data-text-replaced")?(replaceTextOnly($target,textReplaceTo,textReplace),$(this).removeAttr("data-text-replaced")):(replaceTextOnly($target,textReplace,textReplaceTo),$target.attr("data-text-replaced","true")):textReplace&&($(this).attr("data-text-replace",$target.text()),$target.text(textReplace))})});
    
    /*get message (wpcf7)*/
    $( '#get-recall, .product #get-product' ).on('click', function(){
      $('[name="from-page"]').val( $('.entry-title').text() );
      $('[name="from-url"]').val( document.URL );
    });

    $( '.product #get-product' ).on('click', function(){
      var title = $('.product_title').text();
      $( '[name="your-message"]' ).val( 'Доброго времени суток, хочу приобрести '+title+'. \n\nПожалуйста, перезвоните мне.');
    });
  });
});

