(function ($, win, BB) {
	App.Models.ConversionModel = App.Models.LogModel.extend({
		defaults: function () {
			var defs = {
				type: "conversion"
			};
			return $.extend(true, {}, App.Models.LogModel.prototype.defaults.apply(this, arguments), defs);
		}
	});
})(jQuery, window, Backbone);