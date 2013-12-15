;(function(){
	var prepEl = $('#prepName'),
		gradeEl = $('#gradeList'),
		typeEl = $('#typeList'),
		uEl = $('#uList');


	function goto(){
		var prid = prepEl.val();
		var gn = gradeEl.val();
		var type = typeEl.val();
		var uid = uEl.val() || 0;
		var url = '/group/prep?prid='+prid+'&gr='+gn+'&tag='+type+'&ud='+uid;
		window.location = url;
		//console.log(url);
	}

	prepEl.bind('change',function(){
		goto();

	});
	gradeEl.bind('change',function(){
		goto();
	});
	typeEl.bind('change',function(){
		goto();
	});
	uEl.bind('change',function(){
		goto();
	});

	$('#searchKey').on("focus blur",function(e){
		var dom = $(this),
			v = dom.val(),
			def = dom.attr('data-def');
			if(v == def || v == ''){
				if(e.type == 'focus'){
					dom.val('');
				}else{
					dom.val(def);
				}
			}else{
				//dom.val(def);
			}
	});

	$('.mark').on('click',function(e){
		var t = $(e.target),
			id = t.attr('data-id');
		$('#btn'+id).hide();
		$('#mark'+id).show();
	});

	$('.save').on('click',function(e){
		var t = $(e.target),
			id = t.attr('data-id'),
			v = $.trim($('#input'+id).val());

		if(v != ''){
			$.post('/cgi/mark_file',{fid : id,mark: v},function(d){
				$('#input'+id).val('');
				if(d.code == 0){	
					$('#btn'+id+' span').html(v);
				}else{
					alert(d.data.msg);
				}
				$('#btn'+id).show();
				$('#mark'+id).hide();				
			});

		}else{
			alert('你还没有评论');
		}

	});

	$('.esc').on('click',function(e){
		var t = $(e.target),
			id = t.attr('data-id');
		$('#btn'+id).show();
		$('#mark'+id).hide();
	});



})();