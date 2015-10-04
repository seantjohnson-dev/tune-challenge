(function ($, win, BB) {
	var typeFilterFunc = function (type) {
		return (function (model) {
			return (model.get("type").toLowerCase() === type.toLowerCase());
		});
	};
	App.Collections.LogCollection = App.Collections.BaseLogCollection.extend({
		getFirstByType: function (type) {
			return this.find(typeFilterFunc(type));
		},
		getAllByType: function (type) {
			return this.filter(typeFilterFunc(type));
		}
	});
	App.Logs = new App.Collections.LogCollection(App.Data.Logs);
})(jQuery, window, Backbone);