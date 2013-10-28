<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<link rel="stylesheet" type="text/css" href="/css/main.css" />
</head>
<body>
	<?php  $this->load->view('public/header.php'); ?>	
	<div class="container">

		<div class="main-section">
			user:setting
		</div>

		<div class="aside">
			<h3>个人文件</h3>
			<ul>
				<li>
					共享
					<p>我提供的共享</p>
					<p>提供给我的共享</p>
				</li>
				<li>
					收藏
				</li>
				<li>
					贡献
					<p>工作小组</p>
					<p>学校空间</p>
				</li>
				<li>
					收发
					<p>收件箱</p>
					<p>已发送的邮件</p>
				</li>
			</ul>
		</div>

		<div class="clear"></div>		
	</div>
	<div class="footer"></div>
	<script src="js/lib/jq.js"></script>
	<script src="js/common.js"></script>
	<script src="js/tips.js"></script>
	<script src="js/main.js"></script>
	<div id="alertTips" class="alert-tips"></div>
	<!--
	<div id="progTips" class="prog-tips">
		<div class="progress">
			<div class="progress-bar" style="width:40%;"></div>
			<span>20%</span>
		</div>
		<div class="prog-txt">正在上传</div>
	</div>
	-->
	<div id="normalTips" class="normal-tips"></div>


<?php  $this->load->view('public/footer.php'); ?>		