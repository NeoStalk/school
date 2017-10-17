(function ($) {
  Drupal.behaviors.school = {
    attach : function(context, settings) {

 $(function() {
    var $affixElement = $('div[data-spy="affix"]');
    $affixElement.width($affixElement.parent().width());
 });


 $(window).resize(function() {
    var $affixElement = $('div[data-spy="affix"]');
    $affixElement.width($affixElement.parent().width());
 });

/*
 $(function() {
    var $arrowElement = $('.list-group-parent-link[aria-expanded="true"]');
    $arrowElement..addClass("fa-minus-square-o");
 });
*/

/*
     $(document).ready(function () {
        
      $('.collapse').on('show.bs.collapse', function (e) {
      $('.collapse').not(e.target).removeClass('in');
      });         


     });
*/

    }
  };
})(jQuery);


