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
		var type = parseInt(sinput.attr('data-type'));
		if(val == ''){
			searchResult.find('li').show();
		}else{
			searchResult.find('li').each(function(e){
				var v = $(this).text();
				if(v.indexOf(val)<0){
					$(this).hide();
				}
			});
		}
	};
	//缓存

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

	// var unselected = function(e){
	// 	var id = $(e.target).attr('data-id');
	// 	var item = map[id];
	// 	searchResult.append('<li><a data-id="'+item.id+'">'+item.name+'</a></li>');
	// 	$(this).remove();
	// 	checkBtn();
	// }

	var unselected = function(e){
		var id = $(e.target).attr('data-id');
		var item = map[id];
		searchResult.append('<li><a data-id="'+item.id+'">'+item.name+'</a></li>');
		$(e.target).parents('li').remove();
		//$(this).remove();
		checkBtn();
	}	

	var move = function(e){
		//selectResult.html('');
		searchResult.find('.selected').each(function(e){
			var id = $(this).attr('data-id');
			var item = map[id];
			//selectResult.append('<li><a data-id="'+item.id+'">'+item.name+'</a></li>');
			$('<li><a data-id="'+item.id+'">'+item.name+'</a></li>').appendTo(selectResult);
			$(this).remove();
		});
		checkBtn();
	}

	var post = function(){
		var type = parseInt(sinput.attr('data-type'));
		var ilist = [];
		selectResult.find('a').each(function(){
			var id = $(this).attr("data-id");
			ilist.push(id);
		});
		var flist = $('#flist').val().split(',');
		var obj = {
			id : ilist,
			content : $('#content').val(),
			type : $("#type").val(),
			flist : flist,
			csrf_test_name:$.cookie('csrf_cookie_name'),
			gid : $('#gid').val()
		}
		var url = ADDSHARE;
		if(type){
			var fname = $("#fnames").val().split(',');
			url = ADDSHAREGROUP;
			obj.fname = fname;
		}
		$.post(url,obj,function(d){
			if(d.code == 0){
				top.hideShare();
				top.alert(d.data.msg);
			}else{
				top.hideShare();
				top.alert(d.data.msg);
			}
		});
	}	

	var bind = function(){
		$('.share-act-zone i').bind('click',search);
		searchResult.bind('click',selected);
		selectResult.bind('click',selected);
		selectResult.bind('dblclick',unselected);
		joinBtn.bind('click',move);
		postBtn.bind('click',post);
		sinput.bind('keyup',keyup);
		sinput.bind('focus',inputfocus);
		sinput.bind('blur',inputblur);

		$('#saveName').bind('click',function(d){
			var n = $('#gName').val();
			$.post(EDITNAME,{d:n,gid:$('#gid').val(),csrf_test_name:$.cookie('csrf_cookie_name')},function(d){
				if(d.code == 0){
					alert(d.data.msg);
				}else{
					alert(d.data.msg);
				}
			});				
		})
		$('#saveDesc').bind('click',function(d){
			var n = $('#gDesc').val();	
			$.post('/cgi/group_edit_desc',{d:n,gid:$('#gid').val(),csrf_test_name:$.cookie('csrf_cookie_name')},function(d){
				if(d.code == 0){
					alert(d.data.msg);
				}else{
					alert(d.data.msg);
				}
			});			
		})		

		// $("#post").bind('click',function(d){
		// 	var name = $('#gName').val();
		// 	var desc = $('#gDesc').val();	
		// 	var il = [];
		// 	var type = $(this).attr('data-type');
			
		// 	var url = '/cgi/group_edit';
		// 	if(type){
		// 		url = '/cgi/new_group';
		// 	}
		// 	$('#selectResult a').each(function(){
		// 		var id = $(this).attr("data-id");
		// 		il.push(id);
		// 	});
		// 	$.post(url,{n:name,d:desc,ul:il.join(','),gid:$('#gid').val(),csrf_test_name:$.cookie('csrf_cookie_name')},function(d){
		// 		if(d.code == 0){
		// 			alert(d.data.msg);
		// 		}else{
		// 			alert(d.data.msg);
		// 		}
		// 	});					
		// });
	};

	function init(){
		bind();

	};
	init();
})();