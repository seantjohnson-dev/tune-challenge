(function ($, win, Backbone) {
	App.Views.UserCollectionItemView = App.Views.ItemView.extend({
		tagName: "li",
		className: "user-list-item",
		graphSelector: ".user-graph",
		userNameSelector: ".user-name",
		userOccupationSelector: ".user-occupation",
		userNumbersSelector: ".user-numbers",
		initialize: function () {
			App.Views.ItemView.prototype.initialize.apply(this, arguments);
			App.vent.on(App.Constants.onEveryResize, this.proxy(this.onEveryResize));
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
			var ctx = this.$graph.get(0).getContext('2d');
			var options = {
				animation: false,
				bezierCurve: false,
				pointDot: false,
				responsive: true,
				maintainAspectRatio: true,
				scaleGridLineColor: "rgba(0,0,0,0)",
				scaleLineColor: "rgba(0,0,0,0)",
				scaleShowGridLines: false,
				scaleShowLabels: false
			};
			var chartData = this.getChartData();
			var data = {
				labels: chartData.labels,
				datasets: [{
					data: chartData.data,
					fillColor: 'rgba(0,0,0,0)',
					strokeColor: 'rgba(0,0,0,1)'
				}]
			};
			this.convChart = new Chart(ctx).Line(data, options);
			return this;
		},
		getChartData: function () {
			var conversions = this.model.get('logs').conversions,
			revenueObj = {
				labels: [],
				data: []
			};
			conversions.each(function (conv) {
				revenueObj.data.push(conv.get('revenue'));
				revenueObj.labels.push('');
			});
			return revenueObj;
		},
		setElems: function () {
			this.$userName = this.$(this.userNameSelector);
			this.$userOccupation = this.$(this.userOccupationSelector);
			this.$userDetails = $().add(this.$userName[0]).add(this.$userOccupation[0]);
			this.$userNumbers = this.$(this.userNumbersSelector);
			return this;
		},
		onShow: function () {
			this.setElems().createChart().onEveryResize();
			return this;
		},
		onEveryResize: function () {
			if (this.$userDetails.length > 0) {
				this.$userDetails.width(this.$userDetails.parent().width());
			}
			if (this.$userNumbers.length > 0) {
				this.$userNumbers.parent().css("min-height", this.$userNumbers.outerHeight());
			}
			return this;
		}
	});
})(jQuery, window, Backbone);