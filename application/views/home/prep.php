<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="author" content="Tencent" />
  <title>教师工作室</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="/css/main.css" />
  <link rel="stylesheet" href="/css/jquery.plupload.queue.css" type="text/css" media="screen" />

  <meta property="qc:admins" content="124110632765637457144563757" />
</head>
<body>

	<?php  $this->load->view('public/header.php',$nav); ?>
	<div class="container">
		<div class="main-section">
			<div class="tool-zone fade-in">
				<div class="btn-zone">
					<?if($key=='' && ($prid != 0 || $fid != 0) ):?>
					<button class="upload btn btn-primary btn-upload" <?if(!$nav['userinfo']['id']):?>disabled="disabled"<?endif?>>上传</button>
					<button class="btn btn-default" data-toggle="modal" data-target="#newFold" <?if(!$nav['userinfo']['id']):?>disabled="disabled"<?endif?>>新建文件夹</button>
					<?endif?>
				</div>

				<div class="search-zone">
					<form action="/home/prepare?prid=<?=$prid?>&fid=<?=$fid?>" method="post" accept-charset="utf-8">
						<input type="text" name="key" value="搜索文件" data-def="搜索文件" id="searchKey" />
						<button type="submit"></button>
					</form>
				</div>
			</div>
			<div class="file-act-zone fade-in hide">
				<ul class="nav nav-pills">
					<li>
						<a data-toggle="dropdown">共享<span class="caret"></span></a>
						<ul id="actDropDown" class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
							<li><a data-toggle="modal" cmd="toother" data-target="#shareWin">发送给别人</a></li>
							<li><a data-toggle="modal" cmd="togroup" data-target="#shareWin">发送到小组</a></li>
							<li><a data-toggle="modal" cmd="todep"  data-target="#shareWin">提交到部门</a></li>
	<!-- 						<li><a>推优到学校</a></li> -->					
						</ul>						
					</li>
					<li class="downfile"><a cmd="downfile" id="donwFiles">下载</a></li>
					<!-- <li><a cmd="coll" id="collFiles">收藏</a></li> -->
					<li id="renameAct"><a cmd="rename" data-toggle="modal" data-target="#renameFile">重命名</a></li>
					<!-- <li><a cmd="copyFile" data-toggle="modal" data-target="#shareWin">复制</a></li> -->
					<li><a cmd="delFile" data-toggle="modal" data-target="#delFile">删除</a></li>
					<!-- <li id="remarkAct"><a cmd="remark" data-toggle="modal" data-target="#commentFile">评论</a></li> -->
				</ul>
			</div>

			<div class="section-tit">
				<div class="dropdown">				
					<a class="section-tit-a-first" href="/home/prepare">我的备课</a>
					<a><?=$pname?></a>&nbsp;&nbsp;
					<a href="/home/prepare?prid=<?=$prid?>"><?=$pfname?></a> &nbsp;&nbsp;
					<?if($thisfold['id'] > 0):?>	
							<?if(count($thisfold['idpath'])>1):?>
								<a>......</a>
							<?endif?>					
						<a class="section-tit-a-second"><?= $thisfold['name'] ?></a>
						<a class="section-tit-a-can" href="/home/prepare?prid=<?=$prid?>&fid=<?=$thisfold['pid']?>&od=<?=$od?>&on=<?=$on?>">返回上级</a>
					<?else:?>
						
					<?endif?>					
				</div>
				<ul class="act-zone">
					<li class="all-file file-type dropdown" id="changeFileType">
						<a role="button" data-toggle="dropdown" href="#">
							<?=get_file_type($type)?>
						<b class="caret"></b></a>
						<ul class="dropdown-menu section-tit-menu1" role="menu" aria-labelledby="dLabel">
							<?cr_file_type_li("/home/prepare?prid=$prid");?>
						</ul>						
					</li>
					<!--<li class="list-type" id="changeType"><i></i><span>图标</span></li>-->
				</ul>

			</div>
			<!--dis-list-type -->
			<div id="fileList" class="dis-list-type">
				<table width="100%" class="table table-striped table-hover" id="fileList">
					<?if(isset($fold) && count($fold)>0):?>
						<tr>
							<th width="30"><input type="checkbox" id="selectAllFold" /></th>
							<th><span>文件夹和文件</span>  
									<a href="/home/prepare?pid=<?=$prid?>&fid=<?=$fid?>&on=1&od=<?if($on==1 && $od ==1):?>2<?else:?>1<?endif?>"><span>名称</span> 
										<?if($on==1 && $od ==1):?><i class="ad"></i><?elseif($on==1 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
									</a>
							</th>				
							<th width="60">
							<a href="/home/prepare?prid=<?=$prid?>&fid=<?=$fid?>&on=2&od=<?if($on==2 && $od ==1):?>2<?else:?>1<?endif?>">
								<span>类型</span>  
								<?if($on==2 && $od ==1):?><i class="ad"></i><?elseif($on==2 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
							</a>
							</th>
							<th width="90">
								<a href="/home/prepare?prid=<?=$prid?>&fid=<?=$fid?>&on=3&od=<?if($on==3 && $od ==1):?>2<?else:?>1<?endif?>">
								<span>大小</span>  
								<?if($on==3 && $od ==1):?><i class="ad"></i><?elseif($on==3 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
								</a>
							</th>
							<th width="120">
								<a href="/home/prepare?prid=<?=$prid?>&fid=<?=$fid?>&on=4&od=<?if($on==4 && $od ==1):?>2<?else:?>1<?endif?>">
								<span>时间</span>  
								<?if($on==4 && $od ==1):?><i class="ad"></i><?elseif($on==4 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
								</a>
							</th>	
						</tr>	
						<?if($prid):?>
					<?foreach($fold as $item):?>
						<?if($item['pid'] == $fid):?>
						<tr data-id="<?=$item['id']?>">
							<td width="30"><input type="checkbox" name="file" class="fdclick liclick" value="<?=$item['id']?>" data-type="fold" /></td>
							<td>
								<a href="/home/prepare?prid=<?=$prid?>&fid=<?=$item['id']?>&od=<?=$od?>&on=<?=$on?>" data-id="1"><i class="fold"></i></a>
								
								<dl>
									<dt><a href="/home/prepare?prid=<?=$prid?>&fid=<?=$item['id']?>&od=<?=$od?>&on=<?=$on?>" data-id="1"><?=$item['name']?></a>
										<span cmd="edit" data-id="<?=$item['id']?>">
											<?if($item['mark']==''):?>
												编辑备注
											<?else:?>
											<?=$item['mark']?>&nbsp;
											<?endif?>
										</span>
										<span class="hide">
											<input class="name-edit" type="text" maxlength="20" value="<?=$item['mark']?>" />
											<i class="edit-comp" cmd="editComp" data-type="fold" data-id="<?=$item['id']?>"></i>
											<i class="edit-close" data-value="<?=$item['mark']?>" cmd="editClose"></i>
										</span>
									</dt>
									<dd>
									<!-- 	<span>下载</span> -->
									</dd>
								</dl>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>							
							<td width="90"><span><?=$item['time']?></span> </td>
						</tr>
						<?endif?>
						<?endforeach?>
						<?endif?>
					<?endif?>		
					<?if(count($flist)>0):?>				
						<?foreach($flist as $item):?>
							<tr class="file" data-id="<?=$item['id']?>">
								<td><input type="checkbox" name="file" class="fclick liclick" data-fid="<?=$item['fid']?>" value="<?=$item['id']?>" data-type="file" /></td>
								<td>
									<a class="file-name">
									<?if($item['type'] < 7):?>
										<i class="icon-type<?=(int) $item['type']?>" data-gid="<?=$prid?>" data-fid="<?=$item['fid']?>" data-id="<?=$item['id']?>" ></i>
									<?else:?>
										<i class="icon-type" data-fid="<?=$item['fid']?>" data-id="<?=$item['id']?>" ></i>
									<?endif?>
									</a>
									<dl>
										<dt><a class="file-name"  data-gid="<?=$prid?>" data-fid="<?=$item['fid']?>" data-id="<?=$item['id']?>" title="<?=htmlspecialchars($item['name'])?>"><?=htmlspecialchars(sub_string_length($item['name'],20))?></a>
											<span cmd="edit" data-id="<?=$item['id']?>"></span>
											<span class="hide">

											</span>
										</dt>
										<dd>								
											<span><a href="/download?id=<?=$item['fid']?>">下载</a></span>
										</dd>
									</dl>
								</td>

								<td>
									<?=get_file_type($item['type'])?>
								</td>
								<td><?=$item['size']?></td>
								<td><?=$item['time']?>
									<i <?if(isset($item['iscoll'])):?>class="colls s" cmd="uncoll" title="取消收藏"<?else:?>class="colls" cmd="coll" title="收藏"<?endif?> data-type="file" data-id="<?=$item['fid']?>"></i>
								</td>
							</tr>
						<?endforeach?>
					<?elseif($prid):?>									
						<tr>
							<td colspan="5" align="center">还没有文件哦.</td>
						</tr>
					<?endif?>
				</table>

			</div>
		</div>
		<div class="aside">
			<h3 class="selected">我的备课</h3>
			<ul class="my-prep-list">
				<?if(isset($plist)):?>
				<?foreach($plist as $k => $row):?>
					<li>
						<?=$row['name']?>
						<?if(isset($row['list'])):?>
							<ul>
							<?foreach($row['list'] as $r):?>
								<li>
									<?if(isset($r['name'])):?>
										<a href="/home/prepare?prid=<?=$r['id']?>"> <?=$r['name']?></a>
									<?endif?>
								</li>
							<?endforeach?>
							</ul>
						<?endif?>
					</li>
				<?endforeach?>
				<?endif?>
			</ul>
			<?if($nav['userinfo']['id']):?>
				<?  $this->load->view('public/userinfo.php',$nav['userinfo']); ?>
			<?endif?>			
		</div>

		<div class="clear"></div>		
	</div>	
	<div class="footer"></div>


	<div id="shareWin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">共享 </h4>
				</div>
				<div class="modal-body">
					<iframe id="shareIframe" width="538" height="370" border="0" frameborder="0" scroll="false" ></iframe>				
				</div>
			</div>
		</div>
	</div>

	<div id="delFile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">删除文件</h4>
				</div>
				<div class="modal-body">
					将要删除文件:
					<ul class="filelist"></ul>
					<input class="fid" type="hidden" value="" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					<button type="button" class="btn btn-primary btn-del">确定删除</button>
				</div>				
			</div>
		</div>
	</div>

	<div id="uploadFile" class="upload-win" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" cmd="close">&times;</button>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" cmd="min">-</button>
					<h4 class="modal-title">上传文件</h4>
				</div>
				<div class="modal-body">

				<form method="post" action="/cgi/upload">	
					<div id="uploader">
					</div>
				</form>	
				</div>
			</div>
		</div>
	</div>

	<div id="reviewFile" class="modal fade collection reviewWin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog review-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">预览文件</h4>
				</div>
				<div class="modal-body">
					<iframe id="reviewIframe" width="1040" height="820" border="0" frameborder="0" scroll="false" ></iframe>
				</div>
			</div>
		</div>
	</div>

	<div id="renameFile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">重命名文件</h4>
				</div>
				<form class="new-fold" id="reName" method="post">
				<div class="modal-body">
					<label>文件名称：</label><input class="foldname"  maxlength="20"  name="fname" type="text" style="width:80%" />
					<input type="hidden" class="fid" />
					<input type="hidden" class="type" value="0" />
					<input type="hidden" class="gid" value="<?=$prid?>" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					<button type="submit" class="btn btn-primary" id="renameFileBtn">确定</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<div id="commentFile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">评论文件</h4>
				</div>
				<form class="new-fold" id="remarkFile" method="post">
					<div class="modal-body">
						<label>文件名称：</label><span class="fname"></span>
						<textarea class="text-content" name="comment" style="width:90%;height:50px;" ></textarea>
						<input type="hidden" name="fid" class="fid"  />
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="submit" class="btn btn-primary">确定</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="newFold" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">新建文件夹</h4>
				</div>
				<form class="new-fold" id="newFolds" method="get">
					<div class="modal-body">
						
							<label>文件夹名称：</label><input id="foldname"  maxlength="20"  name="foldname" type="text" style="width:80%" />
							<input type="hidden" class="parentid" name="parentid" value="<?=$fid?>" />
							<input type="hidden" class="prid" name="prid" value="<?=$prid?>" />
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<input type="submit" class="btn btn-primary btn-new-fold" value="确定" />
					</div>
				</form>
			</div>
		</div>
	</div>



	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/lib/jq.validate.js"></script>

	<script type="text/javascript" src="/js/lib/moxie.js"></script>
	<script type="text/javascript" src="/js/lib/plupload.dev.js"></script>
	<script src="/js/lib/jquery.plupload.queue.js"></script>
    <script src="/js/common.js"></script>
<!-- 	// <script type="text/javascript" src="/js/lib/moxie.js"></script>
	// <script type="text/javascript" src="/js/lib/plupload.dev.js"></script>	 -->

	<script>
		var fid = '<?=$fid?>',
			gid = <?=$prid?>;

		var folds = '<?=json_encode($fold);?>',
			files = '<?=json_encode($flist);?>';
		folds = $.parseJSON(folds);
		files = $.parseJSON(files);		
		var upload_url = '<?=$upload_url;?>?gid=<?=$prid?>&fid=<?=$fid?>&csrf_test_name='+$.cookie('csrf_cookie_name'),
            upload_chunk = <?=$upload_chunk;?>;
		//var nowPrepId = '<?=$pid?>';
	</script>

	<script src="/js/upload.js"></script>
	<script src="/js/home.js"></script>
	<div id="alertTips" class="alert-tips"></div>
	<!--
	<div id="progTips" class="prog-tips">
		<div class="progress">
			<div class="progress-bar" style="width:40%;"></div>
			<span>20%</span>
		</div>
		<div class="prog-txt">正在上传</div>
	</div>
	-->
	<div id="normalTips" class="normal-tips"></div>
<?php  $this->load->view('public/footer.php'); ?>