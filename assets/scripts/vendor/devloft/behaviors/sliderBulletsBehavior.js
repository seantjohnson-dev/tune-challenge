(function ($, win, doc) {
	DevLoft.Behaviors.SliderBulletsBehavior = DevLoft.Behaviors.BaseBehavior.extend({
		defaults: function () {
			var def = {
                activeIndex: 0,
				activeClass: "active"
			};
			return $.extend(true, {}, DevLoft.Behaviors.BaseBehavior.prototype.defaults.apply(this, arguments), def);
		},
		ui: function () {
			var ui = {
				"sliderBullet": ".sliderBullet.bullet"
			};
			return $.extend(true, {}, DevLoft.Behaviors.BaseBehavior.prototype.events.apply(this, arguments), ui);
		},
		events: function () {
			var evts = {
				"click @ui.sliderBullet": "onBulletClick"
			};
			return $.extend(true, {}, DevLoft.Behaviors.BaseBehavior.prototype.events.apply(this, arguments), evts);
		},
        onBulletClick: function (e) {
        	if (!this.options.bullets || !_.isObject(this.options.bullets)) {
        		return this;
        	} else {
        		if (this.options.bullets.preventDefault) {
                    e.preventDefault();
                }
                if (!this.isAnimating) {
                    var $this = $(e.currentTarget),
                    index = this.options.activeIndex;
                    if (typeof this.options.bullets.useParentIndex === "string") {
                        index = $this.parents(this.options.bullets.useParentIndex).index();
                    } else if (this.options.bullets.useParentIndex === true) {
                        index = $this.parent().index();
                    } else {
                        index = $this.index();
                    }
                    this.moveToIndex(index, (index < this.options.activeIndex), this.proxy(function () {
                        this.setActiveItems(index);
                    }));
                }
        	}
        	return this;
        }
	});
})(jQuery, window, document);