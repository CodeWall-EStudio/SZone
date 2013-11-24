;(function(){

	$('#header').bind('click',function(e){
		var target = $(e.target),
			cmd = target.attr('cmd');
		switch(cmd){
			case 'manage':
				var gid = target.attr('data-id');
				$("#manageIframe").attr('src','/group/manage?id='+gid);
				break;
			case 'newgroup':
				$("#manageIframe").attr('src','/group/newgroup');
				break;
		}
	})

})()