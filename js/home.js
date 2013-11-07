;(function(){
	/*
	$("#newFold").validate({
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
	*/

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
			},
			Error: function(up, err) {
				console.log(up,err);
				document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
			}
		}
	});

	uploader.init();



	function init(){
		$("#fileList .file").draggable({ 
			revert: true
		});

		$("#fileList .file").click(function(){
			$('#reviewFile').modal('show');
		});


		$("#fileList .fold").droppable({
		  accept: "#fileList .file",
		  drop: function( event, ui ) {
		    deleteFile( ui.draggable );
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
		 	if(value != ''){
		 		//console.log(value);
		 		$.post('/cgi/addfold',{name: value},function(d){
		 			console.log(typeof d,d,d[0]);
		 		});
		 	}
		 });
	}



	init();
})();