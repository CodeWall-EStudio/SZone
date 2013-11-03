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
			<ul class="addfrom">
				<li>
					<label>小组层次:</label>
					<?=form_dropdown('parent', $group, '0') ?>
				</li>
				<li>
					<label>小组名称:</label>
					<input type="text" name="groupname" value="<?=set_value('groupname')?>" />
					<input type="hidden" name="type" value"<?=$act?>" />
				</li>
				<li>
					<label>管 理 员:</label>
					<input type="text" name="manage" id="manageName" value="<?=set_value('manage')?>" />
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
	<?endif?>
	</div>
</div>