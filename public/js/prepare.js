;(function(){
	// var plist = $.parseJSON(pstr);
	// var grlist = $.parseJSON(gstr);
	// var glist = {};

	//console.log(plist);
	//console.log(grlist);

	var POSTURL = '/manage/addprepare';


	function bind(){
		$("#addgroup").bind('click',function(){
			$("#newOther").addClass('hide');
			$('#newGroup').removeClass('hide');
		});

		$("#addOther").bind('click',function(){
			$("#newOther").removeClass('hide');
			$('#newGroup').addClass('hide');
		})
	}


	function init(){
		bind();
	}

	init();
})();
