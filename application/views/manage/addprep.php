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

				
					<?if(count($plist)>0):?>
					<form action="/manage/addprep" method="post" accept-charset="utf-8">
						<table id="newOther" width="100%" class="table table-striped table-hover">
							<tr>
								<td width="100">
									<label>学年:</label>
								</td>
								<td>
									<select name="groupid" id="groupid">
										<?foreach($plist as $row):?>
											<option value="<?=$row['id']?>"><?=$row['name']?></option>
										<?endforeach?>
									</select>
									<a id="addgroup">增加学年</a>
								</td>
							</tr>
							<tr>
								<td>年级</td>
								<td>
									<select name="grade">
										<option value="1">一年级</option>
										<option value="2">二年级</option>
										<option value="3">三年级</option>
										<option value="4">四年级</option>
										<option value="5">五年级</option>
										<option value="6">六年级</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>学科</td>
								<td>
									<select name="type">
										<option value="1">语文</option>
										<option value="2">数学</option>
										<option value="3">英语</option>
										<option value="4">体育</option>
										<option value="5">音乐</option>
										<option value="6">自然</option>
									</select>								

								</td>
							</tr>						
							
							<tr>
								<td colspan="2">
									<input class="btn btn-primary" type="submit" value="提交" />
									<input class="btn btn-default" type="reset" value"取消" />
								</td>
							</tr>
						</table>
					</form>
					<?endif?>
					<form action="/manage/addprep?act=1" method="post" accept-charset="utf-8">
					<table id="newGroup" width="100%" class="table table-striped table-hover <?if(count($plist)>0):?>hide<?endif?>">
						<tr>
							<td width="100">
								<label>学年:</label>
							</td>
							<td>
								<input type="text" name="group" />
								<?if(count($plist)>0):?>
								<a id="addOther">增加年级科目</a>
								<?endif?>
							</td>
						</tr>		
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

	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/prepare.js"></script>
</body>
</html>