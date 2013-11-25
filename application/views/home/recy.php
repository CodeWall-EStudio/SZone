<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="author" content="Tencent" />
  <title>教师工作室</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="/css/mailbox.css" />

</head>
<body class="share-zone">
	<div class="collection-tit">
		<div class="search-zone">
			<form action="/home/recy" method="post">
			<input type="text" value="搜索文件" name="key" />
			<button type="button"></button>
			</form>
		</div>
		<div class="collection-act">
			<div>
			</div>
			<div>
				<a role="button" data-toggle="dropdown" href="#">
					<?
						switch($type){
							case 0:
								echo '全部类型';
								break;
							case 1:
								echo '图片';
								break;
							case 2:
								echo '文档';
								break;
							case 3:
								echo '音乐';
								break;
							case 4:
								echo '视频';
								break;
							case 5:
								echo '应用';
								break;
							case 6:
								echo '压缩包';
								break;
						}
					?>
				<b class="caret"></b></a>
				<ul class="dropdown-menu section-tit-menu1" role="menu" aria-labelledby="dLabel">
					<li><a data-type="0" href="/home/coll?type=0">全部</a></li>
					<li><a data-type="2">收藏</a></li>
					<li><a data-type="3" href="/home/coll?type=4">视频</a></li>
					<li><a data-type="1" href="/home/coll?type=1">图片</a></li>
					<li><a data-type="4" href="/home/coll?type=3">音乐</a></li>
					<li><a data-type="5" href="/home/coll?type=2">文档</a></li>
					<li><a data-type="6" href="/home/coll?type=5">应用</a></li>
					<li><a data-type="7" href="/home/coll?type=6">压缩包</a></li>
				</ul>
			</div>
		</div>
	</div>
	<ul class="dis-list-type">
		<?if(count($dlist)>0):?>
		<li class="tit">
			<!-- <div class="td1"><input type="checkbox" /></div> -->
			<div class="td2">文件名</div>
			<div class="td3">来源</div>
			<div class="td5">大小</div>
			<div class="td6">时间</div>
		</li>
		<?foreach($dlist as $row):?>
		<li>
			<!-- <div class="td1"><input type="checkbox" /></div> -->
			<div class="td2">
				<?if($row['type'] == 1):?>
					<img src="/cgi/getfile?fid=<?=$row['fid']?>" />
				<?else:?>
					<i class="file<?=$row['type']?>"></i>
				<?endif?>
				<dl>
					<dt><?=$row['name']?></dt>
					<dd>
						<a cmd="ref" data-id="<?=$row['id']?>" data-fid="<?=$row['fid']?>">恢复</a>
						<a cmd="del" data-id="<?=$row['id']?>" data-fid="<?=$row['fid']?>">完全删除</a>
					</dd>
				</dl>
			</div>
			<div class="td3"></div>
			<div class="td5"><?=$row['size']?></div>
			<div class="td6"><span><?=$row['time']?></span> <i></i></div>
		</li>		
		<?endforeach?>
		<?else:?>
			<li class="empty">目前还没有相关的文件</li>
		<?endif?>
	</ul>	
	<div class="page-zone">
		<?
			$page['url'] = '/recy?type='.$type.'&key='.$key;
			create_page($page);
		?>
	</div>	

	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script>
		var reUrl = '/cgi/refrcey',
			delUrl = '/cgi/compdel';

		$('.dis-list-type').bind('click',function(e){
			var target = $(e.target),
				cmd = target.attr('cmd'),
				id = target.attr('data-id'),
				fid = target.attr('data-fid');
			switch(cmd){
				case 'ref':
					$.post(reUrl,{id:id},function(d){
						alert(d.msg);
						if(d.ret == 0){
							window.location.reload();
						}
					});
					break;
				case 'del':
					$.post(delUrl,{id:id,fid : fid},function(d){
						alert(d.msg);
						if(d.ret == 0){
							window.location.reload();
						}
					});				
					break;
			}
		});

	</script>	
</body>
</html>