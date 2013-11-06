<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="author" content="Tencent" />
  <title>教师工作室</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="/css/main.css" />
 
  <meta property="qc:admins" content="124110632765637457144563757" />
</head>
<body>
	<?php  $this->load->view('public/header.php',$userinfo); ?>
	<div class="container">

		<div class="main-section">
			
			<div <?if($ret==0):?>class="success"<?else:?>class="fail"<?endif?>>
				<?=$msg?> <a href="/manage">返回管理首页</a>
			</div>

		</div>
		<div class="aside">
			<ul>
				<li><a href="/manage/">用户管理</a></li>
				<li><a href="/manage/group/">小组管理</a></li>
				<li><a href="/manage/dep/">部门管理</a></li>
				<li><a href="/manage/space/">空间设置</a></li>
			</ul>
		</div>
	</div>

	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/manage.js"></script>
</body>
</html>	