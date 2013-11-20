;(function(){

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
			 		//console.log(value);
			 		$.post('/cgi/addfold',{name: value,pid: pid,gid:gid},function(d){
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

	var uploader = new plupload.Uploader({
		runtimes : 'html5,flash,silverlight,html4',
		browse_button : 'btnUpload', // you can pass in id...
		container: document.getElementById('uploadContainer'), // ... or DOM Element itself
		url : '/cgi/gupload?gid='+nowGroupId,
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
						uploader.settings.url = '/cgi/gupload?gid='+nowGroupId+'&fid='+fid;
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
				//document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
			}
		}
	});

	uploader.init();

	$("#groupDesc a").bind('click',function(){
		$("#groupDesc").hide();
		$("#groupEdit").removeClass('hide');
	})

	$('#groupEdit .save').bind('click',function(){
		var c = $('#groupEdit textarea').val();
		$.post('/cgi/group_edit_desc',{d:c,gid:ginfo.id},function(d){
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
		$.post('/cgi/add_board',{d:c,gid:ginfo.id,type:1,pid:0},function(d){
			if(d.ret == 0){
				//$('#postWin').modal('hide');
				window.location.reload();
			}else{
				alert(d.msg);
			}
		});
	});
})()