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
		<div class="main-section">
			<div class="from">
				<h2 class="from-h2">添加备课</h2>
				<?php echo validation_errors(); ?>

				<?php echo form_open('manage/addprep?act='.$act); ?>
					<ul class="addfrom">
						<li></li>
					</ul>
				</form>
			</div>
		</div>
		<div class="aside">
			<?php  $this->load->view('manage/manageul.php'); ?>
		</div>
	</div>
	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/manage.js"></script>
</body>
</html>