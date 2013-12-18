<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="author" content="Tencent" />
  <title>教师工作室</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="/css/main.css" />

</head>
<body class="share-zone">
	<? $idlist = array();?>
	<table class="table" width="90%" align="cneter">
		<tr>
			<td width="100">小组名称:</td>
			<td>
				<input type="text" id="gName" value="<?=$ginfo->name?>" style="width:400px;" />
				<input type="hidden" value="<?=$ginfo->id?>" id="gid" />
				<a id="saveName">保存小组名</a>
				<div class="right"><button class="btn btn-primary" id="post">保存</button></div>
			</td>
		</tr>
		<tr>
			<td width="100">小组简介:</td>
			<td>
				<textarea id="gDesc" style="width:400px;height:120px;"><?=$ginfo->content?></textarea>
				<a id="saveDesc">保存简介</a>
			</td>
		</tr>	
		<tr>
			<td width="100">成员管理:</td>
			<td>
				<div class="share-act-zone">
					<p><input type="text" value="搜索用户" id="search" /><i></i></p>
				</div>
				<button class="btn btn-default right" id="joinList">加入名单</button></td>
		</tr>
		<tr>
			<td colspan="2">
				<div class="share-target">
					用户列表
					<ul id="searchResult">
						<?foreach($ul as $row):?>
							<li <?if(isset($ulist[$row['id']])):?>style="display:none"<?endif?>><a data-id="<?=$row['id']?>" <?if(isset($ulist[$row['id']])):?>data-group="1"<?endif?>><?=$row['name']?></a></li>
						<?endforeach?>
					</ul>						
				</div>
				<div class="share-select">
					小组成员
					<ul id="selectResult">
						<?foreach($ulist as $row):?>
							<li><a <?if($row['auth']==0):?>data-id="<?=$row['uid']?>"<?endif?>><?=$row['name']?></a></li>
						<?endforeach?>
					</ul>					
				</div>	

			</td>
		</tr>
	</tabel>
	<script>
		var map = {};
		var omap = {};
		<?foreach($ul as $row):?>
			map[<?=$row['id']?>] = {
				'id' : <?=$row['id']?>,
				'name' : '<?=$row['name']?>'
			}
		<?endforeach?>
		<?foreach($ulist as $row):?>
			<?if($row['auth']==0):?>
			map[<?=$row['uid']?>] = {
				'id' : <?=$row['uid']?>,
				'name' : '<?=$row['name']?>'
			}		
			<?endif?>
			omap[<?=$row['uid']?>] = {
				'id' : <?=$row['uid']?>,
				'name' : '<?=$row['name']?>'
			}
		<?endforeach?>		
	</script>	
	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/common.js" ></script>	
	<script src="/js/gmanage.js" ></script>	
</body>
</html>