(function ($, win, doc) {
	DevLoft.Objects.ConstantsObject = DevLoft.Objects.BaseObject.extend({
		onResize: "onResize",
        onDebouncedResize: "onDebouncedResize",
        onWindowLoaded: "onWindowLoaded",
        onRouteChange: "routeChange",
        onRouteChanged: "routeChanged",
        onViewReady: "onViewReady",
        initialize: function (options) {
        	$.extend(true, {}, this.options, this);
        },
        addConstant: function (constant) {
    		if (!this[constant]) {
    			this[constant] = constant;
    		}
    		return this;
    	},
    	removeConstant: function (constant) {
    		if (this[constant]) {
    			delete this[constant];
    		}
    		return this;
    	}
	});
    DevLoft.Constants = new DevLoft.Objects.ConstantsObject();
})(jQuery, window, document);