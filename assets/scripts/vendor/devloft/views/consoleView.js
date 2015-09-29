(function ($, win, doc) {
    DevLoft.Views.ConsoleView = Marionette.ItemView.extend($.extend(true, {}, DevLoft.Base, {
        id: "app-console",
        className: "app-console",
        tagName: "div",
        $b: $(doc.body),
        template: function () {
            var str = "";
            this.logArgs.forEach(this.proxy(function (arg) {
                str += arg;
            }));
            return str;
        },
        initialize: function (options) {
            $.extend(true, this.options, options);
            if (!$.contains(this.$b[0], this.id)) {
                this.$b.append(this.$el);
            }
        },
        setArgs: function () {
            this.logArgs = Array.prototype.slice.apply(arguments, 0);
            return this;
        },
        log: function (render) {
            if (render) {
                this.render();
            } else if (console) {
                console.log(this.logArgs);
            } else {
                alert(this.logArgs);
            }
        }
    }));
})(jQuery, window, document); 

