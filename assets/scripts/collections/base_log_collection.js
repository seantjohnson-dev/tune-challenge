(function ($, win, BB) {
	var idFilterFunc = function (id) {
		return (function (model) {
			return (parseInt(model.get("user_id")) === parseInt(id));
		});
	};
	App.Collections.BaseLogCollection = App.Collections.BaseCollection.extend({
		model: App.Models.LogModel,
		initialize: function (attrs, options) {
			this.options = $.extend(true, this.options, options);
		},
		getFirstByUserID: function (id) {
			return this.find(idFilterFunc(id));
		},
		getAllByUserID: function (id) {
			return this.filter(idFilterFunc(id));
		},
		getFirstByMatch: function (obj) {
			return this.where(obj);
		},
		getAllByMatch: function (obj) {
			return this.findWhere(obj);
		},
		getFirstByDateRange: function (options) {
			var defs = {
				start: "",
				end: "",
				sort: {
					order: "desc",
					props: {}
				}
			};
		},
		getAllByDateRange: function (options) {
			var defs = {
				start: "",
				end: "",
				sort: {
					order: "desc",
					props: {}
				}
			};
		}
	});
})(jQuery, window, Backbone);