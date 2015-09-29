(function ($, win, doc) {
	window.DevLoft = {
		win: win,
        $w: $(win),
        $d: $(doc),
        $b: $(doc.body),
        $h: $('html'),
		Base: {
			options: {
				activeClass: "active"
			},
			ui: function () {
				return {};
			},
			events: function () {
				return {};
			},
		    proxy: function (func) {
		        var self = this;
		        return function() {
		            return func.apply(self, arguments);
		        };
		    },
		    isInputActive: function () {
		    	var name = document.activeElement.tagName.toLowerCase();
		    	return (name === "input" ||
	    		name === "textarea" || 
	    		name === "select");
		    },
		    isKeyEventSafe: function (e) {
		        if (!this.isInputActive()) {
		            return true;
		        }
		        return false;
		    },
		    onWindowLoaded: function () {
		    	this.onResize().onDebouncedResize();
		        return this;
		    },
		    onResize: function () {
		        return this;
		    },
		    onDebouncedResize: function () {
		        return this;
		    },
		    setMetaData: function ($title, $meta) {
		        if ($title !== undefined && $title.length > 0) {
		            this.$titleTag = $title; 
		        }
		        if ($meta !== undefined && $meta.length > 0) {
		            this.$metaTags = $meta;
		        }
		        $("title").replaceWith(this.$titleTag);
		        $("head meta").remove();
		        $("head").append(this.$metaTags);
		        return this;
		    }
		},
		Behaviors: {},
		Collections: {},
		Controllers: {},
		Layouts: {},
		Models: {},
		Modules: {},
		Objects: {},
		Regions: {},
		RegionManagers: {},
		Routers: {},
		Views: {},
		Radio: Backbone.Wreqr.radio
	};

	
	DevLoft.Behaviors.BaseBehavior = Marionette.Behavior.extend($.extend(true, {}, DevLoft.Base, {
		defaults: function () {
			return {};
		},
		modelEvents: function () {
			return {};
		},
		collectionEvents: function () {
			return {};
		},
		triggers: function () {
			return {};
		}
	}));
	DevLoft.Collections.BaseCollection = Backbone.Collection.extend($.extend(true, {}, DevLoft.Base, {}));
	DevLoft.Controllers.BaseController = Marionette.Controller.extend($.extend(true, {}, DevLoft.Base, {}));
	DevLoft.Layouts.BaseLayout = Marionette.LayoutView.extend($.extend(true, {}, DevLoft.Base, {}));
	DevLoft.Models.BaseModel = Backbone.Model.extend($.extend(true, {}, DevLoft.Base, {
		defaults: function () {
			var defs = {};
			return defs;
		}
	}));
	DevLoft.Modules.BaseModule = Marionette.Module.extend($.extend(true, {}, DevLoft.Base, {}));
	DevLoft.Objects.BaseObject = Marionette.Object.extend($.extend(true, {}, DevLoft.Base, {}));
	DevLoft.Regions.BaseRegion = Marionette.Region.extend($.extend(true, {}, DevLoft.Base, {}));
	DevLoft.RegionManagers.BaseRegionManager = Marionette.RegionManager.extend($.extend(true, {}, DevLoft.Base, {}));
	DevLoft.Routers.BaseRouter = Marionette.AppRouter.extend($.extend(true, {}, DevLoft.Base, {}));
	DevLoft.Views.BaseView = Backbone.View.extend($.extend(true, {}, DevLoft.Base, {}));
	DevLoft.Views.ItemView = Marionette.ItemView.extend($.extend(true, {}, DevLoft.Base, {}));
	DevLoft.Views.CollectionView = Marionette.CollectionView.extend($.extend(true, {}, DevLoft.Base, {}));
	DevLoft.Views.CompositeView = Marionette.CompositeView.extend($.extend(true, {}, DevLoft.Base, {}));

	_.isTrueObject = function (obj) {
		return (!_.isFunction(obj) && !_.isArray(obj) && _.isObject(obj));
	};
	
})(jQuery, window, document);