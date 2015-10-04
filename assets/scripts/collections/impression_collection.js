(function ($, win, BB) {
	App.Collections.ImpressionCollection = App.Collections.BaseLogCollection.extend({
		model: App.Models.ImpressionModel
	});
	App.Impressions = new App.Collections.ImpressionCollection(App.Logs.getAllByType("impression"));
})(jQuery, window, Backbone);