;(function(){
	var keylist = [
		'搜索用户',
		'搜索小组',
		'搜索部门'
	];
	var SEARCHUSER = '/cgi/getuser',
		ADDSHARE = '/cgi/addshare',
		ADDSHAREGROUP = '/cgi/addgroupshare',
		SEARCHGROUP = '/cgi/getgroup',
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
		// var url = SEARCHUSER
		// if(type){
		// 	var data = {
		// 		'key' : val,
		// 		csrf_test_name:$.cookie('csrf_cookie_name'),
		// 		'gid' : $('#gid').val(),
		// 		'type' : type
		// 	}	
		// 	url = SEARCHGROUP;		
		// }else{
		// 	var data = {
		// 		csrf_test_name:$.cookie('csrf_cookie_name'),
				
		// 		'key' : val
		// 	}
		// }
		// $.post(url,data,function(d){
		// 	if(d.code == 0){
		// 		var list = d.data.list;
		// 		if(type >= 1){
		// 			rendergroup(list);
		// 		}else{
		// 			render(list);
		// 		}
		// 	}else{

		// 	}
		// });
	};
	//缓存
	//var map = {};

	// var render = function(list){
	// 	var html = [];
	// 	for(var i =0,l=list.length;i<l;i++){
	// 		var item = list[i];
	// 		map[item.id] = item;
	// 		html.push('<li><a data-id="'+item.id+'">'+item.name+'</a></li>');
	// 	}
	// 	$("#searchResult").html(html.join(""));
	// }

	// var rendergroup = function(list){
	// 	var html = [];
	// 	for(var i in list){
	// 		var item = list[i];
	// 		map[item.id] = item;
	// 		html.push('<li><a data-id="'+item.id+'">'+item.name+'</a>');
	// 		// if(item.list){
	// 		// 	html.push('<ul class="second">');
	// 		// 	for(var j in item.list){
	// 		// 		var it = item.list[j];
	// 		// 		map[it.id] = it;
	// 		// 		html.push('<li><a data-id="'+it.id+'">'+it.name+'</a></li>');
	// 		// 	}
	// 		// 	html.push('</ul>');
	// 		// }
	// 		html.push('</li>');
	// 	}
	// 	$("#searchResult").html(html.join(""));
	// }	

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
		console.log(e);
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

		$(document).on('click','[data-save]',function(e){
			var target = $(e.target);
			var id = target.attr('data-id');
			copyFiletoMy(id);			
		});

		$(document).on('click','[data-review]',function(e){
			var target = $(e.target);
			var id = target.attr('data-id');
			var fid = target.attr('data-fid');
			console.log(id,fid);
			top.showReview(id,fid);
			//copyFiletoMy(id);			
		});		

		$(document).on('click','[data-uncoll]',function(e){
			var target = $(e.target);
			var id = target.attr('data-id');
			var data = {
				id : id,
				csrf_test_name:$.cookie('csrf_cookie_name')
			}

			$.post('/cgi/uncoll',data,function(d){
				//console.log(d);
				if(d.code == 0){
					target.parents('li').remove();
				}
			});	
			//copyFiletoMy(id);			
		});			
	};


    //复制文件
    function copyFiletoMy(id){
    	$.post('/cgi/copymsg_to_my',{id:id},function(d){
    		if(d.code == 0){
    			$('#savefile'+id).remove();
    			alert(d.data.msg);
    		}else{
    			alert(d.data.msg);
    		}
    	});
    }

	function init(){
		bind();

	};
	init();
})();