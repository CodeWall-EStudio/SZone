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

	function del(){

	}

	function rename(){

	}

	var handlers = {
		"myspace:init" : init,
		"myspace:del" : del,
		"myspace:rename" : rename
	}


	for(var i in handlers){
		handerObj.bind(i,handlers[i]);
		//homeHanderObj.bind(i,handlers[i]);
	}	

	return handerObj;

});