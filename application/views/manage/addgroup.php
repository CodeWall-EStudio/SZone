<div class="main-section">
	<div class="from">
	<h2 class="from-h2">添加分组</h2>
	<?if($ret):?>
		<div>
			添加分组成功,<a href="/manage/">返回管理页</a>
		</div>
	<?else:?>
		<?php echo validation_errors(); ?>

		<?php echo form_open('manage/addgroup?act='.$act); ?>
		<?
			if($act == 'group'){
				$gname = '小组';
			}else{
				$gname = '部门';
			}
		?>
			<table id="newOther" width="100%" class="table table-striped table-hover addfrom">
				<tr>
					<td width="100">
						<label>小组层次:</label>
						
					</td>
					<td><?=form_dropdown('parent', $group, '0') ?></td>
				</tr>
				<tr>
					<td><?=$gname?>名称:</td>
					<td>
					<input type="text" name="groupname" value="<?=set_value('groupname')?>" />
					<input type="hidden" name="type" value"<?=$act?>" />						
					</td>
				</tr>
				<tr>
					<td>管 理 员:</td>
					<td>
					<input type="text" name="manage" id="manageName" value="<?=set_value('manage')?>" />
					<ul class="dropdown-menu manage-list" id="unameList"  role="menu" aria-labelledby="dLabel">
						
					</ul>					
					<span>管理员之间已","分隔.</span>						
					</td>
				</tr>	
				<?if(count($ulist)>0):?>			
				<tr>
					<td><?=$gname?>成员:</td>
					<td>
						<?foreach($ulist as $row):?>
							<span><input type="checkbox" name="uids[]" value="<?=$row['id']?>" /> <?=$row['name']?></span>
						<?endforeach?>						
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
	<?endif?>
	</div>
</div>