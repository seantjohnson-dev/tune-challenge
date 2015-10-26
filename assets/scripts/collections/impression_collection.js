(function ($, win, BB) {
	App.Collections.ImpressionCollection = App.Collections.BaseCollection.extend({
		model: App.Models.ImpressionModel,
		initialize: function (models, options) {
			App.Collections.LogCollection.prototype.initialize.apply(this, arguments);
		},
		comparator: function (model) {
			return new Date(model.get('time')).getTime();
		}
	});
	if (!App.impressions) {
		App.impressions = new App.Collections.ImpressionCollection(App.logs.getAllByType("impression"));	
	}
})(jQuery, window, Backbone);