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
			 		//console.log(value);
			 		$.post('/cgi/addfold',{name: value,pid: pid},function(d){
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
        		fid : $('#reName .fid').val()
        	}
        	$.post('/cgi/renamefile',data,function(d){
	 			if(d.ret==0){
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
        		fid : $('#remarkFile .fid').val()
        	}
        	$.post('/cgi/add_file_comment',data,function(d){
	 			if(d.ret==0){
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

	var uploader = new plupload.Uploader({
		runtimes : 'html5,flash,silverlight,html4',
		browse_button : 'btnUpload', // you can pass in id...
		container: document.getElementById('uploadContainer'), // ... or DOM Element itself
		url : '/cgi/upload',
		unique_names : true,
		flash_swf_url : '/js/lib/Moxie.swf',
		silverlight_xap_url : '/js/lib/Moxie.xap',
		
		filters : {
			max_file_size : '500mb',
			mime_types: [
				{title : "图片", extensions : "jpg,gif,png"},
				{title : "文档", extensions : "doc,txt"},
				{title : "音乐", extensions : "mid,mp3"},
				{title : "视频", extensions : "avi,mp4"},
				{title : "应用", extensions : "exe"},
				{title : "压缩文件", extensions : "zip"}
				// {title : "文本", extensions : "txt"},
				// {title : "word文档", extensions : "doc"}
			]
		},

		init: {
			PostInit: function() {
				$('#file_uploadList').html('');
				//document.getElementById('file_uploadList').innerHTML = '';
				$('#btnStartUload').bind('click',function(){
					//uploader.settings.url = '';
					var fid = $('#uploadFile .foldid').val();
					if(fid){
						uploader.settings.url = '/cgi/upload?fid='+fid;
					}
					uploader.start();
				});
			},
			FilesAdded: function(up, files) {
				console.log(plupload);
				plupload.each(files, function(file) {
					$('#file_uploadList').append('<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>');

				});
			},

			UploadProgress: function(up, file) {
				document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			},
			FileUploaded: function(e,file){
				console.log(e,file);
				//window.location.reload();
			},
			Error: function(up, err) {
				console.log(up,err);
				document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
			}
		}
	});

	uploader.init();

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
				console.log('/share/other?id='+id);
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
			t : type
		}

		$.post(EditMark,data,function(d){
			if(d.ret == 0){
				target.parent('span').prev('span').text(d.info);
			}else{
				console.log(d.msg);
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
		$.post(AddColl,{id:id},function(d){
			if(d.ret == 0){
				//target.parent('span').prev('span').text(d.info);
				window.location.reload();
			}else{
				console.log(d.msg);
			}
		});		
	}

	var collFile = function(id,target){
		var data = {
			id : id
		}
		$.post(AddColl,data,function(d){
			console.log(d);
			if(d.ret == 0){
				target.addClass('s');
			}
		});
	}

	var uncollFile = function(id,target){
		var data = {
			id : id
		}
		$.post(UnColl,data,function(d){
			console.log(d);
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

 	var recycleImage = function(item ) {

    }	

    //显示或者隐藏重命名和评论
    var checkAct = function(){
    	var l = $('#fileList .fclick:checked').length;
    	if(l==0){
			$('.tool-zone').addClass('hide');
			$('.file-act-zone').removeClass('hide');
    	}else{
			$('.tool-zone').removeClass('hide');
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
		$('#uploadFile').bind('hide.bs.modal',function(){
			$('#file_uploadList').html('');
		});

		$("#delFile").bind('show.bs.modal',function(){
			var id = []
			$('#fileList .fclick:checked').each(function(e){
				var item = files[$(this).val()];
				id.push(item.id);
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
			$.post('/cgi/del_file?type=0',{id: id},function(d){
	 			if(d.ret==0){
	 				$("#delFile .close").click();
	 				window.location.reload();
	 			}else{
	 				alert(d.msg);
	 			}
	 			$("#delFile .close").click();
			});
		});

		$('#renameFile').bind('show.bs.modal',function(){
			var item = files[$('#fileList .fclick:checked').val()];
			$('#renameFile .foldname').val(item.name);
			$('#renameFile .fid').val(item.id);
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

		$("#fileList .file .file-name").click(function(){
			$('#reviewFile').modal('show');
		});


		$("#fileList .fold").droppable({
		  accept: "#fileList .file",
		  drop: function( e, ui ) {

		  	var data = {
		  		'tid' : $(e.target).attr('data-id'),
		  		'fid' : $(ui.draggable).attr('data-id')
		  	}
		  	$.post(MoveFile,data,function(d){
		  		console.log(d);
		  		if(d.ret == 0){
		  			deleteFile( ui.draggable );		
		  		}
		  	});
		  }
		});

		$('#actDropDown a').click(function(e){

		});

		$("#fileList input").click(function(e){
			// if($(e.target).is(":checked")){
			// 	$('.tool-zone').addClass('hide');
			// 	$('.file-act-zone').removeClass('hide');
			// }else{
			// 	$('.tool-zone').removeClass('hide');
			// 	$('.file-act-zone').addClass('hide');	
			// }
			checkAct();
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
						console.log(id,type);
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