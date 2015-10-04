(function ($, win, doc) {
	DevLoft.Radio.connectCommands = function(channelName, commands, context) {
	    var boundCommands = Marionette.normalizeMethods.call(context, commands);
	    Radio.channel(channelName).connectCommands(boundCommands, context);
	};

	DevLoft.Behaviors.OverlayableBehavior = DevLoft.Behaviors.BaseBehavior.extend({
		ui: {
			mask: "#mask"
		},
		globalCommands: {
			"overlay:show": "onOverlayShow",
			"overlay:close": "onOverlayClose"
		},
		events: {
			"click @ui.mask": "onOverlayClose"
		},
		initialize: function () {
			DevLoft.Radio.connectCommands("global", this.globalCommands, this);
		},
		onOverlayShow: function (overlay) {
			this.ui.mask.show();
			this.view.OverlayRegion.show(overlay);
		},
		onOverlayClose: function () {
			this.ui.mask.hide();
			this.view.OverlayRegion.close();
		}
	});
})(jQuery, window, document);