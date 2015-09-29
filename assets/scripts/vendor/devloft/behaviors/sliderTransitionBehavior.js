(function ($, win, doc) {
	DevLoft.Behaviors.SliderTransitionBehavior = DevLoft.Behaviors.BaseBehavior.extend({
		defaults: function () {
			var def = {
				ease: Expo.easeInOut,
                duration: 0.7,
                activeClass: "active",
                onTopClass: "onTop",
                prevExitTransition: "moveToRight",
                prevEnterTransition: "moveFromLeft",
                nextExitTransition: "moveToLeft",
                nextEnterTransition: "moveFromRight"
			};
			return $.extend(true, {}, DevLoft.Behaviors.BaseBehavior.prototype.defaults.apply(this, arguments), def);
		},
        toPrev: function () {
            var index = (this.options.activeIndex <= 0) ? this.$slides.length - 1 : this.options.activeIndex - 1;
            this.moveToIndex(index, true, this.proxy(function () {
                this.setActiveItems(index);
            }));
            return this;
        },
        toNext: function () {
            var index = (this.options.activeIndex >= this.$slides.length - 1) ? 0 : this.options.activeIndex + 1;
            this.moveToIndex(index, false, this.proxy(function () {
              this.setActiveItems(index);
            }));
            return this;
        },
        toIndex: function (index, prev, callback) {
            if (index !== this.options.activeIndex) {
                this.stopTimer();
                var $old = this.$slides.eq(this.options.activeIndex);
                var $new = this.$slides.eq(index);
                $new.addClass(this.activeClass);
                $old.addClass(this.options.onTopClass);
                if (prev) {
                  this.leaveNext($old);
                  this.enterPrev($new, callback);
                } else {
                  this.leavePrev($old);
                  this.enterNext($new, callback);
                }
                App.vent.trigger(App.Constants.onSlideChange, this, this.options.activeIndex, index);
              }
            return this;
        },
        exitPrev: function ($elem, callback) {
            this._fromTo({$elem: $elem, from: "0%", to: "-100%", ease: this.options.ease, duration: this.options.animationDuration, callback: callback});
            return this;
        },
        exitNext: function ($elem, callback) {
            this._fromTo({$elem: $elem, from: "0%", to: "100%", ease: this.options.ease, duration: this.options.animationDuration, callback: callback});
            return this;
        },
        enterPrev: function ($elem, callback) {
            this._fromTo({$elem: $elem, from: "-100%", to: "0%", ease: this.options.ease, duration: this.options.animationDuration, callback: callback});
            return this;
        },
        enterNext: function ($elem, callback) {
            this._fromTo({$elem: $elem, from: "100%", to: "0%", ease: this.options.ease, duration: this.options.animationDuration, callback: callback});
            return this;
        },
        _fromTo: function (options) {
            TweenMax.fromTo(options.$elem, options.duration, {xPercent: options.from}, {xPercent: options.to, ease: options.ease, onComplete: this.proxy(function () {
                if (options.callback) {
                  options.callback.call();
                }
            })});
            this.isAnimating = true;
            return this;
        },
        onTransitionEnd: function (e) {

        }
	});
})(jQuery, window, document);