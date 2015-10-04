(function ($, win, doc) {
    DevLoft.Views.OverlayView = Marionette.LayoutView.extend($.extend(true, {}, DevLoft.Base, {
    	template: "#overlay-view-tpl",
        behaviors: {
            OverlayBehavior: {}
        }
    }));
})(jQuery, window, document); 

