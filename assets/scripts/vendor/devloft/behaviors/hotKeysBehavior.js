(function ($, win, doc) {
	DevLoft.Behaviors.HotKeysBehavior = DevLoft.Behaviors.BaseBehavior.extend({
		onRender: function () {
			DevLoft.HotKeys.bind(this.view.keyEvents, this.view, this.view.cid);
		},
		onClose: function () {
			HotKeys.unbind(this.view.keyEvents, this.view, this.view.cid);
		}
	});
})(jQuery, window, document);