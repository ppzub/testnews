(function($) {
  Drupal.behaviors.myLogin = {
    attach(context, settings) {
      $("a.mydrop", context)
        .once("myLogin")
        .on("click", function(event) {
          event.preventDefault();
          $(this)
            .parent()
            .find(".dropdown-menu")
            .first()
            .toggle();
          // Hide menu when clicked outside
          $(this)
            .parent()
            .find(".dropdown-menu")
            .mouseleave(function() {
              const thisUI = $(this);
              $("html").click(() => {
                thisUI.hide();
                $("html").unbind("click");
              });
            });
        });
    }
  };
})(jQuery, Drupal);
