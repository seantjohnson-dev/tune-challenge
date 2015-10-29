(function ($, win, doc) {
	DevLoft.Behaviors.SliderArrowsBehavior = DevLoft.Behaviors.BaseBehavior.extend({
		ui: function () {
			var ui = {
				"sliderPrevArrow": ".prevArrow.arrow",
				"sliderNextArrow": ".nextArrow.arrow"
			};
			return $.extend(true, {}, DevLoft.Behaviors.BaseBehavior.prototype.events.apply(this, arguments), ui);
		},
		events: function () {
			var evts = {
				"click @ui.sliderPrevArrow": "onArrowClick",
				"click @ui.sliderNextArrow": "onArrowClick"
			};
			if (_.isTrueObject(this.options.arrows) &&
				this.options.arrows.keys) {
				// This requires a tabindex attribute on the element if not a form element.
				evts["keyup @ui.slider"] = "onKeyUp";
			}
			return $.extend(true, {}, DevLoft.Behaviors.BaseBehavior.prototype.events.apply(this, arguments), evts);
		},
        onArrowClick: function (e) {
            if (typeof this.options.arrows === "object") {
                if (this.options.arrows.preventDefault) {
                    e.preventDefault();
                }
                if (!this.isAnimating) {
                    var $this = $(e.currentTarget);
                    if ($this.hasClass(this.options.arrows.nextClass)) {
                        this.moveToNext();
                    } else if ($this.hasClass(this.options.arrows.prevClass)) {
                        this.moveToPrev();
                    }
                }
            }
            return this;
        }
	});
})(jQuery, window, document);