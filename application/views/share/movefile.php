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
			复制文件(<?=count($fl)?>)个到文件夹：
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
				<button class="btn btn-primary" id="post" disabled="disabled">移动</button>
				<input type="hidden" id="flist" value="<?=implode(',',$idlist)?>" />
				<input type="hidden" id="gid" value="<?=$gid?>" />
			</div>
		</div>
		<div class="move-target">
			我的文件夹
			<ul id="prepList" class="perplist">
				<?if(count($flist)>0):?>
				<?foreach($flist as $row):?>
					<li>
						<i class="glyphicon <?if(isset($row['child'])):?>glyphicon-plus<?endif?>" data-fid="<?=$row['id']?>"></i><a class="a-click" data-id="<?=$row['id']?>">
							<?=$row['name']?>
						</a>
					</li>
				<?endforeach?>
				<?else:?>
					<li>您还没有创建文件夹</li>
				<?endif?>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	<script type="text/template" id="fold-list-tmp">
		<ul>
			<%
				for(var i in list){
					var item = list[i];
			%>
			<li>
				<i class="glyphicon <%if(item.child){%>glyphicon-plus<%}%>" data-fid="<%=item.id%>"></i><a  class="a-click" data-id="<%=item['id']%>"> <%=item.name%></a>	
			</li>
			<%}%>
		</ul>
	</script>	
	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/lib/jQuery.tmp.js"></script>
	<script src="/js/copyfile.js" ></script>	
</body>
</html>