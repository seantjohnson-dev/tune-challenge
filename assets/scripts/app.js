(function($, win, BB, BBM) {
  var TuneApp = BBM.Application.extend($.extend(true, {}, DevLoft));
  window.App = window.Application = window.Application || new TuneApp();
  App.Data = {};
  App.on("start", function (options) {
    var resizeTimer;
    $(win).resize(function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function () {
        App.vent.trigger(App.Constants.onResize);
      }, 250);
      App.vent.trigger(App.Constants.onEveryResize);
    });
    App.logs = new App.Collections.LogCollection();
    App.logs.once("reset", function () {
      App.impressions = new App.Collections.ImpressionCollection(App.logs.getAllByType("impression"));
      App.conversions = new App.Collections.ConversionCollection(App.logs.getAllByType("conversion"));
      App.users = new App.Collections.UserCollection();
      App.users.add(App.Data.Users);
      var mainLayout = new App.Layouts.MainLayout();
      App.bodyRegion.show(mainLayout);
      $(win).resize();
    });
    App.logs.reset(App.Data.Logs);
    BB.history.start({pushState: true});
  });

  
  $(function($, win) {
    // Kick the whole thing off.
    App.addRegions({
      bodyRegion: "#body-region"
    });
    App.start();
  });

})(jQuery, window, Backbone, Marionette);