(function ($, win, BB) {
	
	var typeFilterFunc = function (type) {
		return (function (model) {
			return (model.get("type").toLowerCase() === type.toLowerCase());
		});
	};

	App.Collections.LogCollection = App.Collections.BaseCollection.extend({
		model: App.Models.LogModel,
		initialize: function (models, options) {
			App.Collections.BaseCollection.prototype.initialize.apply(this, arguments);
		},
		getFirstByType: function (type) {
			return this.find(typeFilterFunc(type));
		},
		getAllByType: function (type) {
			return this.filter(typeFilterFunc(type));
		}
	});
	if (!App.logs) {
		App.logs = new App.Collections.LogCollection(App.Data.Logs);
	}
})(jQuery, window, Backbone);