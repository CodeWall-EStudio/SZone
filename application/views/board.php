<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="author" content="Tencent" />
  <title>教师工作室</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="/css/main.css" />
  <link rel="stylesheet" type="text/css" href="/css/board.css" />

</head>
<body class="share-zone">
	<?if($inGroup):?>
	<div>
		<div>
			<p> <input type="text" id="content" class="board-input" /> <button class="btn btn-primary" id="post">发留言</button></p>
		</div>
		<div class="share-act-zone">
			<p id="searchArea"><input type="text" value="搜索留言" data-type="" id="search" /><i></i></p>
			<div>
				全部用户
			</div>
		</div>
		<div class="board-list">
			<ul>
				<?if(count($blist)>0):?>
					<?foreach($blist as $row):?>
					<li>
						<div><?=date('Y-m-d',$row['time'])?>  <?=$row['name']?></div>
						<p><?=$row['content']?></p>
					</li>
					<?endforeach?>
				<?else:?>
					<li>还没有留言哦</li>
				<?endif?>
			</ul>
		</div>
		<div class="clear"></div>
	</div>		
	<script src="/js/lib/jq.js"></script>
	<script src="/js/common.js" ></script>
	<script>
	var ginfo = '<?=json_encode($ginfo);?>';
		ginfo = $.parseJSON(ginfo);
	</script>
	<script src="/js/board.js" ></script>	
	<?else:?>	
		<div style="width:200px;margin:30px auto;">你还不是这个小组或部门的成员!</div>
	<?endif?>
</body>
</html>