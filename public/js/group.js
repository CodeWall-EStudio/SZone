;(function(){
	console.log(nowGroupId);
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
})()