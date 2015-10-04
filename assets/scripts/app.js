(function($, win, BB, BBM) {
  var TuneApp = BBM.Application.extend($.extend(true, {}, DevLoft));
  window.App = window.Application = window.Application || new TuneApp();
  App.Data = {}; // For Bootstrapped Data
  $(function($, win) {
    App.on("start", function (options) {
      if (BB.history) {
        BB.history.start({pushState: true});
      }
    });
    App.start();
    var resizeTimer;
    $(win).resize(function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function () {
        App.vent.trigger(App.Constants.onResize);
      }, 250);
    });
    $(win).resize();
  });

})(jQuery, window, Backbone, Marionette);