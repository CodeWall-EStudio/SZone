define(['util','view','model.my'],function($u,View,my){
	var handlerObj = $(schoolObj),
		nowType = 'user'; //1 个人 2,小组

	var iframeEl = $('#shareIframe');
	var fileView = new View({}),
		fileWinView = new View({}),
		fileTarget = $('#fileList');

	//收藏文件
	function collFile(e){
		var target = $(e.target),
			fid = target.attr('data-id'),
			il = [];
		if(target){
			il.push(fid);
		}else{
			var il = [];
			$('#fileList .fclick:checked').each(function(){
					il.push($(this).val());
			});	
		}
		id = il.join(',');
		handlerObj.triggerHandler('myspace:collFile',{id:id,type:nowType});	
	}

	//取消收藏文件
	function uncollFile(e){
		var target = $(e.target),
			fid = target.attr('data-id'),
			il = [];
		if(target){
			il.push(fid);
		}else{
			var il = [];
			$('#fileList .fclick:checked').each(function(){
					il.push($(this).val());
			});	
		}
		id = il.join(',');
		handlerObj.triggerHandler('myspace:uncollFile',{id:id,type:nowType});	
	}

	//选择所以文件夹
	function selectAllFold(e){
		var dom = $(".select-all-fold");
		if(dom[0].checked){
			$('#fileList .fdclick:not(:checked)').each(function(){
				$(this).click();
			});
		}else{
			$('#fileList .fdclick:checked').each(function(){
				$(this).attr('checked',false);
			});
		}
	}
	//选择所以文件
	function selectAllFile(e){
		var dom = $(".select-all-file");
		if(dom[0].checked){
			$('#fileList .fclick:not(:checked)').each(function(){
				$(this).click();
			});
		}else{
			$('#fileList .fclick:checked').each(function(){
				$(this).attr('checked',false);
			});
		}
	}

    //显示或者隐藏重命名和评论
    var checkFile = function(){
    	var l = $('#fileList .fclick:checked').length;
    	if(l==0){
			$('.tool-zone').removeClass('hide');
			$('.file-act-zone').addClass('hide');
    	}else{
			$('.tool-zone').addClass('hide');
			$('.file-act-zone').removeClass('hide');
    		if(l>1){
	    		$('.rename-act').addClass('hide');
    		}else{
	    		$('.rename-act').removeClass('hide');
    		}
    	}
    }


    //显示或者隐藏重命名和评论
    var checkFold = function(){
    	var l = $('#fileList .fdclick:checked').length;
    	if(l==0){
			$('.tool-zone').removeClass('hide');
			$('.file-act-zone').addClass('hide');

			$('.share-act').removeClass('hide');
			$('.down-act').removeClass('hide');
			$('.coll-act').removeClass('hide');			
    	}else{
			$('.tool-zone').addClass('hide');
			$('.file-act-zone').removeClass('hide');

			$('.share-act').addClass('hide');
			$('.down-act').addClass('hide');
			$('.coll-act').addClass('hide');
    		if(l>1){
	    		$('.rename-act').addClass('hide');
    		}else{
	    		$('.rename-act').removeClass('hide');
    		}
    	}
    }    

	var fileHandler = {
		'.coll-file' : {
			click : collFile
		},
		'.select-all-file' : {
			click : selectAllFile
		},
		'.select-all-fold' : {
			click : selectAllFold
		},
		'.fdclick' :{
			click : checkFold
		},
		'.fclick' : {
			click : checkFile
		},
		'.uncoll-file' : {
			click : uncollFile
		},
		'.share-to-other' : {
			click : function(e){
				var id = $(e.target).attr('data-id');
				showShare(id,'other');
			}
		},
		'.share-to-group' : {
			click : function(e){
				var id = $(e.target).attr('data-id');
				showShare(id,'group');
			}
		},
		'.share-to-dep' : {
			click : function(e){
				var id = $(e.target).attr('data-id');
				showShare(id,'dep');
			}
		}
	};

	function renderFile(e,d){
		var data = d;
		var opt = {
			target : fileTarget,
			tplid : 'file-list',
			data : {
				fold:data.fold,
				file:data.file
			},
			handlers : fileHandler
		}
		fileView.expand(opt);
		fileView.createPanel();
	}

	function init(e,d){
		if(d == 1){
			nowType = 'user';
		}else{
			nowType = 'group';
		}
	}

	function collSuc(e,d){
		var list = id.split(',');
		for(var i = 0,l=list.length;i<l;i++){
			$("#coll"+list[i]).attr('class','uncoll-file s');
		}
	}

	function uncollSuc(e,d){
		var list = id.split(',');
		for(var i = 0,l=list.length;i<l;i++){
			$("#coll"+list[i]).attr('class','coll-file');
		}
	}	

	var handlers = {
		"myspace:filelist" : renderFile,
		"myspace:init" : init,
		"myspace:collSuc" : collSuc,
		"myspace:uncollSuc" : uncollSuc
	}

	for(var i in handlers){
		handlerObj.bind(i,handlers[i]);
	}

	//显示分享窗口
	function showShare(id,cls){
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
		switch(cls){
			case 'other':
				$('#shareWin h4').text('共享 发送给别人');
				iframeEl.attr('src','/share/other?id='+id);
				break;
			case 'group':
				$('#shareWin h4').text('共享 到小组空间');
				iframeEl.attr('src','/share/group?id='+id);
				break;
			case 'dep':
				$('#shareWin h4').text('共享 到部门空间');
				iframeEl.attr('src','/share/dep?id='+id);
				break;
		}	
		$("#shareWin").modal('show');
	}

	/*绑定事件*/
	//下载文件
	$(document).on('click','[data-click-downfile]',function(){
		$('#fileList .fclick:checked').each(function(){
			window.open('/cgi/downfile?fid='+files[$(this).val()].fid);
		});	
	});

	//收藏文件
	$(document).on('click','[data-click-coll]',function(){
		collFile();
	});	

	//重命名文件
	$(document).on('click','[data-click-rename]',function(){
		
		var opt = {
			target : $('#fileWin .modal-content'),
			tplid : 'new-file',
			data : {
				type : 0
			},
			handlers : fileHandler
		}
		fileWinView.expand(opt);
		fileWinView.createPanel();		
	});		

	//复制文件
	$(document).on('click','[data-click-copy]',function(){

	});	

	//删除文件
	$(document).on('click','[data-click-del]',function(){

	});	

	//分享文件给他人
	$(document).on('click','[data-click-share-other]',function(){
		showShare('other');
	});

	//分享文件到部门
	$(document).on('click','[data-click-share-group]',function(){
		showShare('group');
	});

	//分享文件到学校
	$(document).on('click','[data-click-share-dep]',function(){
		showShare('dep');
	});

	return;
});