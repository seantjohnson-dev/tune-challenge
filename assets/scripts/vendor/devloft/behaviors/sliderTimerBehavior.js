(function ($, win, doc) {
	DevLoft.Behaviors.SliderTimerBehavior = DevLoft.Behaviors.BaseBehavior.extend({
		defaults: function () {
			var def = {
				time: 7000
			};
			return $.extend(true, {}, DevLoft.Behaviors.BaseBehavior.prototype.defaults.apply(this, arguments), def);
		},
        resetTimer: function () {
            return this.stopTimer().startTimer();
        },
        startTimer: function () {
            if (typeof this.options.timer === "number" && this.options.timer > 0 && this.$slides.length >= 2) {
                this.slideTimer = setInterval(this.proxy(function () {
                    this.moveToNext();
                }), this.options.timer);
            }
            return this;
        },
        stopTimer: function () {
            clearInterval(this.slideTimer);
            this.slideTimer = undefined;
            return this;
        }
	});
})(jQuery, window, document);