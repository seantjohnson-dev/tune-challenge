(function ($, win, doc) {
    DevLoft.Objects.AnalyticsObject = DevLoft.Objects.BaseObject.extend({
        trackEvent: function (opts) {
            var options = {
                hitType: "event",
                eventCategory: "Button",
                eventAction: "Click",
                eventLabel: "Unknown",
                eventValue: 0
            };
            _.extend(options, opts);
            ga("send", options);
        },
        trackPageView: function (opts) {
            ga("send", "pageview");
        }
    });
    DevLoft.Analytics = new DevLoft.Objects.AnalyticsObject();
})(jQuery, window, document);