(function ($, win, Backbone) {
	App.Layouts.MainLayout = App.Layouts.BaseLayout.extend({
		el: "body",
		attributes: {
			role: "document"
		},
		regions: {
			header: "#site-header",
			userCollectionRegion: "#user-collection-region", 
			footer: "#site-footer"
		},
		loaderSelector: "#site-loader",
		leavingClass: "leaving",
		loadedClass: "loaded",
		events: function () {
			var evts = {};
			evts["webkitTransitionEnd " + this.loaderSelector] = "onLoaderTransitionEnd";
			evts["mozTransitionEnd " + this.loaderSelector] = "onLoaderTransitionEnd";
			evts["oTransitionEnd " + this.loaderSelector] = "onLoaderTransitionEnd";
			evts["msTransitionEnd " + this.loaderSelector] = "onLoaderTransitionEnd";
			evts["transitionend " + this.loaderSelector] = "onLoaderTransitionEnd";
			return $.extend({}, App.Layouts.BaseLayout.prototype.events.apply(this, arguments), evts);
		},
		initialize: function () {
			App.Layouts.BaseLayout.prototype.initialize.apply(this, arguments);
			this.$loader = this.$(this.loaderSelector);
			this.userCompView = new App.Views.UserCompositeView({
				collection: App.users
			});
			this.userCompView.on("collection:ready", this.proxy(function () {
				this.userCollectionRegion.show(this.userCompView);
				this.$loader.addClass(this.leavingClass);
			}));
		},
		onLoaderTransitionEnd: function (e) {
			if (e.target == this.$loader[0]) {
				this.$loader.removeClass(this.leavingClass).addClass(this.loadedClass);
			}
			return this;
		}
	});
})(jQuery, window, Backbone);
