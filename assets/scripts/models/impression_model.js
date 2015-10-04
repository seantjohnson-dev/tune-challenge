(function ($, win, BB) {
	App.Models.ImpressionModel = App.Models.LogModel.extend({
		defaults: function () {
			var defs = {
				type: "impression"
			};
			return $.extend(true, {}, App.Models.LogModel.prototype.defaults.apply(this, arguments), defs);
		}
	});
})(jQuery, window, Backbone);