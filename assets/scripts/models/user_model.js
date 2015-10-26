(function ($, win, BB) {
	App.Models.UserModel = App.Models.BaseModel.extend({
		defaults: function () {
			var superDefaults = App.Models.BaseModel.prototype.defaults.apply(this, arguments);
			var defaults = {
				name: "",
				id: 0,
				occupation: "",
				avatar: ""
			};
			return $.extend(true, {}, superDefaults, defaults);
		},
		initialize: function () {
			App.Models.BaseModel.prototype.initialize.apply(this, arguments);
			this.setNameObject().setLogs().setTotalRevenue().setConversionDateRange().setImpressionDateRange();
			if (!this.get("avatar")) {
				this.set("avatar", undefined);
			}
		},
		setLogs: function () {
			if (!this.get('logs')) {
				var impressions = new App.Collections.ImpressionCollection(App.impressions.getAllByUserID(this.get('id'))),
				conversions = new App.Collections.ConversionCollection(App.conversions.getAllByUserID(this.get('id')));
				this.set('logs', {
					impressions: impressions,
					conversions: conversions
				});
			}
			return this;
		},
		setNameObject: function() {
			var full = this.get('name'),
			split = full.split(" "),
			nameObj = {
				full: full,
				first: split[0],
				middle: split[1],
				last: split[2],
				initials: {
					first: split[0].charAt(0).toUpperCase(),
					middle: split[1].charAt(0).toUpperCase(),
					last: split[2].charAt(0).toUpperCase()
				}
			};
			this.set('name', nameObj);
			return this;
		},
		setTotalRevenue: function () {
			var total = 0;
			this.get('logs').conversions.each(function (conv) {
				var rev = conv.get('revenue');
				if (rev > 0) {
					total += rev;
				}
			});
			this.set('revenue', total);
			return this;
		},
		setConversionDateRange: function () {
			var min, max;
			this.get('logs').conversions.each(function (conv) {
				var time = conv.getDateObj();
				if (!min || time.epoch < min.epoch) {
					min = time;
				}
				if (!max || time.epoch > max.epoch) {
					max = time;
				}
			});
			this.set('conversion_date_range', {
				min: min,
				max: max
			});
			return this;
		},
		setImpressionDateRange: function () {
			var min, max;
			this.get('logs').impressions.each(function (imp) {
				var time = imp.getDateObj();
				if (!min || time.epoch < min.epoch) {
					min = time;
				}
				if (!max || time.epoch > max.epoch) {
					max = time;
				}
			});
			this.set('impression_date_range', {
				min: min,
				max: max
			});
			return this;
		}
	});
})(jQuery, window, Backbone);