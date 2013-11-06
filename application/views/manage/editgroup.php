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
		<div>

			<?
				if($type == 1){
					$titname = '小组';
				}else if($type == 2){
					$titname = '部门';
				}
			?>
			<div class="main-section">
				<div class="from">
				<h2 class="from-h2"><?=$titname?>修改</h2>
					<?php echo validation_errors(); ?>

					<?php echo form_open('manage/editgroup?id='.$gid); ?>
						<ul class="addfrom">
							<li>
								<label>小组层次:</label>
								<?=form_dropdown('parent', $group, '0') ?>
							</li>
							<li>
								<label><?=$titname?>名称:</label>
								<input type="text" name="groupname" value="<?=$gname?>" />
								<input type="hidden" name="gid" value"<?=$gid?>" />
							</li>
							<li>
								<label>管 理 员:</label>
								<input type="text" name="manage" id="manageName" value="<?=$manage?>" />
								<ul class="dropdown-menu manage-list" id="unameList"  role="menu" aria-labelledby="dLabel">
									
								</ul>					
								<span>管理员之间已","分隔.</span>

							</li>				
							<li>
								<input class="btn btn-primary" type="submit" value="提交" />
								<input class="btn btn-default" type="reset" value"取消" />
							</li>
						</ul>			
					</form>

				</div>
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
