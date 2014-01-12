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
	<?php  $this->load->view('public/header_manage.php',$nav); ?>
	<div class="container">
		<div class="main-section">
			<div class="tool-zone fade-in">
				<button class="btn btn-danger">删除所选</button>
				<!--class="btn btn-default" data-toggle="modal" data-target="#newGroup"-->
				<a href="/manage/addprep?act=group">
					<button class="btn btn-default">增加备课目录</button>
				</a>
			</div>
			<?if(count($ulist) > 0):?>
			<table width="100%" class="table table-striped table-hover">
				<tr>
					<th width="30"><input type="checkbox"></th>
					<th >分组名称</th>
					<th width="150"></th>
					<th align="right"></th>
				</tr>			
				<?foreach($ulist as $key => $item):?>
				<tr>
					<td><input type="checkbox" /></td>
					<td><?=$item['name'];?></td>
					<td></td>
					<td align="right"><a href="/manage/editgroup?id=<?=$item['id']?>">修改</a> <a href="/manage/delprep?id=<?=$item['id']?>">删除</a></td>
				</tr>
				<?endforeach?>			
			</table>
			<?else:?>
				<div class="manage-empty">还未添加备课分组</div>
			<?endif?>
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