(function ($, win, BB) {
	var typeFilterFunc = function (type) {
		return (function (model) {
			return (model.get("type").toLowerCase() === type.toLowerCase());
		});
	};

	App.Collections.LogCollection = App.Collections.BaseCollection.extend({
		model: App.Models.LogModel,
		getFirstByType: function (type) {
			return this.find(typeFilterFunc(type));
		},
		getAllByType: function (type) {
			return this.filter(typeFilterFunc(type));
		}
	});
})(jQuery, window, Backbone);