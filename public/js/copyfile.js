;(function(){

	function check(){
		if($('#prepList a.selected').length == 1){
			$("#post").attr('disabled',false);
		}else{
			$("#post").attr('disabled',true);
		}
	}

	function postdata(){
		var plist = [];
		$('#prepList a.selected').each(function(){
			plist.push($(this).attr('data-id'));
		});
		var data = {
			fid : $('#flist').val(),
			fdid : plist.join(','),
			gid : $('#gid').val()
		}
		$.post('/cgi/copy_to_fold',data,function(d){
			if(d.ret == 0){
				//top.hideShare();
			}else{
				//top.hideShare();
				//top.alert(d.msg);
			}
		});
	}

	//绑定事件
	function bind(){
		$('#prepList ul').bind('show.bs.collapse',function(e){
			var target = $(e.target);
			target.parent('li').find('.i-c').text('-');
		});

		$('#prepList ul').bind('hide.bs.collapse',function(e){
			var target = $(e.target);
			target.parent('li').find('.i-c').text('+');
		});	

		$('#prepList a.a-click').bind('click',function(e){
			var target = $(e.target);
			if(target.hasClass("selected")){
				target.removeClass('selected');
			}else{
				target.addClass('selected');
			}
			check();			
		});

		$("#post").bind('click',postdata);
	}

	function init(){
		bind();
	}

	init();
})();