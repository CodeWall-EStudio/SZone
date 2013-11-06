<div class="main-section">
		<table width="100%" class="table table-striped table-hover">
			<tr>
				<th width="30"><input type="checkbox"></th>
				<th width="150">用户名</th>
				<th width="150">昵称</th>
				<th width="150">权限</th>
				<th width="150">空间</th>
			</tr>
			<?foreach($ulist as $key => $item):?>
			<tr>
				<td><input type="checkbox" /></td>
				<td><?=$item['name'];?></td>
				<td><?=$item['nick'];?></td>
				<td>
					<?
						$auth = (int) $item['auth'];
						if($auth & 0x8){
							echo '系统管理员';
						}elseif($auth & 0x4){
							echo '管理员';
						}elseif($auth & 0x2){
							echo '部门管理员';
						}elseif($auth & 0x2){
							echo '小组管理员';
						}else{
							echo '教师';
						}
					?>
				</td>
				<td><?=$item['used'];?>/<?=$item['size']?></td>
			</tr>
			<?endforeach?>
		</table>	
</div>