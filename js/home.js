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


	function init(){
		 $('.btn-new-fold').click(function(){
		 	var value = $('#foldname').val();
		 	if(value != ''){
		 		console.log(value);
		 		$.post('/cgi/addfold',{name: value},function(d){
		 			console.log(typeof d,d,d[0]);
		 		});
		 	}
		 });
	}

	init();
})();