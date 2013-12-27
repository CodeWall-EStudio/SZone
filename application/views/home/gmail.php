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
			<form action="/home/groupmail" method="post">
			<input class="search-input-length"  type="text" value="搜索文件" name="key" data-def="搜索文件" id="searchKey" />
			<button type="submit"></button>
			</form>
		</div>
		<div class="collection-act">
			<div>
				<a role="button" data-toggle="dropdown" href="#">全部组织<b class="caret"></b></a>
				<ul class="dropdown-menu section-tit-menu1" role="menu" aria-labelledby="dLabel">
					<li><a href="/home/groupmail?gid=0&type=<?=$type?>">全部组织</a></li>
					<?foreach($glist as $row):?>
						<li><a href="/home/groupmail?gid=<?=$row['id']?>&type=<?=$type?>"><?=$row['name']?></a></li>
					<?endforeach?>
				</ul>
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
					<li><a data-type="0" href="/home/groupmail?gid=<?=$gid?>&type=0">全部</a></li>
					<li><a data-type="2">收藏</a></li>
					<li><a data-type="3" href="/home/groupmail?gid=<?=$gid?>&type=4">视频</a></li>
					<li><a data-type="1" href="/home/groupmail?gid=<?=$gid?>&type=1">图片</a></li>
					<li><a data-type="4" href="/home/groupmail?gid=<?=$gid?>&type=3">音乐</a></li>
					<li><a data-type="5" href="/home/groupmail?gid=<?=$gid?>&type=2">文档</a></li>
					<li><a data-type="6" href="/home/groupmail?gid=<?=$gid?>&type=5">应用</a></li>
					<li><a data-type="7" href="/home/groupmail?gid=<?=$gid?>&type=6">压缩包</a></li>
				</ul>
			</div>
		</div>
	</div>
		<?if($key!=''):?>
		<div class="search-key">
			当前搜索关键字:　<span><?=$key?></span>  <a href="/home/groupmail">退出搜索</>
		</div>
		<?endif?>	
	<table width="100%" class="table table-striped table-hover">
		<?if(count($mail)>0):?>
		<tr>
			<!-- <div class="td1"><input type="checkbox" /></div> -->
			<th>
				<a href="/home/groupmail?on=1&od=<?if($on==1 && $od ==1):?>2<?else:?>1<?endif?>">
				<span>文件名</span>  
				<?if($on==1 && $od ==1):?><i class="ad"></i><?elseif($on==1 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
				</a>				
				
			</th>
			<th width="140">目标组织</th>
			<th width="90">
				<a href="/home/groupmail?on=3&od=<?if($on==3 && $od ==1):?>2<?else:?>1<?endif?>">
				<span>大小</span>  
				<?if($on==3 && $od ==1):?><i class="ad"></i><?elseif($on==3 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
				</a>				
				
			</th>
			<th width="120">
				<a href="/home/groupmail?on=4&od=<?if($on==4 && $od ==1):?>2<?else:?>1<?endif?>">
				<span>时间</span>  
				<?if($on==4 && $od ==1):?><i class="ad"></i><?elseif($on==4 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
				</a>				
			</th>
		</tr>
		<?foreach($mail as $row):?>
		<tr>
			<!-- <div class="td1"><input type="checkbox" /></div> -->
			<td>
				<?if($row['type'] < 7):?>
					<i class="icon-type<?=(int) $row['type']?>" data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>" ></i>
				<?else:?>
					<i class="icon-type" data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>" ></i>
				<?endif?>	
				<dl>
					<dt><a class="file-name" data-review data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>"><?=$row['fname']?></a></dt>
					<dd>
						<a data-id="<?=$row['id']?>"  data-review data-fid="<?=$row['fid']?>">预览</a>
						<a href="/download?id=<?=$row['fid']?>" target="_blank">下载</a>
					</dd>
				</dl>
			</td>
			<td class="td3"><?=$row['gname']?></td>
			<td class="td_size"><?=$row['size']?></td>
			<td class="td_time"><span><?=date('Y-m-d',$row['ctime'])?></span> </td>
		</tr>		
		<?endforeach?>		
		<?else:?>
			<tr>
				<td colspan="4">目前还没有相关的邮件</td>
			</tr>
		<?endif?>		
	</table>			

	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/share.js" ></script>	
</body>
</html>