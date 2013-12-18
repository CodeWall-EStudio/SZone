<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="author" content="Tencent" />
  <title>教师工作室</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="/css/mailbox.css" />
  <link rel="stylesheet" type="text/css" href="/css/type.css" />
  <style>
  	dl{
  		margin:0;
  	}
  </style>
</head>
<body class="share-zone">
	<div class="collection-tit">
		<div class="search-zone">
			<form action="/home/recy" method="post">
			<input type="text" value="搜索文件" name="key" data-def="搜索文件" id="searchKey"  />
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
					<li><a data-type="0" href="/home/recy?type=0">全部</a></li>
					<li><a data-type="3" href="/home/recy?type=4">视频</a></li>
					<li><a data-type="1" href="/home/recy?type=1">图片</a></li>
					<li><a data-type="4" href="/home/recy?type=3">音乐</a></li>
					<li><a data-type="5" href="/home/recy?type=2">文档</a></li>
					<li><a data-type="6" href="/home/recy?type=5">应用</a></li>
					<li><a data-type="7" href="/home/recy?type=6">压缩包</a></li>
				</ul>
			</div>
		</div>
	</div>
		<?if($key!=''):?>
		<div class="search-key">
			当前搜索关键字:　<span><?=$key?></span>  <a href="/home/recy">退出搜索</>
		</div>
		<?endif?>	
	<table width="100%" class="table table-striped table-hover">
		<?if(count($dlist)>0):?>
		<tr>
			<!-- <div class="td1"><input type="checkbox" /></div> -->
			<th>文件名</th>
			<th width="80">来源</th>
			<th width="80">大小</th>
			<th width="120">时间</th>
		</tr>	
		<?foreach($dlist as $row):?>
		<tr>
			<!-- <div class="td1"><input type="checkbox" /></div> -->
			<td>
				<?if($row['type'] < 7):?>
					<i class="icon-type<?=(int) $row['type']?>" data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>" ></i>
				<?else:?>
					<i class="icon-type" data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>" ></i>
				<?endif?>	
				<dl>
					<dt><?=$row['name']?></dt>
					<dd>
						<a cmd="ref" data-id="<?=$row['id']?>" data-fid="<?=$row['fid']?>">恢复</a>
						<a cmd="del" data-id="<?=$row['id']?>" data-fid="<?=$row['fid']?>">完全删除</a>
					</dd>
				</dl>
			</td>
			<td></td>
			<td><?=$row['size']?></td>
			<td><span><?=$row['time']?></span> </td>
		</tr>		
		<?endforeach?>
		<?else:?>
			<tr>
				<td colspan="4">目前还没有相关的文件</td>
			</tr>		
		<?endif?>		
	</table>	
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
	$('#searchKey').on("focus blur",function(e){
		var dom = $(this),
			v = dom.val(),
			def = dom.attr('data-def');
			if(v == def || v == ''){
				if(e.type == 'focus'){
					dom.val('');
				}else{
					dom.val(def);
				}
			}else{
				//dom.val(def);
			}
	});

		var reUrl = '/cgi/refrcey',
			delUrl = '/cgi/compdel';

		$('table').bind('click',function(e){
			var target = $(e.target),
				cmd = target.attr('cmd'),
				id = target.attr('data-id'),
				fid = target.attr('data-fid');
			switch(cmd){
				case 'ref':
					$.post(reUrl,{id:id},function(d){
						alert(d.data.msg);
						if(d.code == 0){
							window.location.reload();
						}
					});
					break;
				case 'del':
					$.post(delUrl,{id:id,fid : fid},function(d){
						alert(d.data.msg);
						if(d.code == 0){
							window.location.reload();
						}
					});				
					break;
			}
		});

	</script>	
</body>
</html>