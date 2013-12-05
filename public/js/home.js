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
			 	if(value != ''){
			 		////console.log(value);
			 		$.post('/cgi/addfold',{name: value,pid: pid,csrf_test_name:$.cookie('csrf_cookie_name')},function(d){
			 			if(d.code==0){
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
        	var type = parseInt($('#reName .type').val());
        	var data = {
        		fname : $('#reName .foldname').val(),
        		fid : $('#reName .fid').val(),
        		csrf_test_name:$.cookie('csrf_cookie_name')
        	}
        	if(type){
        		url = '/cgi/renamefold';
        	}else{
        		url = '/cgi/renamefile';
        	}
        	$.post(url,data,function(d){
	 			if(d.code==0){
	 				$("#renameFile .close").click();
	 				window.location.reload();
	 			}else{
	 				alert(d.msg);
	 			}
	 			$("#renameFile .close").click();
        	});
            return false;
        }
    });   
    $("#remarkFile").validate({
        rules:{
            comment : {
                    required : true,
                    maxlength : 255,
                    minlength : 2
            } 
        },
        messages:{
            fname : {
                    require : '请填写评论内容',
                    maxlength : '评论最多255个字',
                    minlength : '评论最少需要2个字'
            }
        },
        submitHandler : function(form) {
        	var data = {
        		comment : $('#remarkFile .text-content').val(),
        		fid : $('#remarkFile .fid').val(),
        		csrf_test_name:$.cookie('csrf_cookie_name')
        	}
        	$.post('/cgi/add_file_comment',data,function(d){
	 			if(d.code==0){
	 				$("#remarkFile .close").click();
	 				window.location.reload();
	 			}else{
	 				alert(d.msg);
	 			}
	 			$("#remarkFile .close").click();
        	});
            return false;
        }
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
				//console.log('/share/other?id='+id);
				iframeEl.attr('src','/share/other?id='+id);
				break;
			case 'togroup':
				$('#shareWin h4').text('共享 到小组空间');
				iframeEl.attr('src','/share/group?id='+id);
				break;
			case 'todep':
				$('#shareWin h4').text('共享 到部门空间');
				iframeEl.attr('src','/share/dep?id='+id);
				break;
		}
	}

	var copyFile = function(){
		var il = [];
		$('#fileList .fclick:checked').each(function(){
			il.push($(this).val());
		});

		id = il.join(',');
		$('#shareWin h4').text('复制');

		iframeEl.attr('src','/home/movefile?fid='+id);		
	};	

	var editMark = function(id,mark,type,target){
		var data = {
			id : id,
			info : mark,
			t : type,
			csrf_test_name:$.cookie('csrf_cookie_name')
		}

		$.post(EditMark,data,function(d){
			if(d.code == 0){
				target.parent('span').prev('span').text(d.info);
			}else{
				//console.log(d.msg);
			}
		});
	};

	var collFiles = function(){
		var il = [];
		$('#fileList .fclick:checked').each(function(){
			//if($(this).parents('li.file').find('i.s').length == 0){
				il.push($(this).val());
			//}
		});	
		id = il.join(',');
		console.log(id);
		$.post(AddColl,{id:id,csrf_test_name:$.cookie('csrf_cookie_name')},function(d){
			if(d.code == 0){
				//target.parent('span').prev('span').text(d.info);
				window.location.reload();
			}else{
				//console.log(d.msg);
			}
		});		
	}

    function downFiles(){
		$('#fileList .fclick:checked').each(function(){
			window.open('/cgi/downfile?fid='+files[$(this).val()].fid);
		});	
    }

	var collFile = function(id,target){
		var data = {
			id : id
		}
		$.post(AddColl,data,function(d){
			//console.log(d);
			if(d.code == 0){
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
			if(d.code == 0){
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

 	var recycleImage = function(item ) {

    }	

    var toSchool = function(id){
    	$.post('/cgi/to_school',{id:id},function(d){
    		if(d.code== 0){
				alert('复制成功');
    		}else{
    			alert('复制失败');
    		}
    	});
    }

    //显示或者隐藏重命名和评论
    var checkAct = function(){
    	var l = $('#fileList .fclick:checked').length;
    	$('#fileList .fdclick:checked').each(function(){
    		$(this).attr('checked',false);
    	});
	    	$('#fileActZone .sharefile').show();
	    	$('#fileActZone .downfile').show();
	    	$('#fileActZone .collfile').show();    		
	    	$('#fileActZone .copyfile').show();     	
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


    //显示或者隐藏重命名和评论
    var checkFoldAct = function(){
    	var l = $('#fileList .fdclick:checked').length;
    	$('#fileList .fclick:checked').each(function(){
    		$(this).attr('checked',false);
    	});   	
    	if(l==0){
			$('.tool-zone').removeClass('hide');
			$('.file-act-zone').addClass('hide');
    	}else{
	    	$('#fileActZone .sharefile').hide();
	    	$('#fileActZone .downfile').hide();
	    	$('#fileActZone .collfile').hide();    		
	    	$('#fileActZone .copyfile').hide(); 
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

	function bind(){
		$('#donwFiles').bind('click',function(){
			downFiles();
		});


		$('#uploadFile').bind('hide.bs.modal',function(){
			$('#file_uploadList').html('');
		});

		$("#delFile").bind('show.bs.modal',function(){
			var id = [];
			if($('#fileList .fclick:checked').length > 0){
				$('#fileList .fclick:checked').each(function(e){
					var item = files[$(this).val()];
					id.push(item.id);
					$('#delFile .filelist').append('<li>'+item.name+'</li>');
				});

				$('#delFile .modal-title').text('删除文件');
				$('#delFile .modal-body span').text('将要删除文件:');
				$('#delFile').attr('data-type','file');
			}else{
				$('#fileList .fdclick:checked').each(function(e){
					var item = folds[$(this).val()];
					id.push(item.id);
					$('#delFile .filelist').append('<li>'+item.name+'</li>');
				});	
				$('#delFile .modal-title').text('删除文件夹');	
				$('#delFile .modal-body span').text('将要删除文件夹:');		
				$('#delFile').attr('data-type','fold');
			}
			$('#delFile .fid').val(id.join(','));
		});

		$("#delFile").bind('hide.bs.modal',function(){
			$('#delFile .filelist').html('');
			$('#delFile .fid').val('');
		});

		$("#delFile .btn-del").bind('click',function(){
			var id = $('#delFile .fid').val();
			var type = $('#delFile').attr("data-type");
			var url;
			if(type == 'file'){
				url = '/cgi/del_file?type=0';
			}else{
				url = '/cgi/del_fold?type=0'
			}

			$.post(url,{id: id,csrf_test_name:$.cookie('csrf_cookie_name')},function(d){
				$("#delFile .close").click();
	 			if(d.code==0){
	 				window.location.reload();
	 			}else{
	 				alert(d.msg);
	 			}
			});
		});

		$('#renameFile').bind('show.bs.modal',function(){
			var item = files[$('#fileList .fclick:checked').val()];
			if(!item){
				item = folds[$('#fileList .fdclick:checked').val()];
				$('#renameFile .type').val(1);
			}else{
				$('#renameFile .type').val(0);
			}
			$('#renameFile .fid').val(item.id);	
			$('#renameFile .foldname').val(item.name);
		});

		$('#commentFile').bind('show.bs.modal',function(){
			var item = files[$('#fileList .fclick:checked').val()];
			$('#commentFile .fname').text(item.name);
			$('#commentFile .fid').val(item.id);
		});		

		$("#selectAllFile").bind('click',function(){
			if($(this)[0].checked){
				$('#fileList .fclick:not(:checked)').each(function(){
					$(this).click();
				});
			}else{
				$('#fileList .fclick:checked').each(function(){
					$(this).attr('checked',false);
				});
			}
		});

		$("#selectAllFold").bind('click',function(){
			if($(this)[0].checked){
				$('#fileList .fdclick:not(:checked)').each(function(){
					$(this).click();
				});
			}else{
				$('#fileList .fdclick:checked').each(function(){
					$(this).attr('checked',false);
				});
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

		$("#fileList .file").draggable({ 
			revert: true
		});

		$("#fileList .file .file-name").click(function(e){
			var target = $(e.target);
			var fid = target.attr('data-fid');
			var id= target.attr('data-id');
			//review?fid=24&t=2&gid=0&id=18
			$("#reviewIframe").attr('src','/review?fid='+fid+'&id='+id);
			$('#reviewFile').modal('show');
		});


		$("#fileList .fold").droppable({
		  accept: "#fileList .file",
		  drop: function( e, ui ) {

		  	var data = {
		  		'tid' : $(e.target).attr('data-id'),
		  		'fid' : $(ui.draggable).attr('data-id'),
		  		csrf_test_name:$.cookie('csrf_cookie_name')
		  	}
		  	$.post(MoveFile,data,function(d){
		  		//console.log(d);
		  		if(d.code == 0){
		  			deleteFile( ui.draggable );		
		  		}
		  	});
		  }
		});

		$('#actDropDown a').click(function(e){

		});

		$("#fileList input").click(function(e){
			if($(e.target).attr('class') == 'fclick'){
				checkAct();
			}else{
				checkFoldAct();
			}
		})

		$('#collFiles').bind('click',collFiles);

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
				case 'toschool':
					var id = target.attr('data-id');
					toSchool(id);
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

		$('#changeType').bind('click',function(e){
			var dom = $(this);
			if(dom.attr('class') == 'list-type'){
				dom.attr('class','icon-type');
				dom.find('span').text('列表');
				//dom.text('列表')
				$('#fileList').attr('class','dis-list-type');
			}else{
				dom.attr('class','list-type');
				$('#fileList').attr('class','dis-ico-type');	
				dom.find('span').text('图标');
				//dom.html('<i></i>图标')	
			}
		})

		$('#myColl').bind('click',function(){
			$("#mailbox h4").text('收藏夹');
			$("#mailIframe").attr('src','/home/coll');
		});

		$('#myRecy').bind('click',function(){
			$("#mailbox h4").text('回收站');
			$("#mailIframe").attr('src','/home/recy');
		});		

		$('#shareHis').bind('click',function(e){
			var target = $(e.target),
				cmd = target.attr('cmd');
			switch(cmd){
				case 'send':
					$("#mailbox h4").text('发件箱');
					$("#mailIframe").attr('src','/home/sendmail?m=0');
					break;
				case 'get':
					$("#mailbox h4").text('收件箱');
					$("#mailIframe").attr('src','/home/sendmail?m=1');
					break;	
				case 'share':
					$("#mailbox h4").text('我的共享');	
					$("#mailIframe").attr('src','/home/groupmail');
					break;	
			}
		});
	}


	function init(){
		bind();
	}

	init();
})();

function hideShare(){
	$('#shareWin').modal('hide');
}
function sharealert(msg){
	alert(msg);
}