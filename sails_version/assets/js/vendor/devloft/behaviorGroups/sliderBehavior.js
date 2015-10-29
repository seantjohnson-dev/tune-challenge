(function ($, win, doc) {
	DevLoft.Behaviors.SliderBehavior = DevLoft.Behaviors.BaseBehavior.extend({
		isAnimating: false,
		passedThreshold: false,
		velocity: 0,
		amplitude: 0,
		totalDelta: 0,
        behaviors: {
            HotKeysBehavior: {},
            SliderArrowsBehavior: {},
            SliderBulletsBehavior: {},
            SliderTimerBehavior: {},
            SliderTouchBehavior: {},
            SliderTransitionBehavior: {}
        },
		defaults: function () {
			var def = {
                autoInit: true,
                dataAttrs: [
                    {name: "data-touch", prop: "touch", type: "object"},
                    {name: "data-timer", prop: "timer", type: "integer"},
                    {name: "data-animation-duration", prop: "animationDuration", type: "float"},
                    {name: "data-ease", prop: "ease", type: "string"},
                    {name: "data-index-buttons", prop: "indexButtons", type: "object"},
                    {name: "data-arrows", prop: "arrows", type: "object"}
                ],
                sliderParentSelector: "", // Set this to a selector if the indexButtons or the arrows are outside of the slider element.
                slideSelector: ".image-slide",
				ease: Expo.easeInOut,
				animationDuration: 0.7,
				activeIndex: 0,
				activeClass: "active",
				onTopClass: "onTop",
				touch: false,
				timer: false,
				indexButtons: false,
				bullets: false,
				arrows: false
			};
			return $.extend(true, {}, DevLoft.Behaviors.BaseBehavior.prototype.defaults.apply(this, arguments), def);
		}
	});
})(jQuery, window, document);