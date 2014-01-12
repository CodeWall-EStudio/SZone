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
			<form action="/home/sendmail?m=<?=$m?>" method="post">
			<input class="search-input-length"  type="text" value="搜索文件" name="key"  data-def="搜索文件" id="searchKey" />
			<button type="submit"></button>
			</form>
		</div>
		<div class="collection-act">
			<div>
				<a role="button" data-toggle="dropdown" href="#">全部用户<b class="caret"></b></a>
				<ul class="dropdown-menu section-tit-menu1" role="menu" aria-labelledby="dLabel">
					<li><a href="/home/sendmail?m=<?=$m?>&uid=0&type=<?=$type?>">全部用户</a></li>
					<?foreach($ulist as $row):?>
						<li><a href="/home/sendmail?m=<?=$m?>&uid=<?=$row['id']?>&type=<?=$type?>"><?=$row['name']?></a></li>
					<?endforeach?>
				</ul>
			</div>
			<div>
				<a role="button" data-toggle="dropdown" href="#">
					<?=get_file_type($type)?>
				<b class="caret"></b></a>
				<ul class="dropdown-menu section-tit-menu1" role="menu" aria-labelledby="dLabel">
					<?cr_file_type_li("/home/sendmail?m=$m&uid=$uid");?>
				</ul>
			</div>
		</div>
	</div>
		<?if($key!=''):?>
		<div class="search-key">
			当前搜索关键字:　<span><?=$key?></span>  <a href="/home/sendmail?m=<?=$m?>">退出搜索</>
		</div>
		<?endif?>	
	<table width="100%" class="table table-striped table-hover">
		<?if(count($mail)>0):?>
		<tr>
			<!-- <div class="td1"><input type="checkbox" /></div> -->
			<th>
				<a href="/home/sendmail?m=<?=$m?>&on=1&od=<?if($on==1 && $od ==1):?>2<?else:?>1<?endif?>">
				<span>文件名</span>  
				<?if($on==1 && $od ==1):?><i class="ad"></i><?elseif($on==1 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
				</a>	
			</th>
			<th width="90"><?if((int) $m):?>来源<?else:?>目标<?endif?>用户</th>
			<th width="90">
				<a href="/home/sendmail?m=<?=$m?>&on=3&od=<?if($on==3 && $od ==1):?>2<?else:?>1<?endif?>">
				<span>大小</span>  
				<?if($on==3 && $od ==1):?><i class="ad"></i><?elseif($on==3 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
				</a>				

			</th>
			<th width="120">
				<a href="/home/sendmail?m=<?=$m?>&on=4&od=<?if($on==4 && $od ==1):?>2<?else:?>1<?endif?>">
				<span>时间</span>  
				<?if($on==4 && $od ==1):?><i class="ad"></i><?elseif($on==4 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
				</a>				

			</th>
		</tr>
		<?foreach($mail as $row):?>
		<tr>
			<!-- <div class="td1"><input type="checkbox" /></div> -->
			<td>
				<a class="file-name" data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>" data-mail="1">
				<?if($row['type'] < 7):?>
					<i class="icon-type<?=(int) $row['type']?>" data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>"  data-mail="1"></i>
				<?else:?>
					<i class="icon-type" data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>" data-mail="1" ></i>
				<?endif?>					

				</a>
				<dl>
					<dt>
						<a class="file-name" data-review data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>" data-mail="1"><?=$row['fname']?></a>&nbsp;
						<span title="<?=$row['content']?>"><?=$row['content']?></span>
					</dt>
					<dd>
						<?if($m):?>

							<?if(!$row['save']):?><a id="savefile<?=$row['id']?>" data-save data-id="<?=$row['id']?>" target="_blank">保存</a><?endif?>
							<a href="/download?id=<?=$row['fid']?>&mid=<?=$row['id']?>" target="_blank">下载</a>
						<?else:?>
							<a href="/download?id=<?=$row['fid']?>" target="_blank">下载</a>
						<?endif?>
						
					</dd>
				</dl>
			</td>
			<td><?=$row['uname']?></td>
			<td><?=$row['size']?></td>
			<td><span><?=substr($row['ctime'],0,10)?></span> </td>
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