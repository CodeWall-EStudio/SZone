define(['util'],function(util){

  	var loop = function() {};
  	var g_tk = $.cookie('csrf_cookie_name');
	var ReqTime = function(url) {
		this._start = +new Date();
		// 传递cgi
		this._url = url;
	};

	var request = function(option, onSuccess, always) {
		var timer = new ReqTime();
		var method = option.method ? option.method.toUpperCase() : 'GET',
			cgi = option.cgi,
			data = option.data || {},
			type = option.type || 'json',
			async = option.async == false ? false : true,
			timeout = parseInt(option.timeout, 10) || 10000; // 默认超时设置	

		if(!cgi) {
		  throw new Error('require cgi');
		}		
		
		if(!onSuccess || typeof onSuccess != 'function') {
			onSuccess = option.success;
			if(!onSuccess || typeof onSuccess != 'function') onSuccess = loop; // throw new Error('require success handler'); // cache不用onsuccess
		}
		if(method == 'GET') {
			$.extend(data, {csrf_test_name: g_tk});
		} else {
			var mark = '?',
			index = cgi.indexOf(mark);

			if(~index) mark = '&';
			cgi = cgi + mark + 'csrf_test_name=' + g_tk;
		}	

		var ajaxOpt = {
			url: cgi,
			type: method,
			async: async,
			timeout: timeout,
			dataType: type,
			data: data,
		// 跨域传cookie
			xhrFields: {
				withCredentials: true
			},
			beforeSend: function(xhr, settings) {
				timer.url = settings.url
				timer.start = +new Date();
			}
		};

	    ajaxOpt.success = function(res){
			var code = res.code;
			return onSuccess(res);
	    };

		ajaxOpt.error = function(xhr, err) {

		};

		var xhr = $.ajax(ajaxOpt);

		if('function' == typeof always) xhr.always(always);	    

	};

	request.get = function(option, onSuccess, always) {
		option.method = 'GET';
		return request(option, onSuccess, always);
	};
	request.post = function(option, onSuccess, always) {
		option.method = 'POST';
		return request(option, onSuccess, always);
	};	

	return request;
});