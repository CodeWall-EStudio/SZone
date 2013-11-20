;(function(){
	var keylist = [
		'搜索用户',
		'搜索小组',
		'搜索部门'
	];
	var SEARCHUSER = '/cgi/getuser',
		EDITDESC = '/cgi/group_edit_desc',
		EDITNAME = '/cgi/group_edit_name'
		EDITGROUP = '/cgi/group_edit',
		sinput = $('#search'),
		joinBtn = $('#joinList'),
		searchResult = $('#searchResult'),
		selectResult = $('#selectResult'),
		postBtn = $("#post");
	var search = function(e){
		var val = sinput.val();
		var url = SEARCHUSER;
		var gid = $('#gid').val();
		var data = {
			'key' : val,
			'gid' : gid
		}

		$.post(url,data,function(d){
			if(d.ret == 0){
				var list = d.list;
				render(list);
			}else{

			}
		});
	};
	//缓存
	var map = {};

	var render = function(list){
		var html = [];
		for(var i =0,l=list.length;i<l;i++){
			var item = list[i];
			map[item.id] = item;
			html.push('<li><a data-id="'+item.id+'">'+item.name+'</a></li>');
		}
		$("#searchResult").html(html.join(""));
	}

	var keyup = function(e){
		if(e.keyCode == 13){
			var val = sinput.val();
			if($.inArray(val,keylist) < 0){
				search();
			}
		}
	}

	var inputfocus = function(e){
		var val = $.trim($(e.target).val());
		if($.inArray(val,keylist) >= 0){
			$(e.target).val('');
		}else{
			
		}
	}

	var inputblur = function(e){
		var val = $.trim($(e.target).val()),
			type = $(e.target).attr('data-type');
		if($.inArray(val,keylist) >= 0){
			$(e.target).val(keylist[type]);		
		}
	}	

	var selected = function(e){
		if(e.target.nodeName != 'A'){
			return;
		}
		var target = $(e.target);

		if(target.hasClass("selected")){
			target.removeClass('selected');
		}else{
			target.addClass('selected');
		}
	}

	var checkBtn = function(){
		if(selectResult.find('li').length > 0){
			postBtn.attr('disabled',false);
		}else{
			postBtn.attr('disabled',true);
		}
	}

	var unselected = function(e){
		var id = $(e.target).attr('data-id');
		var item = map[id];
		searchResult.append('<li><a data-id="'+item.id+'">'+item.name+'</a></li>');
		$(this).remove();
		checkBtn();
	}

	var move = function(e){
		selectResult.html('');
		searchResult.find('.selected').each(function(e){
			var id = $(this).attr('data-id');
			var item = map[id];
			selectResult.append('<li><a data-id="'+item.id+'">'+item.name+'</a></li>');
			$(this).remove();
		});
		checkBtn();
	}

	var bind = function(){
		$('.share-act-zone i').bind('click',search);
		searchResult.bind('click',selected);
		selectResult.bind('click',selected);
		selectResult.bind('dblclick',unselected);
		joinBtn.bind('click',move);
		sinput.bind('keyup',keyup);
		sinput.bind('focus',inputfocus);
		sinput.bind('blur',inputblur);

		$('#saveName').bind('click',function(d){
			var n = $('#gName').val();
			$.post(EDITNAME,{d:n,gid:$('#gid').val()},function(d){
				if(d.ret == 0){
					alert(d.msg);
				}else{
					alert(d.msg);
				}
			});				
		})
		$('#saveDesc').bind('click',function(d){
			var n = $('#gDesc').val();	
			$.post('/cgi/group_edit_desc',{d:n,gid:$('#gid').val()},function(d){
				if(d.ret == 0){
					alert(d.msg);
				}else{
					alert(d.msg);
				}
			});			
		})		

		$("#post").bind('click',function(d){
			var name = $('#gName').val();
			var desc = $('#gDesc').val();	
			var il = [];
			$('#selectResult .selected').each(function(){
				var id = $(this).attr("data-id");
				il.push(id);
			});

			$.post('/cgi/group_edit',{n:name,d:desc,ul:il.join(','),gid:$('#gid').val()},function(d){
				if(d.ret == 0){
					alert(d.msg);
				}else{
					alert(d.msg);
				}
			});					
		});
	};

	function init(){
		bind();

	};
	init();
})();