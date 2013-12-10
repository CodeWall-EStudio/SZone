;(function(){
	$('.btn-upload').bind('click',function(){
		$('#uploadFile').slideDown(400);
	});

	$('#uploadFile').bind('click',function(e){
		var t = $(e.target),
			cmd = t.attr("cmd");
		switch(cmd){
			case 'close':
				
				if($('#uploader_filelist .plupload_delete').length > 0){
					$('#uploadFile .modal-body').slideUp(400,function(){
						window.location.reload();
					});
				}else{
					$('#uploadFile').slideUp(400);
					$('#uploader_filelist').html('');
				};
				break;
			case 'min':
				$('#uploadFile .modal-body').slideToggle(400,function(e){
					if(t.text() == '-'){
						t.text('o');
					}else{
						t.text('-');	
					}
				});
				break;
		}
	});
	//'/cgi/gupload?gid='+nowGroupId+'&csrf_test_name='+$.cookie('csrf_cookie_name'),

	var upUrl = '/cgi/upload?csrf_test_name='+$.cookie('csrf_cookie_name');
	if(typeof nowGroupId != 'undefined'){
		upUrl = '/cgi/gupload?gid='+nowGroupId+'&csrf_test_name='+$.cookie('csrf_cookie_name');
	}
	upUrl +='&fid='+fid;
	$("#uploader").pluploadQueue({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : upUrl,
		chunk_size: '1mb',
		rename : true,
		dragdrop: true,

		file_data_name: 'file',
		/*
		filters : {
			// Maximum file size
			max_file_size : '500mb',
			// Specify what files to browse for
			mime_types: [
				{title : "图片", extensions : "jpg,gif,png"},
				{title : "文档", extensions : "doc,txt"},
				{title : "音乐", extensions : "mid,mp3"},
				{title : "视频", extensions : "avi,mp4"},
				{title : "应用", extensions : "exe"},
				{title : "压缩文件", extensions : "zip"}
				// {title : "文本", extensions : "txt"},
			]
		},
		*/

		// Resize images on clientside if we can
		//resize : {width : 320, height : 240, quality : 90},

		flash_swf_url : '../../js/moxie.swf',
		silverlight_xap_url : '../../js/moxie.xap'
	}).bind('allcomplete',function(){
		window.location.reload();
	});

})();
