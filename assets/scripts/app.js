(function($, win, BB, BBM) {
  var TuneApp = BBM.Application.extend($.extend(true, {}, DevLoft));
  window.App = window.Application = window.Application || new TuneApp();
  App.Data = {}; // For Bootstrapped Data
  $(function($, win) {
    App.on("start", function (options) {
      var resizeTimer;
      $(win).resize(function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
          App.vent.trigger(App.Constants.onResize);
        }, 250);
      });
      $(win).resize();

      BB.history.start({pushState: true});
    });

    // Kick the whole thing off.
    App.start();
  });

})(jQuery, window, Backbone, Marionette);