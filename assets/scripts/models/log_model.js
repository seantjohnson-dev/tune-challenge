(function ($, win, BB) {
	App.Models.LogModel = App.Models.BaseModel.extend({
		defaults: function () {
			var defs = {
				time: "",
				type: "",
				user_id: 0,
				revenue: 0
			};
			return $.extend(true, {}, App.Models.BaseModel.prototype.defaults.apply(this, arguments), defs);
		}
	});
})(jQuery, window, Backbone);