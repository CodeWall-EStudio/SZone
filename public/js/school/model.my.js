define(['config','util','request'],function(config,util,request){
	var handerObj = $(schoolObj);

	var nowType = 1;//默认是个人空间

	//拉文件列表
	function getFile(){
		var opt = {
			cgi : config.filelist,
			data : {}
		};
		var suc = function(d){
			console.log(d);
			if(d.code == 0){
				handerObj.triggerHandler("myspace:filelist",d.data);
			}
		}
		request(opt,suc);		
	}

	//拉文件夹列表
	function getFold(){
		var opt = {
			cgi : config.foldlist,
			data : {}
		}
		var suc = function(d){
			if(ret.code == 0){

			}
		}
		request(opt,suc);
	}

	function init(d){
		getFile();
		getFold();
	}

	function delFile(e,d){

	}

	function renameFile(e,d){

	}

	//收藏文件
	function collFile(e,d){
		console.log(d);
		var opt = {
			cgi : config.coll,
			method : 'POST'
		}
		var suc = function(ret){
			if(ret.code == 0){
				handerObj.triggerHandler("myspace:collSuc",d);	
			}
		}
		request(opt,suc);
	}
	//取消收藏
	function uncollFile(e,d){
		var opt = {
			cgi : config.uncoll,
			method : 'POST',
			data : d
		}
		var suc = function(ret){
			if(ret.code == 0){
				handerObj.triggerHandler("myspace:uncollSuc",d);	
			}
		}
		request(opt,suc);
	}	
	//分享文件
	function shareFile(e,d){

	}
	//搜索用户
	function getUser(e,d){

	}	

	var handlers = {
		"myspace:init" : init,
		"myspace:renameFile" : renameFile,
		"myspace:collFile" : collFile,
		"myspace:uncollFile" : uncollFile,
		"myspace:delFile" : delFile,
		"myspace:shareFile" : shareFile,
		"myspace:getuser" : getUser
	}


	for(var i in handlers){
		handerObj.bind(i,handlers[i]);
		//homeHanderObj.bind(i,handlers[i]);
	}	

	return handerObj;

});