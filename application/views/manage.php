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
	<?php  $this->load->view('public/header.php',$nav); ?>
	<div class="container">
		<div>
			<?if($index=='index'):?>
				<?php  $this->load->view('manage/index.php',$data); ?>
			<?elseif($index=='group'):?>
				<?php  $this->load->view('manage/group.php',$data); ?>
			<?elseif($index=='dep'):?>
				<?php  $this->load->view('manage/dep.php',$data); ?>
			<?elseif($index=='space'):?>
				<?php  $this->load->view('manage/space.php',$data); ?>
			<?elseif($index=='addgroup'):?>
				<?php  $this->load->view('manage/addgroup.php',$data); ?>	
			<?elseif($index=='editgroup'):?>
				<?php  $this->load->view('manage/editgroup.php',$data); ?>								
			<?elseif($index=='ret'):?>
				<?php  $this->load->view('manage/retmsg.php',$data); ?>				
			<?endif;?>
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