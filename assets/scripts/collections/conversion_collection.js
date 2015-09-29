(function ($, win, BB) {
	App.Collections.ConversionCollection = App.Collections.BaseLogCollection.extend({
		model: App.Models.ConversionModel
	});
	App.Conversions = new App.Collections.ConversionCollection(App.Logs.getAllByType("conversion"));
})(jQuery, window, Backbone);