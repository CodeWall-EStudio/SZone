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
	<?php  $this->load->view('public/header.php',$nav);?>
	<div class="mcontainer">
		<div class="main-section">
			<div class="tool-zone fade-in">
				<div class="btn-zone">
<!-- 					<input type="file" class="upload-input" id="uploadFile" />  data-toggle="modal" data-target="#uploadFile"-->
					<?if($key==''):?>
					<button class="upload btn btn-primary btn-upload" <?if(!$nav['userinfo']['id']):?>disabled="disabled"<?endif?>>上传</button>
					<button class="btn btn-default" data-toggle="modal" data-target="#newFold" <?if(!$nav['userinfo']['id']):?>disabled="disabled"<?endif?>>新建文件夹</button>
					<?endif?>
				</div>

				<div class="search-zone">
					<form action="/" method="post" accept-charset="utf-8"  data-def="搜索文件">
						<input type="text" name="key" value="搜索文件" data-def="搜索文件" id="searchKey" />
						<input type="hidden" name="fid" value="<?=$fid?>" />
						<button type="submit"></button>
					</form>
				</div>
			</div>

			<div class="file-act-zone fade-in bs-callout bs-callout-warning hide" id="fileActZone">
				<ul class="nav nav-pills">
					<li class="sharefile">
						<a data-toggle="dropdown">共享<span class="caret"></span></a>
						<ul id="actDropDown" class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
							<li><a data-toggle="modal" cmd="toother" data-target="#shareWin">发送给别人</a></li>
							<li><a data-toggle="modal" cmd="togroup" data-target="#shareWin">发送到小组</a></li>
							<li><a data-toggle="modal" cmd="todep"  data-target="#shareWin">提交到部门</a></li>
						</ul>						
					</li>
					<li class="downfile"><a cmd="downfile" id="donwFiles">下载</a></li>
					<li class="renamefile" id="renameAct"><a cmd="rename" data-toggle="modal" data-target="#renameFile">重命名</a></li>
					<li class="copyfile"><a cmd="copyFile" data-toggle="modal" data-target="#shareWin">复制到备课</a></li>
					<li class="copyfile"><a cmd="moveFile" data-toggle="modal" data-target="#shareWin">移动文件</a></li>
					<li class="delfile"><a cmd="delFile" data-toggle="modal" data-target="#delFile">删除</a></li>
					<li class="cancel"><a cmd="cancel">取消</a></li>
				</ul>
			</div>

			<div class="section-tit">
				<div class="fold-list-link">
					<?if(count($flist)>0):?>
						<a id="list-tree" class="section-tit-a-first section-tit-a-border">树</a>				
					<?endif?>	
					<?if($key==''):?>
						<a  href="/home" style="z-index:20">个人文件</a>
						
						<?if($fid ):?>					
								<?if(count($thisfold['idpath'])>1):?>
									<a style="z-index:19">......</a>
								<?endif?>					
							<?if($thisfold['pid']):?>
								<a class="frist" style="z-index:19"  href="/home?fid=<?=$thisfold['pid']?>&od=<?=$od?>&on=<?=$on?>"><?= htmlspecialchars($fold[$thisfold['pid']]['name']) ?></a>
							<?endif?>
							<a class="end" style="z-index:18"><?= $thisfold['name'] ?></a>
							<a class="second" style="z-index:17" class="end" href="/home?fid=<?=$thisfold['pid']?>&od=<?=$od?>&on=<?=$on?>">返回上级</a>
						<?endif?>
					<?else:?>
						<a >搜索结果</a>
						<!-- <a class="end" href="/home?fid=<?=$fid?>&od=<?=$od?>&on=<?=$on?>">返回上级</a> -->
						<a class="return" href="/home?fid=<?=$fid?>&od=<?=$od?>&on=<?=$on?>">退出搜索结果</a>
					<?endif?>
				</div>
				<ul class="act-zone">
					<li class="all-file file-type dropdown" id="changeFileType">
						<a id="drop-type" "button" data-toggle="dropdown" href="#">
							<?=get_file_type($type)?>
						<b class="caret"></b></a>
						<ul class="dropdown-menu section-tit-menu1" aria-labelledby="drop-type">
							<?cr_file_type_li("/?fid=$fid");?>
						</ul>						
					</li>
					<!--<li class="list-type" id="changeType"><i></i><span>图标</span></li>-->
				</ul>
			</div>
			<div id="foldList" class="fold-list">
				<?if(count($flist)>0):?>
				<ul>
					<?foreach($flist as $item):?>
						<li class="list-li">
							<i class="<?if(isset($item['child'])):?>plus<?endif?>" data-id="<?=$item['id']?>"></i><a title="<?=$item['name']?>" class="list-link" href="/home?fid=<?=$item['id']?>&od=<?=$od?>&on=<?=$on?>"> <?=$item['name']?></a>							
						</li>						
					<?endforeach?>
				</ul>				
				<?endif?>
			</div>
			<div id="fileList" class="dis-list-type">
				<table width="100%" class="table table-striped table-hover">
					<tr>
						<th width="30"><input type="checkbox" id="selectAllFold" /></th>
						<th>
							文件夹和文件
							<a href="/home?on=1&od=<?if($on==1 && $od ==1):?>2<?else:?>1<?endif?>">
							<span>文件名</span>  
							<?if($on==1 && $od ==1):?><i class="ad"></i><?elseif($on==1 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
							</a>	

							<a data-tag="folds">选择本页所有文件夹</a>
							<a data-tag="files">选择本页所有文件</a>
						</th>
						<th width="90">
						<a href="/home?fid=<?=$thisfold['id']?>&on=2&od=<?if($on==2 && $od ==1):?>2<?else:?>1<?endif?>">
							<span>类型</span>  
							<?if($on==2 && $od ==1):?><i class="ad"></i><?elseif($on==2 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
						</a>
						</th>
						<th width="90">
							<a href="/home?fid=<?=$thisfold['id']?>&on=3&od=<?if($on==3 && $od ==1):?>2<?else:?>1<?endif?>">
							<span>大小</span>  
							<?if($on==3 && $od ==1):?><i class="ad"></i><?elseif($on==3 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
							</a>							

						</th>
						<th width="120" align="right">
							<a href="/home?fid=<?=$thisfold['id']?>&on=4&od=<?if($on==4 && $od ==1):?>2<?else:?>1<?endif?>">
							<span>时间</span>  
							<?if($on==4 && $od ==1):?><i class="ad"></i><?elseif($on==4 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
							</a>
						</th>
					</tr>
					<?foreach($fold as $item):?>
						<?if($item['pid'] == $fid):?>
						<tr>
							<td><input type="checkbox" name="file" class="fdclick liclick" value="<?=$item['id']?>" data-type="fold" /></td>
							<td>
								<a href="/home?fid=<?=$item['id']?>&od=<?=$od?>&on=<?=$on?>" data-id="1"><i class="fold"></i></a>
								
								<dl>
									<dt><a href="/home?fid=<?=$item['id']?>&od=<?=$od?>&on=<?=$on?>" data-id="1"><?=htmlspecialchars($item['name'])?></a>
										<span cmd="edit" data-id="<?=$item['id']?>">
											<?if($item['mark']==''):?>
												编辑备注
											<?else:?>
											<?=htmlspecialchars($item['mark'])?>&nbsp;
											<?endif?>
										</span>
										<span class="hide">
											<input class="name-edit" type="text" maxlength="20" value="<?=$item['mark']?>" />
											<i class="edit-comp" cmd="editComp" data-type="fold" data-id="<?=$item['id']?>"></i>
											<i class="edit-close" data-value="<?=htmlspecialchars($item['mark'])?>" cmd="editClose"></i>
										</span>
									</dt>
									<dd>
									<!-- 	<span>下载</span> -->
									</dd>
								</dl>							
							</td>
							<td></td>
							<td></td>
							<td><span><?=$item['time']?></span></td>
						</tr>
						<?endif?>
					<?endforeach?>
					<?if(count($file)>0):?>
					<?foreach($file as $item):?>
						<tr class="file" data-id="<?=$item['id']?>">
								<td><input type="checkbox" name="file" class="fclick liclick" value="<?=$item['id']?>"  data-fid="<?=$item['fid']?>" data-type="file" /></td>
								<td>
									<a class="file-name" data-fid="<?=$item['fid']?>" data-id="<?=$item['id']?>">
									<?if($item['type'] < 7):?>
										<i class="icon-type<?=(int) $item['type']?>" data-fid="<?=$item['fid']?>" data-id="<?=$item['id']?>" ></i>
									<?else:?>
										<i class="icon-type" data-fid="<?=$item['fid']?>" data-id="<?=$item['id']?>" ></i>
									<?endif?>
									</a>
									<dl>
										<dt><a class="file-name" data-fid="<?=$item['fid']?>" data-id="<?=$item['id']?>"><?=htmlspecialchars($item['name'])?></a>
											<span cmd="edit" data-id="<?=$item['id']?>"><?=htmlspecialchars($item['content'])?></span>
											<span class="hide">
												<input class="name-edit" type="text" value="<?=$item['content']?>" />
												<i class="edit-comp" cmd="editComp" data-type="file" data-id="<?=$item['id']?>"></i>
												<i class="edit-close" data-value="<?=$item['content']?>" cmd="editClose"></i>
											</span>
										</dt>
										<dd>
											<span><a class="share-file" data-toggle="dropdown" href="#" data-id="1">共享</a>
											<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
												<li><a data-toggle="modal" data-target="#shareWin" cmd="toother" data-id="<?=$item['id']?>" data-name="<?=htmlspecialchars($item['name'])?>">发送给别人</a></li>
												<li><a data-toggle="modal" data-target="#shareWin" cmd="togroup" data-id="<?=$item['id']?>" data-name="<?=htmlspecialchars($item['name'])?>">到小组空间</a></li>
												<li><a data-toggle="modal" data-target="#shareWin" cmd="todep" data-id="<?=$item['id']?>" data-name="<?=htmlspecialchars($item['name'])?>">到部门空间</a></li>
												<!-- <li><a cmd="toschool" data-id="<?=$item['id']?>" data-name="<?=$item['name']?>">到学校空间</a></li>		 -->			
											</ul>
											</span>										
											<span><a href="/download?id=<?=$item['fid']?>" data-id="1">下载</a></span>
										</dd>
									</dl>
								</td>
								<td>
									<?=get_file_type($item['type'])?>
								</td>
								<td><?=$item['size']?></td>	
								<td>
									<span><?=$item['time']?></span> <i <?if($item['coll']):?>class="colls s" cmd="uncoll" title="取消收藏"<?else:?>cmd="coll" class="colls" title="收藏"<?endif?> data-type="file" data-id="<?=$item['fid']?>"></i>
								</td>
						</tr>
						<?endforeach?>	
					<?else:?>				
						<tr>
							<td colspan="5" align="center">还没有文件哦.</td>
						</tr>					
					<?endif?>
				</table>
			</div>
			<div class="clear"></div>	
			<div class="page-zone">
				<?
					$page['url'] = '/?type='.$type.'&fid='.$fid.'&key='.$key.'&';
					create_page($page);
				?>
			</div>
		</div>
		<div class="aside">
			<?if($type==1):?>
				<h3>备课成果</h3>
			<?else:?>
				<h3 class="selected">个人文件</h3>
			<?endif?>
			<ul>
				<li>
					<a>通知</a><?if(($postmail+$newmail)>0):?><span>(<span id="allNums" data-num="<?=$postmail+$newmail?>" class="mailnum"><?=$postmail+$newmail?></span>)</span><?endif?>
				</li>
				<li id="shareHis">
					共享历史
					<p class="mailbox">
						<a cmd="get" data-toggle="modal" data-target="#mailbox">收件箱</a><?if($newmail>0):?><span>(<span id="newMailnum" class="mailnum"><?=$newmail?></span>)</span><?endif?>
					</p>
					<P class="mailbox">
						<a cmd="send" data-toggle="modal" data-target="#mailbox">发件箱</a><?if($postmail>0):?><span>(<span id="postMailnum" class="mailnum"><?=$postmail?></span>)</span><?endif?>
					</p>						
					<p class="mailbox">					
						<a cmd="share" data-toggle="modal" data-target="#mailbox">我的贡献</a>
					</p>
				</li>
				<li >
					<a id="myColl" data-toggle="modal" data-target="#mailbox">收藏夹</a>
				</li>				
				<li>
					<a id="myRecy" data-toggle="modal" data-target="#mailbox">回收站</a>
				</li>
			</ul>
		<?if($nav['userinfo']['id']):?>
			<?  $this->load->view('public/userinfo.php',$nav['userinfo']); ?>
		<?endif?>			
		</div>

		<div class="clear"></div>		
	</div>	
	<div class="footer"></div>
</div>

	<div id="delFile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">删除文件</h4>
				</div>
				<div class="modal-body">
					<span>将要删除文件:</span>
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

	<div id="collectionTOGroup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">收藏</h4>
				</div>
				<div class="modal-body">
					<ul class="form-horizontal">
						<li class="form-group">
							<label class="col-sm-2 control-label">小组</label>
							<div class="col-sm-10">
								<select class="form-control">
									<option>group name</option>
								</select>
							</div>
						</li>
						<li class="clear"></li>
					</ul>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					<button type="button" class="btn btn-primary">确定</button>
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
					<label>文件名称：</label><input class="foldname" name="fname" type="text" style="width:80%" maxlength="20" />
					<input type="hidden" class="fid" />
					<input type="hidden" class="type" value="0" />
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
						
							<label>文件夹名称：</label><input id="foldname" maxlength="20" name="foldname" type="text" style="width:80%" />
							<input type="hidden" class="parentid" name="parentid" value="<?=$fid?>" />
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<input type="submit" class="btn btn-primary btn-new-fold" value="确定" />
					</div>
				</form>
			</div>
		</div>
	</div>


	<div id="mailbox" class="modal fade collection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">收件箱 (2个新文件)</h4>
				</div>
				<div class="modal-body collection-mail-body">
					<iframe id="mailIframe"  width="750" height="570" border="0" frameborder="0" scroll="false" ></iframe>			
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
						<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
					</div>
				</form>	
				</div>
			</div>
		</div>
	</div>

	<script type="text/template" id="fold-list-tmp">
		<ul>
			<%
				for(var i in list){
					var item = list[i];
					console.log(item);
			%>
			<li>
				<i class="<%if(item.child){%>plus<%}%>" data-id="<%=item.id%>"></i><a class="list-link" href="/home?fid=<%=item.id%>&od=<?=$od?>&on=<?=$on?>"> <%=item.name%></a>	
			</li>
			<%}%>
		</ul>
	</script>

	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/lib/jq.validate.js"></script>
	<script src="/js/lib/jQuery.tmp.js"></script>
	

<!-- <script src="/js/lib/plupload.full.min.js"></script> -->
	
	<script type="text/javascript" src="/js/lib/moxie.js"></script>
	<script type="text/javascript" src="/js/lib/plupload.dev.js"></script>
	<script src="/js/lib/jquery.plupload.queue.js"></script>
    <script src="/js/common.js"></script>

    <script>
        var upload_url = '<?=$upload_url;?>?fid=<?=$fid?>&csrf_test_name='+$.cookie('csrf_cookie_name'),
            upload_chunk = <?=$upload_chunk;?>;
           
		// var folds = '<?=json_encode($fold);?>',
		// 	files = '<?=json_encode($file);?>';
		var fid = '<?=$fid?>';
		var folds = {},
			files = {};
		<?foreach($fold as $row):?>
			folds['<?=$row['id']?>'] = {
				id : '<?=$row['id']?>',
				name : '<?=$row['name']?>'
			};
		<?endforeach?>
		<?foreach($file as $row):?>
			files['<?=$row['id']?>'] = {
				id : '<?=$row['id']?>',
				name : '<?=$row['name']?>'
			};
		<?endforeach?>
		// folds = $.parseJSON(folds);
		// files = $.parseJSON(files);

		// console.log(folds);
		// console.log(files);
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