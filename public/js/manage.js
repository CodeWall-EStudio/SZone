;(function(){

	var mt = 0;
	var vl = [];
	$('#manageName').bind('keyup',function(e){

		var value = $(this).val();
		vl = value.split(';');
		value = vl[vl.length-1];
		if(mt){
			clearTimeout(mt);
			mt = 0;
		}
		if(value == ''){
			//console.log(123);
			return;
		}
		mt = setTimeout(function(){
			var url = '/query/smartuser?key='+value;
			$.get(url,function(d){
				if(d.code == 0){
					var list = d.data.list;
					var html = [];
					for(var i = 0,l=list.length;i<l;i++){
						var item = list[i];
						html.push('<li><a data-id="'+item.id+'">'+item.name+'</a></li>');
					}
					if(list.length>0){
						$('#unameList').html(html.join(""));
						$('#unameList').show();
					}
				}
			});
		},40);
	});

	$("#manageList span").bind('click',function(e){
		if(e.target.nodeName != 'INPUT'){
			if($(e.target).find('input')[0].checked){
				$(e.target).find('input')[0].checked = false;
			}else{
				$(e.target).find('input')[0].checked = true;
			}
		}
	});

	$("#userList span").bind('click',function(e){
		if(e.target.nodeName != 'INPUT'){
			if($(e.target).find('input')[0].checked){
				$(e.target).find('input')[0].checked = false;
			}else{
				$(e.target).find('input')[0].checked = true;
			}
		}
	});	

	$("#searchManage").bind('keyup',function(e){
		//if(e.keyCode == 13){
			var v = $.trim($(this).val());
			if(v == ''){
				return;
			}
			$("#manageList span").removeClass("color");
			for(var i in ul){
				if(i.indexOf(v) >=0 ){
					$('#mid'+ul[i]).addClass('color');
				}
			}
		//}
	}).bind('blur',function(e){
			var v = $.trim($(this).val());
			if(v == ''){
				$("#manageList span").removeClass("color");
			}		
	});

	$("#searchUser").bind('keyup',function(e){
			var v = $.trim($(this).val());
			if(v == ''){
				return;
			}
			$("#userList span").removeClass("color");
			for(var i in ul){
				if(i.indexOf(v) >=0 ){
					$('#id'+ul[i]).addClass('color');
				}
			}
	}).bind('blur',function(e){
			var v = $.trim($(this).val());
			if(v == ''){
				$("#userList span").removeClass("color");
			}		
	});

	$('#unameList').bind('click',function(e){

		if(e.target.nodeName == 'A'){
			vl.pop();
			vl.push($(e.target).text()+';');
			$('#manageName').val(vl.join(';'));
		}

	});

})();