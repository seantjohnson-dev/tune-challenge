(function ($, win, doc) {
    DevLoft.Behaviors.ResponsiveImageBehavior = DevLoft.Behaviors.BaseBehavior.extend({
        options: {
            dataAttrs: [
                {name: "data-loaded-class", prop: "loadedClass", type: "string"},
                {name: "data-parent-selector", prop: "parentSelector", type: "string"},
                {name: "data-tablet-breakpoint", prop: "tabletBreakpoint", type: "integer"},
                {name: "data-desktop-breakpoint", prop: "desktopBreakpoint", type: "integer"},
                {name: "data-load-time", prop: "loadCheckTime", type: "integer"}
            ],
            autoInit: true,
            loadedClass: "loaded",
            mobilePathAttr: "data-portrait",
            tabletPathAttr: "data-tablet",
            desktopPathAttr: "data-desktop",
            tabletBreakpoint: 768,
            desktopBreakpoint: 1280,
            loadCheckTime: 250,
            parentSelector: ""
        },
        init: function () {
            App.vent.on(App.Constants.onResize, this.proxy(this.onResize));
            App.vent.on(App.Constants.onWindowLoaded, this.proxy(this.onWindowLoaded));
            App.vent.trigger(App.Constants.onResponsiveImageInit, this);
            this.setDataAttrs();
            return this;
        },
        getPath: function () {
            var $parent = App.$w;
            if (this.options.parentSelector) {
                $parent = this.$el.parents(this.options.parentSelector);
            }
            if (($parent.outerWidth() < $parent.outerHeight()) && $parent.outerWidth() < this.options.tabletBreakpoint) {
                return this.$el.attr(this.options.mobilePathAttr);
            } else if ($parent.outerWidth() >= $parent.outerHeight() && $parent.outerWidth() <= this.options.desktopBreakpoint) {
                return this.$el.attr(this.options.tabletPathAttr);
            } else {
                return this.$el.attr(this.options.desktopPathAttr);
            } 
        },
        loadImage: function () {
            var src = this.getPath();
            var img = new Image();
            if (src !== this.lastSrc) {
                App.vent.trigger(App.Constants.onResponsiveImageChange, this, {lastSrc: this.lastSrc, currentSrc: src});
                this.$el.removeClass(this.options.loadedClass);
            }
            this.setLoadTimer(img);
            img.src = src;
            this.lastSrc = src;
            return this;
        },
        setLoadTimer: function (img) {
            var loadTimer = setInterval(this.proxy(function () {
                if (img.complete) {
                    clearInterval(loadTimer);
                    this.setPath(img);
                }
            }), this.options.loadCheckTime);
        },
        setPath: function (img) {
            if (this.$el[0].tagName.toLowerCase() === "img") {
                this.$el.attr("src", img.src);
            } else {
                this.$el.css({"background-image": "url(" + img.src + ")"});
            }
            this.$el.addClass(this.options.loadedClass);
            App.vent.trigger(App.Constants.onResponsiveImageChanged, this, {lastSrc: this.lastSrc, currentSrc: img.src, width: img.width, height: img.height});
        },
        onResize: function () {
            DevLoft.Behaviors.BaseBehavior.prototype.onResize.apply(this, arguments);
            return this.loadImage();
        }
    });
})(jQuery, window, document);