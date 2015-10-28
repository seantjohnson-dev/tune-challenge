(function ($, win, Backbone) {
	App.Layouts.MainLayout = App.Layouts.BaseLayout.extend({
		className: "main-layout",
		id: "main-layout",
		tagName: "main",
		attributes: {
			role: "document"
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
		template: function (data) {
			var tmpl = Handlebars.compile(App.Templates.MainLayoutTemplate);
			return tmpl(data);
		},
		onShow: function () {
			this.$loader = this.$(this.loaderSelector);
			this.addDynamicRegions();
		},
		addDynamicRegions: function () {
			if (!this.userCollectionRegion) {
				this.addRegion("userCollectionRegion", {
					el: "#user-collection-region"
				});
			}
			if (!this.userCompView) {
				this.userCompView = new App.Views.UserCompositeView({
					collection: App.users
				});
				this.userCompView.on("collection:ready", this.proxy(function () {
					this.userCollectionRegion.show(this.userCompView);
					this.$loader.addClass(this.leavingClass);
				}));
			}
			return this;
		},
		onLoaderTransitionEnd: function (e) {
			if (e.target == this.$loader[0]) {
				this.$loader.removeClass(this.leavingClass).addClass(this.loadedClass);
			}
			return this;
		}
	});
})(jQuery, window, Backbone);
