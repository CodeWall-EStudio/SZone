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
			pid : plist.join(',')
		}
		$.post('/cgi/add_prep',data,function(d){
			if(d.code == 0){
				top.hideShare();
				top.location.reload();
			}else{
				//top.hideShare();
				top.alert(d.data.msg);
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