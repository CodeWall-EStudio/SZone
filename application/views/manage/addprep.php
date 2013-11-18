<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="author" content="Tencent" />
  <title>教师工作室</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="/css/main.css" />
 
  <meta property="qc:admins" content="124110632765637457144563757" />
  <script>
  <? $tt = array();?>
  	var pstr = '<?=json_encode($prelist)?>'; 	
  	var gstr = '<?=json_encode($grade)?>';
  </script>
</head>
<body>
	<?php  $this->load->view('public/header.php',$nav); ?>
	<div class="container">
		<div class="main-section">
			<div class="from">
				<h2 class="from-h2">添加备课</h2>
				<?php echo validation_errors(); ?>

				<form action="http://szone.codewalle.com/manage/addprep" method="post" accept-charset="utf-8">
					<table width="100%" class="table table-striped table-hover">
						<?if(count($prelist)>0):?>
							<tr>
								<td width="100">
									<label>学年:</label>
								</td>
								<td>
									<select name="groupid" id="groupid"></select>
									<a data-toggle="modal" data-target="#addWin">增加学年</a>
								</td>
							</tr>
							<tr>
								<td>
									<label>年级名称:</label>
								</td>
								<td>
									<select name="grid" id="grid"></select>
									<a data-toggle="modal" data-target="#addGrade">增加年级</a>
								</td>
							</tr>
							<tr>								
								<td>
									<label>单元:</label>
								</td>
								<td>
									<select name="unid" id="unid"></select>
									<a data-toggle="modal" data-target="#addUnit">增加单元</a>
								</td>
							</tr>
							<tr>
								<td><label>课时名称:</label></td>
								<td><input type="text" name="lessonname" /></td>
							</tr>
						<?else:?>
							<tr>
								<td>
									<label>学期名称:</label>
								</td>
								<td>
									<input type="text" name="groupname" value="<?=set_value('groupname')?>" />
								</td>						
							</tr>
						<?endif?>
						<tr>
							<td colspan="2">
								<input class="btn btn-primary" type="submit" value="提交" />
								<input class="btn btn-default" type="reset" value"取消" />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div class="aside">
			<?php  $this->load->view('manage/manageul.php'); ?>
		</div>
	</div>

	<div id="addWin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">增加学年</h4>
				</div>
				<div class="modal-body">
					<div>
						<label>学年名称:</label>
						<input type="text" class="name" style="width:300px"  />
					</div>
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="button" class="btn btn-primary">确定</button>											
				</div>
			</div>
		</div>
	</div>	

	<div id="addGrade" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">增加年级</h4>
				</div>
				<div class="modal-body">
					<div>
						<label>当前学年:</label><span class="gname"></span>
					</div>
					<div>
						<label>年级名称:</label>
						<input type="text" class="name" style="width:300px"  />
						<input type="hidden" class="gid" />
					</div>
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="button" class="btn btn-primary">确定</button>											
				</div>
			</div>
		</div>
	</div>	

	<div id="addUnit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">增加单元</h4>
				</div>
				<div class="modal-body">
					<div>
						<label>当前学年:</label><span class="gname"></span>
					</div>
					<div>
						<label>当前年级:</label><span class="grname"></span>
					</div>					
					<div>
						<label>单元名称:</label>
						<input type="text" class="name" style="width:300px"  />
						<input type="hidden" class="gid" />
						<input type="hidden" class="grid" />
					</div>
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="button" class="btn btn-primary">确定</button>											
				</div>
			</div>
		</div>
	</div>
	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/prepare.js"></script>
</body>
</html>