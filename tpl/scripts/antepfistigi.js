/**
 * @category    Interface
 * @package     psdup
 * @author	    Bilal Cinarli
 * @copyright	2011 Bilal Cinarli
 * @license     default
 * @version
 * @filesource
 * @link        http://bcinarli.com
 * @see
 * @since
 **/

 $(function(){
    $("#tagline").nivoSlider({directionNav: false});

    $("#q").formFocus();
 });

(function($){
    $.fn.formFocus = function(options){
        return this.each(function(){
           var $el = $(this);
           var $label = $("label[for=" + $el.attr('id') + "]");

           if($el.val() != ''){
                $label.hide();
           }

           $el.focus(function(){
                $label.hide();
           });

           $el.blur(function(){
                if($el.val() == ''){
                    $label.show();
                }
           });
        });
    }
})(jQuery);