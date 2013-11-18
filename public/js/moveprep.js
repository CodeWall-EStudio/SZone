;(function(){

	function renderUl(list,id){
		var html = [];
		var  id = id || 0;
		for(var i in list){
			var item = list[i];
			var sl = '';
			if(item.list){
				sl = renderUl(item.list,item.id);
				html.push('<li><i class="i-c">-</i> <a  data-toggle="collapse" data-target=".second_'+item.id+'" data-id="'+item.id+'">'+item.name+'</a>'+sl+'</li>');
			}else{
				if(item.sid){
					html.push('<li><i>-</i> <a class="a-click" data-id="'+item.id+'">'+item.name+'</a>'+sl+'</li>');
				}else{
					html.push('<li><i>-</i> <a  data-id="'+item.id+'">'+item.name+'</a>'+sl+'</li>');
				}
			}
			
		}
		var str = '<ul class="panel-collapse collapse in second second_'+id+' ">'+html.join('')+'</ul>';
		return str;
	}

	function render(){
		var d = plist;
		var html = [];
		for(var i in plist){
			var item = plist[i];
			var sl = '';
			if(item.list){
				sl = renderUl(item.list);
			}
			html.push('<li>'+item.name+sl+'</li>');
		}
		$("#prepList").html(html.join(''));
	}

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
			if(d.ret == 0){
				top.hideShare();
			}else{
				//top.hideShare();
				top.alert(d.msg);
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
		render();
		bind();

	}

	init();
})();