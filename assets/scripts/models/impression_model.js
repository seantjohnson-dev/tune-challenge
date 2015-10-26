(function ($, win, BB) {
	App.Models.ImpressionModel = App.Models.LogModel.extend({
		logType: "impression",
		defaults: function () {
			var defaults = {
				type: this.logType
			};
			return $.extend(true, {}, App.Models.LogModel.prototype.defaults.apply(this, arguments), defaults);
		},
		initialize: function (attributes, options) {
			App.Models.LogModel.prototype.initialize.apply(this, arguments);
		}
	});
})(jQuery, window, Backbone);