/*
$('#header').delegate('.userinfo','click',function(e){
	var target = $(e.target);
	target.toggleClass('show');
});
$('#header').delegate('.header-nav > li','click',function(e){
	$('.header-nav > li').removeClass('show');
	var target = $(e.target);
	target.toggleClass('show');	
});
$('#header').delegate('.menu','mouseleave ',function(e){
	//$(e.target).hide();
});
*/
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
$('#changeFileType').bind('click',function(e){


});

var progs = new window.szone.widget.prog('正在上传');
$('#uploadFile').bind('change',function(e){
	var file = e.target.files[0];

	

	var rd = new FileReader();
	rd.onload = function(e){
		//console.log(this.result);
	}
	rd.readAsDataURL(file);

	var fd = new FormData();

	fd.append('files',file);

	var xhr = new XMLHttpRequest();
	xhr.upload.addEventListener("progress", uploadProgress, false);
    xhr.addEventListener("load", uploadComplete, false);
    xhr.addEventListener("error", uploadFailed, false);
    xhr.addEventListener("abort", uploadCanceled, false);
    xhr.open("POST", "/Upload.php");
    xhr.send(fd);	
    progs.show();
    progs.setProg(0);
});


function uploadProgress(evt) {
	//console.log(evt);
    if (evt.lengthComputable) {
        var percentComplete = Math.round(evt.loaded * 100 / evt.total);
        //console.log(percentComplete);
        progs.setProg(percentComplete);
        //document.getElementById('progressNumber').innerHTML = percentComplete.toString() + '%';
    }
    else {
        //document.getElementById('progressNumber').innerHTML = 'unable to compute';
    }
}

function uploadComplete(evt) {
	progs.hide();
    /* This event is raised when the server send back a response */
    //alert(evt.target.responseText);
}

function uploadFailed(evt) {
    //alert("There was an error attempting to upload the file.");
}

function uploadCanceled(evt) {
    //alert("The upload has been canceled by the user or the browser dropped the connection.");
}        



