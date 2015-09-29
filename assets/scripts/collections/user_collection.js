(function ($, win, BB) {
	App.Collections.UserCollection = BB.Collection.extend({
		model: App.Models.UserModel,
		initialize: function (attrs, options) {
			this.options = $.extend(true, this.options, options);
		}
	});
	App.Users = new App.Collections.UserCollection(App.Data.Users);
})(jQuery, window, Backbone);