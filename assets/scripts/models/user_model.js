(function ($, win, BB) {
	App.Models.UserModel = App.Models.BaseModel.extend({
		defaults: function () {
			var defs = {
				id: 0,
				name: "",
				avatar: "",
				occupation: "",
				revenue: 0,
				revenue_output: "0",
				impressions: 0,
				impressions_output: "0",
				conversions: 0,
				conversions_output: "0",
				logs: {
					impressions: new App.Collections.ImpressionCollection(App.Impressions.getAllByUserID(this.get('id'))),
					conversions: new App.Collections.ConversionCollection(App.Conversions.getAllByUserID(this.get('id')))
				}
			};
			return $.extend(true, {}, App.Models.BaseModel.prototype.defaults.apply(this, arguments), defs);
		},
		initialize: function (attrs, options) {
			this.options = $.extend(true, this.options, options);
		},
		calcRevenue: function () {
			return this;
		},
		formatRevenue: function () {
			return this;
		},
		formatImpressions: function () {
			return this;
		},
		formatConversions: function () {
			return this;
		}
	});
})(jQuery, window, Backbone);