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
	<??>
	<? $idlist = array();?>
	<div>
		<div class="share-tit">
			发送文件(<?=count($fl)?>)个：
			<i>
				<?for($i = 0;$i<count($fl);$i++):?>
				<?
					array_push($idlist,$fl[$i]['fid']);
				?>
					<?if($i<8):?>
						<?=$fl[$i]['name']?>
					<?endif?>
					<?if($i < count($fl)-1):?>
					<?endif?>
				<?endfor?>
				<?if(count($fl)>1):?>
					等
				<?endif?>
			</i>
		</div>
		<div class="share-msg">附言：<p> <input type="text" id="content" /><input type="hidden" id="type" value="0" /><input type="hidden" id="gid" value="<?=$gid?>" /><input type="hidden" id="flist" value="<?=implode(',',$idlist)?>" /></p></div>
		<div class="share-act-zone">
			<p><input type="text" value="搜索用户" data-type="<?=$type?>" id="search" /><i></i></p>
			<div>
				<button class="btn btn-default" id="joinList">加入名单</button>
				<button class="btn btn-primary" id="post" disabled="disabled">发送</button>
			</div>
		</div>
		<div class="share-target">
			用户列表
			<ul id="searchResult">
				<?foreach($ul as $row):?>
					<li><a data-id="<?=$row['id']?>"><?=htmlspecialchars($row['name'])?></a></li>
				<?endforeach?>
			</ul>						
		</div>
		<div class="share-select">
			发送列表
			<ul id="selectResult">
			</ul>						
		</div>	
		<div class="clear"></div>
	</div>
	<script>
		var map = {};
		<?foreach($ul as $row):?>
			map[<?=$row['id']?>] = {
				'id' : <?=$row['id']?>,
				'name' : '<?=$row['name']?>'
			}
		<?endforeach?>
	</script>
	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/common.js"></script>
	<script src="/js/share.js" ></script>	
</body>
</html>