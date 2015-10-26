(function ($, win, Backbone) {
	App.Regions.UserCollectionRegion = App.Regions.BaseRegion.extend({
		el: "#user-collection-region",
		initialize: function (options) {
			this.options = $.extend(true, {}, this.options, options);
		}
	});
})(jQuery, window, Backbone);