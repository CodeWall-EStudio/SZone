;(function(){

	function pass(id){
		$.post('/cgi/review_pass',{id:id},function(d){
			if(d.ret==0){
				alert('审核通过');
				$("#review"+id).remove();
				$("#reviewStatus"+id).html('审核通过');
			}else{
				alert('操作失败,请稍后再试!');
			}
		});	
	}

	function notpass(id){
		$('#reviewFile').modal('show');
		$('#reviewFile .id').val(id);
	}

	function bind(){

		$('#reviewFileBtn').bind('click',function(e){
			var v = $('#reviewFile .review-text').val();
			var id = $('#reviewFile .id').val();
			$.post('/cgi/review_not_pass',{id:id,tag: v},function(d){
				$('#reviewFile').modal('hide');
				if(d.ret==0){
					alert('操作成功!');
					$("#review"+id).remove();
					$("#reviewStatus"+id).html('审核不通过');
				}else{
					alert('操作失败,请稍后再试!');
				}
			});
		});

		$('#fileList').bind('click',function(e){
			var target = $(e.target),
				cmd = target.attr('cmd'),
				id = target.attr('data-id');
			switch(cmd){
				case 'pass':
					pass(id);
					break;
				case 'notpass':
					notpass(id);
					break;
			}
		});
	}

	function init(){
		bind();
	}

	init();
})();
function hideManage(){
	$('#manageWin').modal('hide');
}
function hideShare(){
	$('#shareWin').modal('hide');
}
function sharealert(msg){
	alert(msg);
}