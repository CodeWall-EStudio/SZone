<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="author" content="Tencent" />
  <title>教师工作室</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="/css/scroll.css" />
  <link rel="stylesheet" type="text/css" href="/css/share.css" />

</head>
<body class="share-zone">
	<i class="glyphicon glyphicon-chevron-down"></i>
	<? $idlist = array();?>
	<div>
		<div class="share-tit">
			复制文件(<?=count($fl)?>)个到我的备课：
			<i>
				<?for($i = 0;$i<count($fl);$i++):?>
				<?
					array_push($idlist,$fl[$i]['id']);
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
			<p>选择目标路径：</p>
			<div>
				<button class="btn btn-primary" id="post" disabled="disabled">复制</button>
				<input type="hidden" id="flist" value="<?=implode(',',$idlist)?>" />
			</div>
		</div>
		<div class="move-target">
			我的备课
			<ul id="prepList" class="perplist">
				<?if(isset($plist)):?>
				<?foreach($plist as $k => $row):?>
					<li>
						<?=$row['name']?>
						<?if(isset($row['list'])):?>
							<ul>
							<?foreach($row['list'] as $r):?>
								<li>
									<?if(isset($r['name'])):?>
										<a class="a-click" data-id="<?=$r['id']?>"><?=$r['name']?></a>
									<?endif?>
								</li>
							<?endforeach?>
							</ul>
						<?endif?>
					</li>
				<?endforeach?>
				<?endif?>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script>
		var pstr = '<?=json_encode($plist)?>';
		var plist = $.parseJSON(pstr);
	</script>
	<script src="/js/moveprep.js" ></script>	
</body>
</html>