;(function(){

	$("#post").bind('click',function(){
		var c = $("#content").val(); 
		$.post('/cgi/add_board',{d:c,gid:ginfo.id,type:1,pid:0,csrf_test_name:$.cookie('csrf_cookie_name')},function(d){
			if(d.code == 0){
				//$('#postWin').modal('hide');
				window.location.reload();
			}else{
				alert(d.code.msg);
			}
		});
	});

	$("#search").focus(function(e){
		var t = $(e.target),
			v = t.val(),
			def = t.attr('data-def');
		if(v == def){
			t.val('');
		}
	}).blur(function(e){
		var t = $(e.target),
			v = t.val(),
			def = t.attr('data-def');
		if(v == ''){
			t.val(def);
		}			
	});

	$("#searchArea i").bind('click',function(){
		var key = $("#search").val();
		window.location = 'board?gid='+ginfo.id+'&key='+key;
	});

})();