;(function($) {
	$.cookie = function(name, value, options) {
		if (typeof value != 'undefined') {
			options = options || {};
			if (value === null) {
				value = '';
				options.expires = -1;
			}
			var expires = '';
			if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
				var date;
				if (typeof options.expires == 'number') {
					date = new Date();
					date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
				} else {
					date = options.expires;
				}
				expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
			}
			var path = options.path ? '; path=' + (options.path) : '';
			var domain = options.domain ? '; domain=' + (options.domain) : '';
			var secure = options.secure ? '; secure' : '';
			document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
		} else {
			var cookieValue = null;
			if (document.cookie && document.cookie != '') {
				var cookies = document.cookie.split(';');
				for (var i = 0; i < cookies.length; i++) {
					var cookie = jQuery.trim(cookies[i]);
					if (cookie.substring(0, name.length + 1) == (name + '=')) {
						cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
						break;
					}
				}
			}
			return cookieValue;
		}
	};

	$.encodeHtmlSimple = function(sStr){
		sStr = sStr.replace(/&/g, "&amp;");
		sStr = sStr.replace(/ /g, "&nbsp;");
		sStr = sStr.replace(/>/g, "&gt;");
		sStr = sStr.replace(/</g, "&lt;");
		sStr = sStr.replace(/\"/g, "&quot;");
		sStr = sStr.replace(/\'/g, "&#39;");
		return sStr;
	};

	$.decodeHtmlSimple = function(sStr) {
		sStr = sStr.replace(/&amp;/g, '&');
		sStr = sStr.replace(/&nbsp;/g, ' ');
		sStr = sStr.replace(/&gt;/g, '>');
		sStr = sStr.replace(/&lt;/g, '<');
		sStr = sStr.replace(/&quot;/g, '\"');
		sStr = sStr.replace(/&#39;/g, '\'');
		return sStr;
	};

	$.encodeHtmlAttributeSimple = function(sStr){
		sStr += '';
		sStr = sStr.replace(/&/g,"&amp;");
		sStr = sStr.replace(/>/g,"&gt;");
		sStr = sStr.replace(/</g,"&lt;");
		sStr = sStr.replace(/"/g,"&quot;");
		sStr = sStr.replace(/'/g,"&#39;");
		sStr = sStr.replace(/=/g,"&#61;");
		sStr = sStr.replace(/`/g,"&#96;");
		return sStr;
	};

    $.filterHtmlTag = function(sStr){
        return $('<div>').html(sStr).text();
    };

	$.hasAttribute = function(e,attribute){
		return e.getAttribute(attribute) != null;
	}

    /*
     * 将时间戳格式化前天5：00 显示形式
     * @param {Int}
     * @return {String}
     */
    $.formatTime = function(time){
        time *= 1000;

        var sendTime = new Date(time),
			sh = sendTime.getHours(),
			sm = sendTime.getMinutes();

		if(sh<10){
			sh ='0'+sh;
		}
		if(sm < 10){
			sm = '0'+sm;
		}
        //计算今天开始的时间戳
        var currTime = new Date();
        currTime.setHours(0);
        currTime.setMinutes(0);
        currTime.setSeconds(0);

        var todayStartTime = + currTime;

        if(time > todayStartTime){
            return "今天 " + sh + ":" + sm;
        }else if(time > todayStartTime - 24 * 3600 * 1000){
            return "昨天 " + sh + ":" + sm;
        }else{
            return (sendTime.getMonth() + 1) + "月" + sendTime.getDate() + "日";
        }

    };

    $.getParam = function(name){
        try{
            var reg = new RegExp("(^|&|\\\?)" + name + "=(.*?)(?=(&|$))", "g");
            var r = window.location.search.match(reg);
            r = r[0].match(/\=.*?$/);
            return r[0].replace('=','');
        }catch(e){
            return false;
        }

    };

	$.getLen = function(str){
		var s = str.split('');
		var l = 0;
		for(var i in s){
			if(s[i].charCodeAt(0) < 299){
				l++;
			}else{
				l+=3;
				//l++;
			}
		}
		return Math.ceil(l/3);//str.length;
	}

	$.isEmail = function(str){
		var reg = '/^[a-z\d]+(\.[a-z\d]+)*@([\da-z](-[\da-z])?)+(\.{1,2}[a-z]+)+$/';	
		var mailReg = new RegExp(reg);

		return mailReg.test(str);
	}

    $.isURL = function(str){
        var strRegex = "^((https|http|ftp|rtsp|mms)?://)"
        + "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@
        + "(([0-9]{1,3}.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184
        + "|" // 允许IP和DOMAIN（域名）
        + "([0-9a-z_!~*'()-]+.)*" // 域名- www.
        + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]." // 二级域名
        + "[a-z]{2,6})" // first level domain- .com or .museum
        + "(:[0-9]{1,4})?" // 端口- :80
        + "((/?)|" // a slash isn't required if there is no file name
        + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";

        var urlReg = new RegExp(strRegex);
        return urlReg.test(str);
    };

    $.getFileSize = function(bit){
        var tmp = '',flag=0,unit = ['K','M','G','T'];
        while(bit > 1024){
            if(flag <= unit.length){
                tmp = unit[flag];
                flag++;
                bit = bit/1024;
            }
        }
        tmp = '' + Math.round(bit*100)/100 + tmp;
        return tmp;
    };

	$.stringify = function(obj){
		return JSON.stringify(obj);
	};

    $.trimArray = function(array){
        try{
            var tmp = [];
            for(var i in array){
                if(array[i]){
                    tmp.push(array[i]);
                }
            }
            return tmp;
        }catch(e){
            return null;
        }
    }
})(jQuery);

;(function(){
	this.tools = {};
	this.view = {};

}.call(window.szone = {}));

var windowdom = $(window);
windowdom.bind('resize',function(){
	if(windowdom.width() < 1130){
		$('.mcontainer').css('width','1130px');
		$('#header').css("width",'1130px');
	}else{
		$('.mcontainer').css('width','100%');
		$('#header').css("width",'100%');
	}
});

function hideShare(){
	$('#shareWin').modal('hide');
}
function hideManage(){
	$('#manageWin').modal('hide');
	window.location.reload();
}

function sharealert(msg){
	alert(msg);
}