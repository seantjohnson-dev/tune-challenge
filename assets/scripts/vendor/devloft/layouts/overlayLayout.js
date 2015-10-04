(function ($, win, doc) {
	DevLoft.Layouts.OverlayLayout = DevLoft.Layouts.BaseLayout.extend({
		template: "#overlay-layout-tpl",
		ui: {
			overlayTrigger: ".overlay-trigger",
			overlayRegion: ".overlay-region"
		},
		behaviors: function () {
			var behaviors = {
				overlayableBehavior: {}
			};
			return behaviors;
		},
		regions: function () {
			var regions = {
				overlayRegion: this.ui.regionSelector
			};
			return regions;
		},
		events: function () {
			var evts = {
				"click @ui.overlayTrigger": "showOverlay"
			};
			return evts;
		},
		showOverlay: function () {
			this.triggerMethod("overlay:show", new DevLoft.Views.OverlayView());
		}
	});
})(jQuery, window, document);