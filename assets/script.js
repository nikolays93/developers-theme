jq = jQuery.noConflict();
jq(function( $ ) {
  //on.load
  $(function(){
    /*!
     * Script name: data-actions
     * Script URI: https://github.com/nikolays93/jquery.data-actions/
     * Version: 1.0b
     */
    function replaceTextOnly(t,a,e){for(var r=t.get(0),o=r.childNodes,l=0;l<o.length;l++)3==o[l].nodeType&&(o[l].textContent?o[l].textContent=o[l].textContent.replace(a,e):o[l].nodeValue=o[l].nodeValue.replace(a,e))}function doAction($obj,target,trigger){var evalTarget="this"!==target?"'"+target+"'":"this",loadAction=$obj.data("load-action"),props=$obj.data("props");loadAction&&eval("$( "+evalTarget+" )."+loadAction+"("+props+");"),$obj.on(trigger,function(event){var toggleClass=$(this).attr("data-toggle-class");toggleClass&&$(target).toggleClass(toggleClass);var wrap=$(this).data("wrapper");if(!wrap||event.target===this){var allowClick=$(this).data("allow-click");allowClick||"click"!=trigger||event.preventDefault();var props=$obj.data("props"),action=$(this).data("action");action&&eval("$( "+evalTarget+" )."+action+"("+props+");")}})}function textRepalce(t){$wasObj=t;var a=t.attr("data-text-replace"),e=t.attr("data-text-replace-to"),r=t.data("target");if(r&&(t=$(r)),a&&e)t.attr("data-text-replaced")?(replaceTextOnly(t,e,a),t.removeAttr("data-text-replaced")):(replaceTextOnly(t,a,e),t.attr("data-text-replaced","true"));else{var o=t.text();$wasObj.attr("data-text-replace",o),t.text(a)}}$("[data-target]").each(function(t,a){$this=$(a);var e=($this.data("action"),$this.data("target")),r=$this.data("trigger");r||(r="click"),doAction($(this),e,r),$(this).children("[data-action]").each(function(){doAction($(this),e,r)})}),$("[data-text-replace]").each(function(t,a){var e=$(this).data("trigger");e||(e="click"),"load"==e?textRepalce($(this)):$(this).on(e,function(){textRepalce($(this))})});
    
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

