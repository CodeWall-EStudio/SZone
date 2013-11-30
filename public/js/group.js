;(function(){
	var iframeEl = $('#shareIframe');
	var EditMark = '/cgi/editmark', //修改备注
		MoveFile = '/cgi/movefile', //移动文件到文件夹
		UnColl = '/cgi/uncoll',
		AddColl = '/cgi/addcoll';   //添加收藏
    $("#newFolds").validate({
            rules:{
                    foldname : {
                            required : true,
                            maxlength : 120,
                            minlength : 2
                    } 
            },
            messages:{
                    foldname : {
                            require : '请输入文件夹名称',
                            maxlength : '文件名称最长120个字',
                            minlength : '文件名称至少需要2个字'
                    }
            },
            submitHandler : function(form) { 
			 	var value = $('#foldname').val();
			 	var pid = $('#newFolds .parentid').val();
			 	var gid = $('#newFolds .groupid').val();
			 	if(value != ''){
			 		////console.log(value);
			 		$.post('/cgi/addfold',{name: value,pid: pid,gid:gid,csrf_test_name:$.cookie('csrf_cookie_name')},function(d){
			 			if(d.ret==0){
			 				$("#newFold .close").click();
			 				window.location.reload();
			 			}else{
			 				alert(d.msg);
			 			}
			 			$("#newFold .close").click();
			 		});
			 	}            	
                //return false;
            }
    });

    $("#reName").validate({
        rules:{
            fname : {
                    required : true,
                    maxlength : 120,
                    minlength : 2
            } 
        },
        messages:{
            fname : {
                    require : '请输入文件名称',
                    maxlength : '文件名称最长120个字',
                    minlength : '文件名称至少需要2个字'
            }
        },
        submitHandler : function(form) {
        	var data = {
        		fname : $('#reName .foldname').val(),
        		fid : $('#reName .fid').val(),
        		gid : ginfo.id,
        		csrf_test_name:$.cookie('csrf_cookie_name')
        	}
        	$.post('/cgi/renamefile',data,function(d){
	 			if(d.ret==0){
	 				$("#renameFile .close").click();
	 				//window.location.reload();
	 			}else{
	 				alert(d.msg);
	 			}
	 			$("#renameFile .close").click();
        	});
            return false;
        }
    });


	function bind(){

		$('#renameFile').bind('show.bs.modal',function(){
			var item = files[$('#fileList .fclick:checked').val()];
			$('#renameFile .foldname').val(item.name);
			$('#renameFile .fid').val(item.id);
		});

		$("#delFile").bind('show.bs.modal',function(){
			var id = []
			$('#fileList .fclick:checked').each(function(e){
				var item = files[$(this).val()];
				id.push(item.fid);
				$('#delFile .filelist').append('<li>'+item.name+'</li>');
			});
			$('#delFile .fid').val(id.join(','));
		});

		$("#delFile").bind('hide.bs.modal',function(){
			$('#delFile .filelist').html('');
			$('#delFile .fid').val('');
		});	


		$("#delFile .btn-del").bind('click',function(){
			var id = $('#delFile .fid').val();
			$.post('/cgi/del_file?type=0',{gid: ginfo.id,id: id,csrf_test_name:$.cookie('csrf_cookie_name')},function(d){
	 			if(d.ret==0){
	 				$("#delFile .close").click();
	 				//window.location.reload();
	 			}else{
	 				alert(d.msg);
	 			}
	 			$("#delFile .close").click();
			});
		});		

		$('#collFiles').bind('click',collFiles);

		$("#groupDesc a").bind('click',function(){
			$("#groupDesc").hide();
			$("#groupEdit").removeClass('hide');
		})

		$('#groupEdit .save').bind('click',function(){
			var c = $('#groupEdit textarea').val();
			$.post('/cgi/group_edit_desc',{d:c,gid:ginfo.id,csrf_test_name:$.cookie('csrf_cookie_name')},function(d){
				if(d.ret == 0){
					$("#groupDesc p").text(c);
					$("#groupDesc").show();
					$("#groupEdit").addClass('hide');
				}else{
					alert(d.msg);
				}
			});
		});
		$('#groupEdit .sec').bind('click',function(){
			$("#groupDesc").show();
			$("#groupEdit").addClass('hide');
		});	

		$("#postWin .btn-post").bind('click',function(){
			var c = $("#postWin textarea").val(); 
			$.post('/cgi/add_board',{d:c,gid:ginfo.id,type:1,pid:0,csrf_test_name:$.cookie('csrf_cookie_name')},function(d){
				if(d.ret == 0){
					//$('#postWin').modal('hide');
					window.location.reload();
				}else{
					alert(d.msg);
				}
			});
		});

		var showShare = function(id,cmd){
			var il = [],
				nl = [];
			if(!id){
				$('#fileList .fclick:checked').each(function(){
					il.push($(this).val());
				});
			}else if(typeof id == 'string'){
				il.push(id);
				nl.push(name);
			}else{
				il = id;
				nl = name;
			}
			var id = il.join(',');
			switch(cmd){
				case 'toother':
					$('#shareWin h4').text('共享 发送给别人');
					//console.log(12345);
					iframeEl.attr('src','/share/other?id='+id+'&gid='+ginfo.id);
					break;
				case 'togroup':
					$('#shareWin h4').text('共享 到小组空间');
					iframeEl.attr('src','/share/group?id='+id+'&gid='+ginfo.id);
					break;
				case 'todep':
					$('#shareWin h4').text('共享 到部门空间');
					iframeEl.attr('src','/share/dep?id='+id+'&gid='+ginfo.id);
					break;
			}
		}	

		var collFiles = function(){
			var il = [];
			$('#fileList .fclick:checked').each(function(){
				//if($(this).parents('li.file').find('i.s').length == 0){
					il.push($(this).val());
				//}
			});	
			id = il.join(',');
			$.post(AddColl,{id:id,csrf_test_name:$.cookie('csrf_cookie_name')},function(d){
				if(d.ret == 0){
					//target.parent('span').prev('span').text(d.info);
					window.location.reload();
				}else{
					//console.log(d.msg);
				}
			});		
		}

		var collFile = function(id,target){
			var data = {
				id : id,
				csrf_test_name:$.cookie('csrf_cookie_name')
			}
			$.post(AddColl,data,function(d){
				//console.log(d);
				if(d.ret == 0){
					target.addClass('s');
				}
			});
		}

		var uncollFile = function(id,target){
			var data = {
				id : id,
				csrf_test_name:$.cookie('csrf_cookie_name')
			}
			$.post(UnColl,data,function(d){
				//console.log(d);
				if(d.ret == 0){
					target.removeClass('s');
				}
			});		
		}

		var deleteFile = function(item){
			item.remove();
			if($("#fileList .file").length == 0){
				$('#fileList .file-list').hide(200);
			}
		}	





	    //显示或者隐藏重命名和评论
	    var checkAct = function(){
	    	var l = $('#fileList .fclick:checked').length;
	    	//console.log(l);
	    	if(l==0){
				$('.tool-zone').removeClass('hide');
				$('.file-act-zone').addClass('hide');
	    	}else{
				$('.tool-zone').addClass('hide');
				$('.file-act-zone').removeClass('hide');
	    		if(l>1){
		    		$('#renameAct').addClass('hide');
		    		$('#remarkAct').addClass('hide');
	    		}else{
		    		$('#renameAct').removeClass('hide');
		    		$('#remarkAct').removeClass('hide');
	    		}
	    	}
	    }
	    //输入框点击事件
		$("#fileList input").click(function(e){
			checkAct();
		})    

		$('#fileList').bind('click',function(e){
			var target = $(e.target),
				cmd = target.attr('cmd');
			switch(cmd){
				case 'toother':
				case 'togroup':
				case 'todep':
					var id = target.attr('data-id');
					var name = target.attr('data-name');
					showShare(id,cmd);
					break;
				case 'coll':
					var id = target.attr('data-id'),
						type = target.attr('data-type');
						if(type == 'file'){
							collFile(id,target);
						}
					break;
				case 'uncoll':
					var id = target.attr('data-id'),
						type = target.attr('data-type');
						if(type == 'file'){
							uncollFile(id,target);
						}				
					break;
				case 'edit':
					target.hide();
					target.next('span').removeClass('hide');
					break;
				case 'editComp':
					var mark = target.prev('input').val(),
						id = target.attr('data-id'),
						type = target.attr('data-type');
						//console.log(id,type);
						editMark(id,mark,type,target);
						target.parent('span').prev('span').show();
						target.parent('span').addClass('hide');						
					break;
				case 'editClose':
					var mark = target.attr('data-value');
					target.prev('input').val(mark);
					target.parent('span').prev('span').show();
					target.parent('span').addClass('hide');
					break;
			}
		});	

		$('.file-act-zone a').bind('click',function(e){
			var target = $(e.target),
				cmd = target.attr('cmd');
			switch(cmd){
				case 'toother':
				case 'togroup':
				case 'todep':
					showShare(null,cmd);
					break;
				case 'copyFile':
					copyFile();
					break;							
			}
		})

		$("#fileList .file .file-name").click(function(e){
			var target = $(e.target);
			var fid = target.attr('data-fid');
			var id= target.attr('data-id');
			//review?fid=24&t=2&gid=0&id=18
			$("#reviewIframe").attr('src','/review?fid='+fid+'&id='+id);
			$('#reviewFile').modal('show');
		});	

	}

	function init(){
		bind();
	}

	init();	
})()

function hideShare(){
	$('#shareWin').modal('hide');
}
function sharealert(msg){
	alert(msg);
}