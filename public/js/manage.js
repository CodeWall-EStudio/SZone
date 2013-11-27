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
				if(d.ret == 0){
					var list = d.list;
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

	$('#unameList').bind('click',function(e){

		if(e.target.nodeName == 'A'){
			vl.pop();
			vl.push($(e.target).text()+';');
			$('#manageName').val(vl.join(';'));
		}

	});

})();