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
		<div>
			<?
				if($type == 1){
					$titname = '小组';
				}else if($type == 2){
					$titname = '部门';
				}else if($type ==3){
					$titname = '备课';
				}
			?>
			<div class="main-section">
				<div class="from">
				<h2 class="from-h2"><?=$titname?>修改</h2>
					<?php echo validation_errors(); ?>

					<?php echo form_open('manage/editgroup?id='.$gid); ?>
						<table id="newOther" width="100%" class="table table-striped table-hover addfrom">
<!-- 							<tr>
								<td width="100">
									<label>小组层次:</label>
									
								</td>
								<td><?=form_dropdown('parent', $group, '0') ?></td>
							</tr> -->
							<tr>
								<td><?=$gname?>名称:</td>
								<td>
								<input type="text" name="groupname" value="<?=$gname?>" />
								<input type="hidden" name="gid" value"<?=$gid?>" />					
								</td>
							</tr>
							<tr>
								<td>管 理 员:</td>
								<td>
									<input type="text" id="searchManage" /> 输入用户名称高亮
									<div id="manageList" class="user-list">
									<?foreach($ulist as $row):?>
										<span id="mid<?=$row['id']?>"><input type="checkbox" name="muids[]" value="<?=$row['id']?>" <?if(isset($row['auth'])):?>checked<?endif?> /> <?=htmlspecialchars($row['name'])?></span>
									<?endforeach?>	
									</div>									
<!-- 								<input type="text" name="manage" id="manageName" value="<?=$manage?>" /> -->
<!-- 								<ul class="dropdown-menu manage-list" id="unameList"  role="menu" aria-labelledby="dLabel">
									
								</ul>					 -->
								<!-- <span>管理员之间已","分隔.</span>	 -->					
								</td>
							</tr>	
							<?if(count($ulist)>0):?>			
							<tr>
								<td><?=$gname?>成员:</td>
								<td>
									<input type="text" id="searchUser" /> 输入用户名称高亮
									<div id="userList" class="user-list">
									<?foreach($ulist as $row):?>
										<span id="id<?=$row['id']?>"><input type="checkbox" name="uids[]" value="<?=$row['id']?>" <?if(isset($row['in'])):?>checked<?endif?> /> <?=htmlspecialchars($row['name'])?></span>
									<?endforeach?>						
									<div>
								</td>
							</tr>	
							<?endif?>		
							<tr>
								<td colspan="2" align="center">
								<input class="btn btn-primary" type="submit" value="提交" />
								<input class="btn btn-default" type="reset" value"取消" />						
								</td>
							</tr>					
						</table>	
					</form>

				</div>
			</div>
		</div>
		<div class="aside">
			<?php  $this->load->view('manage/manageul.php'); ?>
		</div>
	</div>
<script>
	var ul = {};
	<?foreach($ulist as $row):?>
		ul['<?=$row['name']?>'] = <?=$row['id']?>;
	<?endforeach?>
</script>
	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/manage.js"></script>
</body>
</html>
