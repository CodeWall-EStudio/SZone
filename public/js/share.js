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
		var type = sinput.attr('data-type');
		var url = SEARCHUSER
		if(type){
			var data = {
				'key' : val,
				'type' : type
			}	
			url = SEARCHGROUP;		
		}else{
			var data = {
				'key' : val
			}
		}

		$.post(url,data,function(d){
			if(d.ret == 0){
				var list = d.list;
				if(type == 1){
					rendergroup(list);
				}else{
					render(list);
				}
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

	var rendergroup = function(list){
		var html = [];
		for(var i in list){
			var item = list[i];
			map[item.id] = item;
			html.push('<li><a data-id="'+item.id+'">'+item.name+'</a>');
			if(item.list){
				html.push('<ul class="second">');
				for(var j =0,l=item.list.length;j<l;j++){
					var it = item.list[j];
					map[it.id] = it;
					html.push('<li><a data-id="'+it.id+'">'+it.name+'</a></li>');
				}
				html.push('</ul>');
			}
			html.push('</li>');
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

	var post = function(){
		var type = sinput.attr('data-type');
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
			isuser : $('#isuser').val()
		}
		var url = ADDSHARE;
		if(type){
			var fname = $("#fnames").val().split(',');
			url = ADDSHAREGROUP;
			obj.fname = fname;
		}
		$.post(url,obj,function(d){
			if(d.ret == 0){
				top.hideShare();
			}else{
				top.hideShare();
				top.alert(d.msg);
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
	};

	function init(){
		bind();

	};
	init();
})();