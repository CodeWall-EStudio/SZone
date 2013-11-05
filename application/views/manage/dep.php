<div class="main-section">
	<div class="tool-zone fade-in">
		<button class="btn btn-danger">删除所选</button>
		<!--class="btn btn-default" data-toggle="modal" data-target="#newGroup"-->
		<a href="/manage/addgroup?act=dep">
			<button class="btn btn-default">增加部门</button>
		</a>
	</div>
	<div>
		<table width="100%" class="table table-striped table-hover">
			<tr>
				<th width="30"><input type="checkbox"></th>
				<th width="150">分组名称</th>
				<th width="150">创建者</th>
				<th align="right">全部删除</th>
			</tr>
			<?foreach($data as $key => $item):?>
			<tr>
				<td><input type="checkbox" /></td>
				<td><?=$item['name'];?></td>
				<td><?=$item['uname'];?></td>
				<td align="right"><a href="/manage/editgroup?id=<?=$item['id']?>">修改</a> <a href="/manage/delgroup?id=<?=$item['id']?>">删除</a></td>
			</tr>
			<?endforeach?>
		</table>

	</div>

	<div id="newGroup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">新建小组</h4>
				</div>
				<div class="modal-body">
					<ul>
						<li>
							<label>小组层次:</label>
							<select id="grouplv">
								<option value="0">一级小组</option>
							</select>
						</li>
						<li>
							<label>小组名称:</label>
							<input type="text" style="width:80%" id="groupname" />
						</li>
					</ul>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					<button type="button" class="btn btn-primary btn-addgroup" cmd="newGroup">确定</button>
				</div>
			</div>
		</div>
	</div>
</div>	


