(function ($, win, doc) {
	DevLoft.Behaviors.OverlayBehavior = DevLoft.Behaviors.BaseBehavior.extend({
		ui: {
			close: ".overlay-close"
		},
		events: {
			"click @ui.close": "onOverlayClose"
		},
		onOverlayClose: function () {
			DevLoft.Radio.commands.execute("global", "mask:close");
		}
	});
})(jQuery, window, document);