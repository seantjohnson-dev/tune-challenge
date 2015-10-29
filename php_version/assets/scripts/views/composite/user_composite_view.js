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
		},
		onShow: function () {
			var index = 0;
			var interval = setInterval(this.proxy(function () {
				if (index == this.collection.length - 1) {
					clearInterval(interval);
				}
				TweenMax.staggerTo(this.$(this.childViewContainer).children(), 0.5, {opacity: 1, scaleX: 1, scaleY: 1}, 0.1);
				index++;
			}), 100);
			return this;
		}
	});
})(jQuery, window, Backbone);

