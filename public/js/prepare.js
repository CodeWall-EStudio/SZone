;(function(){
	var plist = $.parseJSON(pstr);
	var grlist = $.parseJSON(gstr);
	var glist = {};

	console.log(plist);
	console.log(grlist);

	var POSTURL = '/manage/addprepare'
	
	
	var groupEl = $("#groupid");
	var grEl = $("#grid");
	var unEl = $('#unid');

	var createUn = function(list,dom){
		dom = dom || unEl;
		console.log(dom);
		var html = [];
		for(var j in list){
			var item = list[j];
			html.push('<option value="'+item.id+'">'+item.name+'</option>');
		}
		dom.html(html.join(''));
	}

	var createSelect = function(){
		if(groupEl){
			var html = []
			for(var i in plist){
				glist[i] = {
					'id' : i,
					'name' : plist[i],
					'list' : {}
				}
				html.push('<option value="'+i+'">'+plist[i]+'</option>');
			}
			groupEl.html(html.join(''));
		}
		if(grEl){
			var html = [];
			var nowGroup = groupEl.val();
			var cr = 0;
			for(var i in grlist){
				var item = grlist[i];
				glist[item.gid].list[item.id] = item;
				html.push('<option value="'+item.id+'">'+item.name+'</option>');
				if(item.list && !cr){
					cr = 1;
					createUn(item.list);
				}
			}
			grEl.html(html.join(''));
		}
	}

	var bind = function(){
		groupEl.change(function(){
			var id = $(this).val();
			var list = glist[id].list;
			console.log(list);
			if($.isEmptyObject(list)){
				createUn([]);
			}else{
				createUn(list,grEl);
			}
		});

		grEl.change(function(){
			var id = $(this).val();
			var list = grlist[id].list;
			console.log(id,list);
			if($.isEmptyObject(list)){
				createUn([]);
			}else{
				createUn(list);
			}
		})

		$("#addWin .btn-primary").click(function(e){
			var data = {
				name : $('#addWin .name').val(),
				type : 0
			}
			$.post(POSTURL,data,function(d){
				if(d.ret == 0){
					window.location.reload();
				}else{
					alert('添加失败!');
				}
			});
		});

		$("#addGrade .btn-primary").click(function(e){
			var data = {
				name : $('#addGrade .name').val(),
				gid : groupEl.val(),
				type : 1
			}
			$.post(POSTURL,data,function(d){
				if(d.ret == 0){
					window.location.reload();
				}else{
					alert('添加失败!');
				}
			});
		});	

		$("#addUnit .btn-primary").click(function(e){
			var data = {
				name : $('#addUnit .name').val(),
				gid : groupEl.val(),
				grid : grEl.val(),
				type : 2
			}
			$.post(POSTURL,data,function(d){
				if(d.ret == 0){
					//window.location.reload();
				}else{
					alert('添加失败!');
				}
			});
		});			

		$('#addGrade').on('show.bs.modal',function(){
			var id = groupEl.val();
			$('#addGrade .gname').text(plist[id]);
			$('#addGrade .gid').val(id);
		});

		$('#addUnit').on('show.bs.modal',function(){
			var id = groupEl.val();
			var gid = grEl.val();
			if(gid){
				$('#addUnit .gname').text(plist[id]);
				$('#addUnit .grname').text(grlist[gid].name);
			}else{
				return;
			}
		});		
	}

	function init(){
		createSelect();
		bind();
	}

	init();
})();
