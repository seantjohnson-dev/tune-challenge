(function ($, win, BB) {
	App.Collections.UserCollection = App.Collections.BaseCollection.extend({
		model: App.Models.UserModel,
		initialize: function () {
			App.Collections.BaseCollection.prototype.initialize.apply(this, arguments);
			this.readyModels = [];
			this.on("add", this.onInitialAdd);
		},
		onInitialAdd: function (model, collection, event) {
			if (!model.get('ready')) {
				model.once("user:ready", this.proxy(this.onModelAdded));
			} else {
				this.onModelAdded(model);
			}
			return this;
		},
		onModelAdded: function (model) {
			this.readyModels.push(model);
			if (this.readyModels.length === this.length) {
				this.off("add", this.onInitialAdd);
				this.trigger("users:ready", this);
			}
			return this;
		},
		onInitialSuccess: function () {
			this.trigger("populated", this);
			return this;
		}
	});
})(jQuery, window, Backbone);
