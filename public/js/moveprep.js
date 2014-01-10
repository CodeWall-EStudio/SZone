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
		var dom = $('#prepList a.selected');
		var pid = dom.attr('data-pid');
		var fdid = dom.attr('data-id');
		/*.each(function(){
			plist.push($(this).attr('data-id'));
		});
		*/
		var data = {
			fid : $('#flist').val(),
			fdid : fdid,
			pid : pid
		}

		$.post('/cgi/add_prep',data,function(d){
			if(d.code == 0){
				top.hideShare();
				top.location.reload();
			}else{
				top.hideShare();
				top.alert(d.data.msg);
			}
		});
	}

	//绑定事件
	function bind(){
		// $('#prepList ul').bind('show.bs.collapse',function(e){
		// 	var target = $(e.target);
		// 	target.parent('li').find('.i-c').text('-');
		// });

		// $('#prepList ul').bind('hide.bs.collapse',function(e){
		// 	var target = $(e.target);
		// 	target.parent('li').find('.i-c').text('+');
		// });	

		// $('#prepList a.a-click').bind('click',function(e){
		// 	var target = $(e.target);
		// 	if(target.hasClass("selected")){
		// 		target.removeClass('selected');
		// 	}else{
		// 		target.addClass('selected');
		// 	}
		// 	check();			
		// });

		$("#prepList").bind('click',function(e){
			var t = $(e.target),
				id = t.attr('data-fid'),
				pid = t.attr('data-pid'),
				nodata = t.attr('no-data');
				$("#prepList a").removeClass('selected');
			if(t.hasClass('a-click')){
				if(t.hasClass("selected")){
					t.removeClass('selected');
				}else{
					t.addClass('selected');
				}
				check();
			}
			if(!pid || nodata){
				return;
			}
			var p = t.parent('li');
			if(p.find('ul').length > 0){
				if(t.hasClass("glyphicon-minus")){
					t.removeClass('glyphicon-minus');
					p.find('ul').hide();
				}else{
					t.addClass('glyphicon-minus');
					p.find('ul').show();
				}
				return;
			}
			//glyphicon-minus
			$.get('/cgi/get_prep_fold_lev',{fid: id,gid:pid},function(d){
				if(d.code == 0){
					var tmp = $("#fold-list-tmp").html();
					var obj = {
						list : d.data.list,
						pid : pid
					}
					p.append($.tmp(tmp,obj));
					t.addClass('glyphicon-minus');
				}else{
					t.attr('no-data',1);
				}
			});
		});

		$("#post").bind('click',postdata);
	}

	function init(){
		bind();
	}

	init();
})();