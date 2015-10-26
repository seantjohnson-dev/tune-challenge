(function ($, win, Backbone) {
	App.Layouts.MasterLayout = App.Layouts.BaseLayout.extend({
		template: function (data) {
			var tmpl = Handlebars.compile(App.Templates.MasterLayoutTemplate);
			return tmpl(data);
		}
	});


	App.on("start", function () {
		if (!App.masterLayout) {
			App.masterLayout = new App.Layouts.MasterLayout({el: "#master-layout"});
			App.masterLayout.on("render", function () {
				if (!App.masterLayout.userCollectionRegion) {
					App.masterLayout.addRegion("userCollectionRegion", {
						el: "#user-collection-region",
						regionClass: App.Regions.UserCollectionRegion
					});
					App.masterLayout.userCollectionRegion.show(new App.Views.UserCompositeView({
						collection: App.users
					}));
				}
			});
			App.masterLayout.render();
		}
	});
})(jQuery, window, Backbone);