(function ($, win, BB) {
	App.Collections.ConversionCollection = App.Collections.BaseCollection.extend({
		model: App.Models.ConversionModel,
		initialize: function (models, options) {
			App.Collections.LogCollection.prototype.initialize.apply(this, arguments);
		},
		comparator: function (model) {
			return new Date(model.get('time')).getTime();
		}
	});
	
	if (!App.conversions) {
		App.conversions = new App.Collections.ConversionCollection(App.logs.getAllByType("conversion"));
	}
})(jQuery, window, Backbone);