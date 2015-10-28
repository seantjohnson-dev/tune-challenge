(function ($, win, Backbone) {
	App.Views.UserCompositeView = App.Views.CompositeView.extend({
		className: "user-index-container",
		childViewContainer: ".users-list",
		template: function (data) {
			var tmpl = Handlebars.compile(App.Templates.UserCollectionTemplate);
			return tmpl(data);
		},
		childView: App.Views.UserCollectionItemView,
		childViewOptions: function (model, index) {
			return {
				model: model
			};
		},
		collectionEvents: {
			"users:ready" : "onCollectionReady"
		},
		onCollectionReady: function () {
			this.trigger("collection:ready", this);
		}
	});
})(jQuery, window, Backbone);
