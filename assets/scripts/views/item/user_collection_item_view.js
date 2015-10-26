(function ($, win, Backbone) {
	App.Views.UserCollectionItemView = App.Views.ItemView.extend({
		tagName: "li",
		className: "user-list-item",
		graphSelector: ".user-graph",
		initialize: function (options) {
			App.Views.ItemView.prototype.initialize.apply(this, arguments);
		},
		template: function (data) {
			var tmpl = Handlebars.compile(App.Templates.UserCollectionItemTemplate);
			return tmpl(data);
		},
		templateHelpers: function() {
			return {
				impressions_output: this.proxy(function () {
					return App.Utils.formatNumber(this.model.get('logs').impressions.length);
				}),
				conversions_output: this.proxy(function () {
					return App.Utils.formatNumber(this.model.get('logs').conversions.length);
				}),
				revenue_output: this.proxy(function () {
					return App.Utils.formatNumber(Math.round(this.model.get('revenue')));
				})
			};
		},
		createChart: function () {
			this.$graph = this.$(this.graphSelector);
			var ctx = this.$graph[0].getContext('2d');
			var options = {
				animation: false,
				bezierCurve: false,
				pointDot: false,
				scaleGridLineColor: "rgba(0,0,0,0)",
				scaleLineColor: "rgba(0,0,0,0)",
				scaleShowGridLines: false,
				scaleShowLabels: false
			};
			var chartData = this.getChartData();
			var data = {
				labels: [],
				dataSets: [{
					data: chartData,
					fillColor: 'rgba(0,0,0,0)',
					strokeColor: 'rgba(0,0,0,1)'
				}]
			};
			this.convChart = new Chart(ctx).Line(data, options);
		},
		getChartData: function () {
			var conversions = this.model.get('logs').conversions,
			revenueArray = [];
			conversions.each(function (conv) {
				revenueArray.push(conv.get('revenue'));
			});
			return revenueArray;
		},
		onShow: function () {
			this.createChart();
			return this;
		}
	});
})(jQuery, window, Backbone);