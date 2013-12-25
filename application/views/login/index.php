<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="author" content="Tencent" />
  <title>教师工作室</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="/css/main.css" />
  <style>
  	#loginForm{
  		margin:40px auto;
  		width:400px;
  		border:1px solid #ddd;
  		border-radius:6px;
  		padding:20px;
  		background:#fff;
  		box-shadow: 5px 5px 5px #ddd;
  	}
  	#loginForm li{
  		padding:15px 10px;
  	}
  	#loginForm .btns{
  		padding-left:70px;
  	}
  	#loginForm input{
  		width:240px;
  		display:inline-block;
  	}
  </style>
  <meta property="qc:admins" content="124110632765637457144563757" />
</head>
<body>
	<div id="header" class="header">
		<i class="logo"></i>
	</div>

	<div>
		<form action="/login/act" method="post">
		<ul id="loginForm">
			<li>
				<label>用户名：</label>
				<input type="text" class="name form-control" def-value="请输入用户名" value="请输入用户名" />
			</li>
			<li>
				<label>密　码：</label>
				<input type="password" class="pwd form-control" />
			</li>
			<li class="btns">
				<submit id="submit" class="btn btn-primary">登录</submit>
				<reset class="btn btn-default">取消</reset>
			</li>
		</ul>
		</form>
	</div>
	<script src="/js/lib/jq.js"></script>
	<script>
	$('#loginForm input').bind('focus',function(e){
		var t = $(e.target),
			def = t.attr('def-value'),
			v = t.val();
		if(v == def){
			t.val('');
		}
		t.parent().removeClass("has-error");

	}).bind('blur',function(e){
		var t = $(e.target),
			def = t.attr('def-value'),
			v = t.val();
		if(v == '' || v == def){
			t.parent().addClass("has-error");;
		}
		if(def){
			if(v == ''){
				t.val(def);
			}
		}
	});

	$("#submit").click(function(){
		var n = $('.name').val();
		var dn = $('.name').attr('def-value');
		var p = $('.pwd').val();
		if(n == '' || n == dn){
			$('.name').parent().addClass("has-error");
		}
		if(p == ''){
			$('.pwd').parent().addClass('has-error');
		}
	});
	</script>
</body>
</html>