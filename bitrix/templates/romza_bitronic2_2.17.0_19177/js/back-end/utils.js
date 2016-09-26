if (typeof window.RZB2 == "undefined") {
	RZB2 = {utils: {}};
}

if (typeof RZB2.utils == "undefined") {
	RZB2.utils = {};
}

RZB2.utils.cookiePrefix = 'RZ_';
RZB2.utils.setCookie = function(name, value, prefix)
{
	var date = new Date();
	date.setFullYear(date.getFullYear() + 1);

	prefix = prefix || this.cookiePrefix;
	document.cookie = prefix + name + '=' + value + '; path=/; expires=' + date.toUTCString();
}

RZB2.utils.getCookie = function(name, prefix)
{
	prefix = prefix || this.cookiePrefix;
	name = prefix + name;
	var matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	))
	return matches ? decodeURIComponent(matches[1]) : undefined
}

RZB2.utils.deleteCookie = function(name)
{
	name = this.cookiePrefix + name;
	this.setCookie(name, null, { expires: -1 })
}

RZB2.utils.getQueryVariable = function (variable, query, remove) {
	if (!query) {
		query = window.location.search.substring(1);
	} else {
		query = query.split('?')[1];
		if (!query) {
			return [];
		}
	}
	var result = {};
	if (query.length > 0) {
		var vars = query.split("&");

		for (var i = 0; i < vars.length; i++) {
			var pair = vars[i].split("=");
			if (variable && pair[0] == variable) {
				return pair[1];
			}
			if (typeof(remove) != 'undefined'
				&& pair[0] in remove) {
				continue;
			}
			result[pair[0]] = pair[1];
		}
	}
	return (result);
};
