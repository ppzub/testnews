(function($) {
  Drupal.behaviors.myFirstMenu = {
    attach(context, settings) {
      $("a[data-cat='13']", context).addClass('yel_a_main').once("myFirstMenu");
      $("a[data-cat='14']", context).addClass('yel_a_main avers').once("myFirstMenu");
      $("a[data-cat='42']", context).addClass('red_a_main').once("myFirstMenu");
      $("a[data-cat='43']", context).addClass('red_a_main mandrosvit').once("myFirstMenu");
    }
  };
})(jQuery, Drupal);