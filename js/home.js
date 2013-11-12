;(function(){
	var iframeEl = $('#shareIframe');
	var EditMark = '/cgi/editmark', //修改备注
		MoveFile = '/cgi/movefile', //移动文件到文件夹
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
                    console.log(form);
        // do other things for a valid form
                console.log(1234);
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
			max_file_size : '10mb',
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

	var deleteFile = function(item){
		item.remove();
		if($("#fileList .file").length == 0){
			$('#fileList .file-list').hide(200);
		}
	}

 	var recycleImage = function(item ) {

    }	

	function bind(){
		$("#selectAllFile").bind('click',function(){
			if($(this)[0].checked){
				$('#fileList .fclick:not(:checked)').each(function(){
					$(this).click();
				});
			}else{
				console.log(1222);
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
				case 'delFile':
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
			if($(e.target).is(":checked")){
				$('.tool-zone').addClass('hide');
				$('.file-act-zone').removeClass('hide');
			}else{
				$('.tool-zone').removeClass('hide');
				$('.file-act-zone').addClass('hide');	
			}
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

		$("#fileList input").click(function(e){
			if($(e.target).is(":checked")){
				$('.tool-zone').addClass('hide');
				$('.file-act-zone').removeClass('hide');
			}else{
				$('.tool-zone').removeClass('hide');
				$('.file-act-zone').addClass('hide');	
			}
		})

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

		 $('.btn-new-fold').click(function(){
		 	var value = $('#foldname').val();
		 	var pid = $('#newFolds .parentid').val();
		 	console.log(pid);
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