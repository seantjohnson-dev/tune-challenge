(function ($, win, doc) {
	DevLoft.Objects.DetectionObject = DevLoft.Objects.BaseObject.extend({
		agent: navigator.userAgent.toLowerCase(),
		initialize: function (options) {
			$.extend(true, {}, this, options);
			this.setMobile().setBrowser().setOS();
		},
		detect: function (d) {
			if (typeof d === "string") {
				d = [d];
			}
			for (var c = 0; c < d.length; c++) {
				if (this.agent.indexOf(d[c]) > -1) {
					return true;
				}
			}
			return false;
		},
		setMobile: function () {
			this.mobile = (!!("ontouchstart" in window) && this.detect(["ios", "iphone", "ipad", "windows phone", "android", "blackberry"])) ? {} : false;
				if (this.mobile) {
				this.mobile.tablet = win.innerWidth > 1000 || win.innerHeight > 900;
				this.mobile.phone = !this.mobile.tablet;
			}
			return this;
		},
		setBrowser: function () {
			var self = this;
			this.browser = {};
			this.browser.chrome = this.detect("chrome");
			this.browser.safari = !this.browser.chrome && this.detect("safari");
			this.browser.firefox = this.detect("firefox");
			this.browser.ie = (function() {
				if (self.detect("msie")) {
					return true;
				}
				if (self.detect("trident") && self.detect("rv:")) {
					return true;
				}
			})();
			this.browser.version = (function() {
				try {
					if (self.browser.chrome) {
						return Number(self.agent.split("chrome/")[1].split(".")[0]);
					}
					if (self.browser.firefox) {
						return Number(self.agent.split("firefox/")[1].split(".")[0]);
					}
					if (self.browser.safari) {
						return Number(self.agent.split("version/")[1].split(".")[0].charAt(0));
					}
					if (self.browser.ie) {
						if (self.detect("msie")) {
							return Number(self.agent.split("msie ")[1].split(".")[0]);
						}
						return Number(self.agent.split("rv:")[1].split(".")[0]);
					}
				} catch (c) {
					return -1;
				}
			})();
			return this;
		},
		setOS: function () {
			var self = this;
			this.os = (function() {
				if(self.detect("iphone")) {
					return 'iphone';
				} else if (self.detect("ipad")) {
					return 'ipad';
				} else if (self.detect("windows phone")) {
					return 'windowsphone';
				} else if (self.detect("android")) {
					return 'android';
				}
				
				if (self.detect("mac os")) {
					return "mac";
				} else {
					if (self.detect("windows nt 6.3")) {
						return "windows8.1";
					} else {
						if (self.detect("windows nt 6.2")) {
							return "windows8";
						} else {
							if (self.detect("windows nt 6.1")) {
								return "windows7";
							} else {
								if (self.detect("windows nt 6.0")) {
									return "windowsvista";
								} else {
									if (self.detect("windows nt 5.1")) {
										return "windowsxp";
									} else {
										if (self.detect("linux")) {
											return "linux";
										}
									}
								}
							}
						}
					}
				}
				return "undetected";
			})();
			return this;
		},
		breakPoints: {
			mobile: 320,
			mobileLarge: 370,
			tablet: 720,
			tabletLarge: 800,
			ipad: 768,
			ipadLandscape: 1024,
			desktop: 1281,
			desktopMedium: 1440,
			desktopLarge: 1600,
			desktopExLarge: 1900
		},
		inMobileRange: function () {
			return (win.innerWidth >= this.breakPoints.mobile && win.innerWidth < this.breakPoints.mobileLarge);
		},
		atLeastMobile: function () {
			return (win.innerWidth >= this.breakPoints.mobile);
		},
		inMobileLargeRange: function () {
			return (win.innerWidth >= this.breakPoints.mobileLarge && win.innerWidth < this.breakPoints.tablet);
		},
		atLeastMobileLarge: function () {
			return (win.innerWidth >= this.breakPoints.mobileLarge);
		},
		underMobileLarge: function () {
			return (win.innerWidth < this.breakPoints.mobileLarge);
		},
		overMobileLarge: function () {
			return (win.innerWidth > this.breakPoints.mobileLarge);
		},
		inTabletRange: function () {
			return (win.innerWidth >= this.breakPoints.tablet && win.innerWidth < this.breakPoints.desktop);
		},
		atLeastTablet: function () {
			return (win.innerWidth >= this.breakPoints.tablet);
		},
		underTablet: function () {
			return (win.innerWidth < this.breakPoints.tablet);
		},
		overTablet: function () {
			return (win.innerWidth > this.breakPoints.tablet);
		},
		inTabletPortRange: function () {
			return (win.innerWidth >= this.breakPoints.tablet && win.innerWidth < this.breakPoints.tabletLarge);
		},
		inTabletLandRange: function () {
			return (win.innerWidth >= this.breakPoints.ipadLandscape && win.innerWidth < this.breakPoints.desktop);
		},
		inIpadRange: function () {
			return (win.innerWidth >= this.breakPoints.ipad && win.innerWidth <= this.breakPoints.ipadLandscape);
		},
		atLeastIpad: function () {
			return (win.innerWidth >= this.breakPoints.ipad);
		},
		underIpad: function () {
			return (win.innerWidth < this.breakPoints.ipad);
		},
		ipadLand: function () {
			return (win.innerWidth >= this.breakPoints.ipadLandscape && win.innerWidth < this.breakPoints.desktop);
		},
		atLeastIpadLand: function () {
			return (win.innerWidth >= this.breakPoints.ipadLandscape);
		},
		underIpadLand: function () {
			return (win.innerWidth < this.breakPoints.ipadLandscape);
		},
		overIpadLand: function () {
			return (win.innerWidth > this.breakPoints.ipadLandscape);
		},
		inDesktopRange: function () {
			return (win.innerWidth >= this.breakPoints.desktop && win.innerWidth <= this.breakPoints.desktopMedium);
		},
		atLeastDesktop: function () {
			return (win.innerWidth >= this.breakPoints.desktop);
		},
		underDesktop: function () {
			return (win.innerWidth < this.breakPoints.desktop);
		},
		inDesktopMedRange: function () {
			return (win.innerWidth >= this.breakPoints.desktopMedium && win.innerWidth <= this.breakPoints.desktopLarge);
		},
		atLeastDesktopMed: function () {
			return (win.innerWidth >= this.breakPoints.desktopMedium);
		},
		underDesktopMed: function () {
			return (win.innerWidth < this.breakPoints.desktopMedium);
		},
		inDesktopLargeRange: function () {
			return (win.innerWidth >= this.breakPoints.desktopLarge && win.innerWidth <= this.breakPoints.desktopExLarge);
		},
		atLeastDesktopLarge: function () {
			return (win.innerWidth >= this.breakPoints.desktopLarge);
		},
		underDesktopLarge: function () {
			return (win.innerWidth < this.breakPoints.desktopLarge);
		},
		atLeastDesktopExLarge: function () {
			return (win.innerWidth >= this.breakPoints.desktopExLarge);
		},
		underDesktopExLarge: function () {
			return (win.innerWidth < this.breakPoints.desktopExLarge);
		}
	});

	DevLoft.Detection = new DevLoft.Objects.DetectionObject();
})(jQuery, window, document); 

