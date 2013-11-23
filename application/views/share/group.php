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
	<? $idlist = array(); $flist = array();?>
	<div>
		<div class="share-tit">
			发送文件(<?=count($fl)?>)个：
			<i>
				<?for($i = 0;$i<count($fl);$i++):?>
				<?
					array_push($idlist,$fl[$i]['id']);
					array_push($flist,$fl[$i]['name']);
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
		<div class="share-act-zone">
			<input type="hidden" id="type" value="1" /><input type="hidden" id="gid" value="<?=$gid?>" /><input type="hidden" id="flist" value="<?=implode(',',$idlist)?>" /><input type="hidden" id="fnames" value="<?=implode(',',$flist)?>" />
			<p><input type="text" value="搜索小组" data-type="<?=$type?>" id="search" /><i></i></p>
			<div>
				<button class="btn btn-default" id="joinList">加入名单</button>
				<button class="btn btn-primary" id="post" disabled="disabled">发送</button>
			</div>
		</div>
		<div class="share-target">
			发送目标
			<ul id="selectResult">

			</ul>						
		</div>
		<div class="share-select">
			搜索结果
			<ul id="searchResult">
			</ul>						
		</div>	
		<div class="clear"></div>
	</div>
	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/common.js"></script>
	<script src="/js/share.js" ></script>	
</body>
</html>