(function ($, _) {
	Utilities = {
		formatNumber: function (number, delimeter) {
			number = number.toString();
			delimeter = (delimeter || ',');
			var reversed = "";
			for (var i = number.length - 1; i >= 0; i--) {
				reversed += number.charAt(i);
			}
			var matches = reversed.match(/\d{1,3}/g);
			if (matches.length > 1) {
				matches.forEach(function (match, index) {
					if (index < matches.length - 1) {
						matches[index] += delimeter;
					}
				});
				var reverseFormatted = matches.join('');
				var formatted = "";
				for (var f = reverseFormatted.length - 1; f >= 0; f--) {
					formatted += reverseFormatted.charAt(f);
				}
				return formatted;
			} else {
				return number;
			}
		}
	};
	Number.isInteger = Number.isInteger || function(value) {
    return typeof value === "number" && 
    isFinite(value) && 
    Math.floor(value) === value;
	};
	_.isTrueObject = _.isTrueObject || function (obj) {
		return (!_.isFunction(obj) && !_.isArray(obj) && _.isObject(obj));
	};
	DevLoft.Utils = Utilities;
})(jQuery, _);