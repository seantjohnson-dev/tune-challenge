(function ($, win, doc) {
	DevLoft.Behaviors.SliderTouchBehavior = DevLoft.Behaviors.BaseBehavior.extend({
		defaults: function () {
			var def = {
				dragThreshold: 10,
                velocityCheck: 1,
                slideMass: 0.2,
                decayConstant: 100
			};
			return $.extend(true, {}, DevLoft.Behaviors.BaseBehavior.prototype.defaults.apply(this, arguments), def);
		},
		ui: function () {
			var ui = {
				"slider": ".slider"
			};
			return $.extend(true, {}, DevLoft.Behaviors.BaseBehavior.prototype.events.apply(this, arguments), ui);
		},
		events: function () {
			var evts = {};
			if (_.isTrueObject(this.options.touch)) {
				evts["touchstart @ui.slider"] = "onTouchStart";
				evts["touchmove @ui.slider"] = "onTouchMove";
				evts["touchend @ui.slider"] = "onTouchEnd";
			}
			return $.extend(true, {}, DevLoft.Behaviors.BaseBehavior.prototype.events.apply(this, arguments), evts);
		},
        setSwipeSlides: function () {
            var prevIndex, nextIndex;
            if (this.options.activeIndex <= 0) {
                prevIndex = this.$slides.length - 1;
                nextIndex = this.options.activeIndex + 1;
            } else if (this.options.activeIndex >= this.$slides.length - 1) {
                nextIndex = 0;
                prevIndex = this.options.activeIndex - 1;
            } else {
                prevIndex = this.options.activeIndex - 1;
                nextIndex = this.options.activeIndex + 1;
            }
            this.swipeSlides = {
                $prev: this.$slides.eq(prevIndex),
                $next: this.$slides.eq(nextIndex),
                $active: this.$slides.eq(this.options.activeIndex),
                $all: $().add(this.$slides.get(prevIndex)).add(this.$slides.get(nextIndex)).add(this.$slides.get(this.options.activeIndex))
            };
            this.swipeSlides.$prev.css({"left": "-100%"});
            this.swipeSlides.$next.css({"left": "100%"});
            return this;
        },
        trackSwipeValues: function () {
            var now, elapsed, delta;
            now = Date.now();
            elapsed = now - this.timestamp;
            this.timestamp = now;
            delta = this.currentPos - this.lastX;
            var instantV = this.getInstantVelocity(delta, elapsed);
            this.velocity = this.getAverageVelocity(instantV);
            this.lastX = this.currentPos;
            return this;
        },
        getInstantVelocity: function (delta, elapsed) {
            return 1000 * delta / (1 + elapsed);
        },
        getAverageVelocity: function (instantV) {
            return 0.8 * instantV + 0.2 * this.velocity;
        },
        moveSlides: function (pos) {
            this.isAnimating = true;
            this.swipeSlides.$all.each(function () {
                this.style.WebkitTransform = this.style.MozTransform = this.style.Transform = this.style.msTransform = "translate3d(" + pos + "px,0,0)";
            });
            return this;     
        },
        onTouchStart: function (e) {
            if (!this.isAnimating) {
                clearInterval(this.velocityInterval);
                this.startPos = this.currentPos = this.lastX = e.originalEvent.touches[0].clientX;
                this.totalDelta = 0;
                this.timestamp = Date.now();
                this.velocityInterval = setInterval(this.proxy(this.trackSwipeValues), this.options.touch.velocityCheckTime);
                this.snapIncrement = this.$el.outerWidth();
                this.$el.on("touchmove", this.proxy(this.onTouchMove));
                this.stopTimer();
            }
            return this;
        },
        onTouchMove: function (e) {
            this.currentPos = e.originalEvent.touches[0].clientX;
            this.totalDelta = this.currentPos - this.startPos;
            if (Math.abs(this.totalDelta) > this.options.touch.dragThreshold || this.passedThreshold) {
                this.passedThreshold = true;
                this.setSwipeSlides();
                e.stopPropagation();
                e.preventDefault();
                this.moveSlides(this.totalDelta);
            }
            return this;
        },
        onTouchEnd: function (e) {
            this.$el.off("touchmove");
            clearInterval(this.velocityInterval);
            if (this.isAnimating) {
                this.destPos = Math.round((this.totalDelta + (this.options.touch.slideMass * this.velocity)) / this.snapIncrement) * this.snapIncrement;
                if (Math.abs(this.destPos) > this.snapIncrement) {
                    this.destPos = this.snapIncrement * this.destPos / Math.abs(this.destPos);
                }
                this.amplitude = this.destPos - this.totalDelta;
                this.timestamp = Date.now();
                requestAnimationFrame(this.proxy(function () {
                    this.autoDecaySlideSpeed();
                }));
                if (this.amplitude > 0) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }
            return this;
        },
        touchSlideAnimationEnded: function () {
            this.setActiveSlide();
            this.velocity = this.amplitude = this.totalDelta = this.destPos = this.currentPos = this.startPos = 0;
        }
	});
})(jQuery, window, document);