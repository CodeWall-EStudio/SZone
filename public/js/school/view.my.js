define(['util','view','model.my'],function($u,View,my){
	var handerObj = $(schoolObj);

	var fileView = new View({}),
		fileTarget = $('#fileList');

	var fileHandler = {};

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

	var handlers = {
		"myspace:filelist" : renderFile
	}

	for(var i in handlers){
		handerObj.bind(i,handlers[i]);
	}

	return;
});