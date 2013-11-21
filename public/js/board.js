;(function(){

	$("#post").bind('click',function(){
		var c = $("#content").val(); 
		$.post('/cgi/add_board',{d:c,gid:ginfo.id,type:1,pid:0,csrf_test_name:$.cookie('csrf_cookie_name')},function(d){
			if(d.ret == 0){
				//$('#postWin').modal('hide');
				window.location.reload();
			}else{
				alert(d.msg);
			}
		});
	});

	$("#searchArea i").bind('click',function(){
		var key = $("#search").val();
		window.location = 'board?gid='+ginfo.id+'&key='+key;
	});

})();