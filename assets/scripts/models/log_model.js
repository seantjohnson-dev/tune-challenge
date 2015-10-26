(function ($, win, BB) {
	App.Models.LogModel = App.Models.BaseModel.extend({
		logType: "log",
		setErrorMessages: function () {
			var messages = {
				invalidType: "Not a valid log type passed into constructor. Log type must be " + this.logType + " and cannot be empty.",
				invalidDate: "Not a valid date string. Each log must have a valid timestamp string.",
				invalidUserID: "User ID is not an integer or a valid string representing an integer. Logs must have a user_id that they are associated with."
			};
			this.errorMessages = $.extend({}, App.Models.BaseModel.prototype.setErrorMessages.apply(this, arguments), messages);
			return this.errorMessages;
		},
		defaults: function () {
			var defaults = {
				time: "",
				type: this.logType,
				user_id: 0,
				revenue: 0
			};
			return $.extend(true, {}, App.Models.BaseModel.prototype.defaults.apply(this, arguments), defaults);
		},
		options: {},
		initialize: function (attributes, options) {
			this.options = $.extend(true, {}, this.options, options);
			this.setErrorMessages();
			this.validateDefaults();
		},
		validateDefaults: function () {
			if (!this.get("type")) {
				throw this.errorMessages.invalidType;
			}
			if (!new Date(this.get('time'))) {
				throw this.errorMessages.invalidDate;
			}
			if (!Number.isInteger(this.get("user_id")) || _.isNaN(parseInt(this.get("user_id")))) {
				throw this.errorMessages.invalidUserID;
			}
			return this;
		},
		getDateObj: function (dateString) {
			var time = new Date((_.isDate(dateString) ? dateString : this.get('time'))),
			day = time.getDate(),
			month = time.getMonth(),
			year = time.getFullYear();
			return {
				epoch: time.getTime(),
				day: day,
				month: month,
				year: year,
				string: month + '/' + day
			};
		}
	});
})(jQuery, window, Backbone);