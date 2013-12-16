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
			<form action="/home/coll" method="post">
			<input type="text" value="搜索文件" name="key" data-def="搜索文件" id="searchKey" />
			<button type="submit"></button>
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
	<table width="100%" class="table table-striped table-hover">
		<?if(count($flist)>0):?>
			<tr>
				<th>
					<a href="/home/coll?on=1&od=<?if($on==1 && $od ==1):?>2<?else:?>1<?endif?>">
					<span>文件名</span>  
					<?if($on==3 && $od ==1):?><i class="ad"></i><?elseif($on==3 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
					</a>				
					
				</th>
				<th width="80">来源</th>
				<th width="80">
					<a href="/home/coll?on=3&od=<?if($on==3 && $od ==1):?>2<?else:?>1<?endif?>">
					<span>大小</span>  
					<?if($on==3 && $od ==1):?><i class="ad"></i><?elseif($on==3 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
					</a>
				</th>
				<th width="120">
					<a href="/home/coll?on=4&od=<?if($on==4 && $od ==1):?>2<?else:?>1<?endif?>">
					<span>时间</span>  
					<?if($on==4 && $od ==1):?><i class="ad"></i><?elseif($on==4 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
					</a>
				</th>					
			</tr>
			<?foreach($flist as $row):?>
			<tr>
				<!-- <div class="td1"><input type="checkbox" /></div> -->
				<td>
					<?if($row['type'] < 7):?>
						<i class="icon-type<?=(int) $row['type']?>" data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>" ></i>
					<?else:?>
						<i class="icon-type" data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>" ></i>
					<?endif?>
					<dl>
						<dt><a data-review data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>"><?=$row['name']?></a></dt>
						<dd>
							<a data-review data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>" >预览</a>
							<a href="/cgi/downfile?fid=<?=$row['fid']?>" target="_blank">下载</a>
							<a data-uncoll data-id="<?=$row['fid']?>">取消收藏</a>
						</dd>
					</dl>
				</th>
				<td></td>
				<td><?=$row['size']?></td>
				<td><span><?=date('Y-m-d',$row['time'])?></span> </td>
			</tr>		
			<?endforeach?>			
		<?else:?>
			<tr>
				<td colspan="4">目前还没有相关的收藏</td>
			</tr>
		<?endif?>		
	</table>

	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/common.js" ></script>	
	<script src="/js/share.js" ></script>	
</body>
</html>