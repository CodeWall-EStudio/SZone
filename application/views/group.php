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
			<?if($ingroup):?>
				<div class="tool-zone fade-in">
					<div class="btn-zone">
	<!-- 					<input type="file" class="upload-input" id="uploadFile" /> -->
						<?if($key==''):?>
						<button class="upload btn btn-primary btn-upload" <?if(!$nav['userinfo']['id']):?>disabled="disabled"<?endif?>>上传</button>
						<button class="btn btn-default" data-toggle="modal" data-target="#newFold" <?if(!$nav['userinfo']['id']):?>disabled="disabled"<?endif?>>新建文件夹</button>
						<?endif?>
					</div>

					<div class="search-zone">
						<form action="/group?id=<?=$gid?>&fid=<?=$fid?>" method="post" accept-charset="utf-8" data-def="搜索文件">
						<input type="text" name="key" value="搜索文件" data-def="搜索文件" id="searchKey" />
						<button type="submit"></button>
						</form>
					</div>
				</div>

				<div class="file-act-zone fade-in hide" id="fileActZone">
					<ul class="nav nav-pills">
						<li class="sharefile">
							<a data-toggle="dropdown">共享<span class="caret"></span></a>
							<ul id="actDropDown" class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
								<li><a data-toggle="modal" cmd="toother" data-target="#shareWin">发送给别人</a></li>
								<li><a data-toggle="modal" cmd="togroup" data-target="#shareWin">发送到小组</a></li>
								<li><a data-toggle="modal" cmd="todep"  data-target="#shareWin">提交到部门</a></li>
		<!-- 						<li><a>推优到学校</a></li> -->					
							</ul>						
						</li>
						<li class="downfile"><a cmd="downfile" id="donwFiles">下载</a></li>
						<!-- <li class="collfile"><a cmd="coll" id="collFiles">收藏</a></li> -->
						<li class="renamefile" id="renameAct"><a cmd="rename" data-toggle="modal" data-target="#renameFile">重命名</a></li>
						<li class="copyfile"><a cmd="moveFile" data-toggle="modal" data-target="#shareWin" id="moveFile">移动文件</a></li>
						<li class="delfile"><a cmd="delFile" data-toggle="modal" data-target="#delFile">删除</a></li>
						<li class="cancel"><a cmd="cancel">取消</a></li>
						<!-- <li id="remarkAct"><a cmd="remark" data-toggle="modal" data-target="#commentFile">评论</a></li> -->
					</ul>
				</div>

				<div class="section-tit">
					<div class="fold-list-link">
						<?if(count($flist)>0):?>
							<a id="list-tree" class="section-tit-a-first section-tit-a-border">树</a>				
						<?endif?>		

						<?if($key==''):?>
							<a class="first" href="/group?id=<?=$gid?>" style="z-index:20">小组文件</a>
							<?if($fid):?>					
									<?if(count($thisfold['idpath'])>1):?>
										<a style="z-index:19">......</a>
									<?endif?>					
								<?if($thisfold['pid']):?>

									<a class="first" href="/group?id=<?=$gid?>&fid=<?=$thisfold['pid']?>&od=<?=$od?>&on=<?=$on?>" style="z-index:19"><?= htmlspecialchars($fold[$thisfold['pid']]['name']) ?></a>
								<?endif?>
								<a class="end" style="z-index:18"><?= htmlspecialchars($thisfold['name']) ?></a>
								<a class="second" style="z-index:17" href="/group?id=<?=$gid?>&fid=<?=$thisfold['pid']?>&od=<?=$od?>&on=<?=$on?>">返回上级</a>
							<?endif?>
						<?else:?>
							<a class="first" >搜索结果</a>
							<!-- <a class="section-tit-a-end">返回上级</a> -->
							<a class="end" href="/group?id=<?=$gid?>&fid=<?=$fid?>&od=<?=$od?>&on=<?=$on?>">退出搜索结果</a>
						<?endif?>
					</div>
					<ul class="act-zone">
						<li class="all-file file-type dropdown">
							<a role="button" data-toggle="dropdown" href="#">用户<b class="caret"></b></a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
								<li><a href="/group?id=<?=$gid?>&fid=<?=$fid?>">全部用户</a></li>
								<?foreach($ulist as $row):?>	
								<li><a href="/group?id=<?=$gid?>&fid=<?=$fid?>&ud=<?=$row['id']?>"><?=htmlspecialchars($row['name'])?></a></li>
								<?endforeach?>
							</ul>							
						</li>
						<li class="all-file file-type dropdown">
							<a role="button" data-toggle="dropdown" href="#">来源<b class="caret"></b></a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
								<li><a href="/group?id=<?=$gid?>&fid=<?=$fid?>&st=0">全部</a></li>
								<li><a href="/group?id=<?=$gid?>&fid=<?=$fid?>&st=1">上传</a></li>
								<li><a href="/group?id=<?=$gid?>&fid=<?=$fid?>&st=2">分享</a></li>
							</ul>
						</li>
						<li class="all-file file-type dropdown" id="changeFileType">
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
								<li><a data-type="0" href="/group?id=<?=$gid?>&fid=<?=$fid?>&type=0">全部</a></li>
								<li><a data-type="3" href="/group?id=<?=$gid?>&fid=<?=$fid?>&type=4">视频</a></li>
								<li><a data-type="1" href="/group?id=<?=$gid?>&fid=<?=$fid?>&type=1">图片</a></li>
								<li><a data-type="4" href="/group?id=<?=$gid?>&fid=<?=$fid?>&type=3">音乐</a></li>
								<li><a data-type="5" href="/group?id=<?=$gid?>&fid=<?=$fid?>&type=2">文档</a></li>
								<li><a data-type="6" href="/group?id=<?=$gid?>&fid=<?=$fid?>&type=5">应用</a></li>
								<li><a data-type="7" href="/group?id=<?=$gid?>&fid=<?=$fid?>&type=6">压缩包</a></li>
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
								<i class="<?if(isset($item['child'])):?>plus<?endif?>" data-id="<?=$item['id']?>"></i><a  title="<?=$item['name']?>"  class="list-link" href="/group?id=<?=$gid?>&fid=<?=$item['id']?>&od=<?=$od?>&on=<?=$on?>"> <?=htmlspecialchars($item['name'])?></a>							
							</li>						
						<?endforeach?>
					</ul>				
					<?endif?>
				</div>				
				<!--dis-list-type -->
				<div id="fileList" class="dis-list-type">
				<table width="100%" class="table table-striped table-hover">
					<tr>
						<th width="30"><input type="checkbox" id="selectAllFold" /></th>
						<th><span>文件夹和文件</span>  
							<a href="/group/?id=<?=$gid?>&on=1&od=<?if($on==1 && $od ==1):?>2<?else:?>1<?endif?>">
							<span>文件名</span>  
							<?if($on==3 && $od ==1):?><i class="ad"></i><?elseif($on==3 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
							</a>
							<a data-tag="folds">选择本页所有文件夹</a>
							<a data-tag="files">选择本页所有文件</a>							
						</th>
						<th width="60">评论</th>
						<th width="60">作者</th>
						<th width="60">来源</th>
						<th width="90">
							<a href="/group/?id=<?=$gid?>&on=2&od=<?if($on==2 && $od ==1):?>2<?else:?>1<?endif?>">
								<span>类型</span>  
								<?if($on==2 && $od ==1):?><i class="ad"></i><?elseif($on==2 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
							</a>
						</th>
						<th width="90">
							<a href="/group/?id=<?=$gid?>&on=3&od=<?if($on==3 && $od ==1):?>2<?else:?>1<?endif?>">
							<span>大小</span>  
							<?if($on==3 && $od ==1):?><i class="ad"></i><?elseif($on==3 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
							</a>								

						</th>
						<th width="120">
								<a href="/group/?id=<?=$gid?>&on=4&od=<?if($on==4 && $od ==1):?>2<?else:?>1<?endif?>">
								<span>时间</span>  
								<?if($on==4 && $od ==1):?><i class="ad"></i><?elseif($on==4 && $od ==2):?><i class="au"></i><?else:?><i class="ad"></i><?endif?>
								</a>								
						</th>						
					</tr>
					<?foreach($fold as $item):?>
						<?if($item['pid'] == $fid):?>
						<tr class="fold" data-id="<?=$item['id']?>">
							<td><input type="checkbox" name="fold" class="fdclick liclick" value="<?=$item['id']?>" data-type="fold" /></td>
							<td>
								<a href="/group?id=<?=$gid?>&fid=<?=$item['id']?>" data-id="1"><i class="fold" data-id="1"></i></a>
								<dl>
									<dt><a href="/group?id=<?=$gid?>&fid=<?=$item['id']?>" data-id="1"><?=htmlspecialchars($item['name'])?></a>										
										<span cmd="edit" data-id="<?=$item['id']?>">
											<?if($item['mark']==''):?>
												编辑备注
											<?else:?>
												<?=htmlspecialchars($item['mark'])?>&nbsp;
											<?endif?>	
										</span>
										<span class="hide">
											<input class="name-edit" type="text" value="<?=$item['mark']?>" />
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
							<td></td>
							<td></td>
							<td></td>
							<td><span><?=$item['time']?></span> </td>							
						</tr>
						<?endif?>
					<?endforeach?>
					<?if(count($file)>0):?>

						<?foreach($file as $item):?>
							<tr class="file" data-id="<?=$item['id']?>">
								<td><input type="checkbox" name="file" class="fclick liclick" value="<?=$item['id']?>" data-fid="<?=$item['fid']?>" data-type="file" /></td>
								<td>
									<a class="file-name" data-fid="<?=$item['fid']?>" data-id="<?=$item['id']?>">
									<?if($item['type'] < 7):?>
										<i class="icon-type<?=(int) $item['type']?>" data-fid="<?=$item['fid']?>" data-id="<?=$item['id']?>" ></i>
									<?else:?>
										<i class="icon-type" data-fid="<?=$item['fid']?>" data-id="<?=$item['id']?>" ></i>
									<?endif?>
									</a>
									<dl>
										<dt><a class="file-name" data-fid="<?=$item['fid']?>" data-id="<?=$item['id']?>"><?=$item['name']?></a>
											<span cmd="edit" data-id="<?=$item['id']?>"><?=$item['mark']?></span>
											<span class="hide">
												<input class="name-edit" type="text" value="<?=$item['mark']?>" />
												<i class="edit-comp" cmd="editComp" data-type="file" data-id="<?=$item['id']?>"></i>
												<i class="edit-close" data-value="<?=htmlspecialchars($item['mark'])?>" cmd="editClose"></i>
											</span>
										</dt>
										<dd>
											<span><a data-toggle="dropdown" href="#"  data-id="1">共享</a>
											<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
												<li><a data-toggle="modal" data-target="#shareWin" cmd="toother" data-id="<?=$item['id']?>" data-name="<?=htmlspecialchars($item['name'])?>">发送给别人</a></li>
												<li><a data-toggle="modal" data-target="#shareWin" cmd="togroup" data-id="<?=$item['id']?>" data-name="<?=htmlspecialchars($item['name'])?>">到小组空间</a></li>
												<li><a data-toggle="modal" data-target="#shareWin" cmd="todep" data-id="<?=$item['id']?>" data-name="<?=htmlspecialchars($item['name'])?>">到部门空间</a></li>
												<!-- <li><a cmd="toschool" data-id="<?=$item['id']?>" data-name="<?=$item['name']?>">到学校空间</a></li>		 -->			
											</ul>
											</span>	
											<?if($item['cancopy']):?>
											<span id="copy<?=$item['fid']?>">
												<a cmd="copy" data-fid="<?=$item['fid']?>">保存</a>
											</span>	
											<?endif?>								
											<span><a href="/download?id=<?=$item['fid']?>&gid=<?=$gid?>"  data-id="1">下载</a></span>
										</dd>
									</dl>
								</td>
								<td><?=htmlspecialchars($item['mark'])?></td>
								<td><?=htmlspecialchars($item['uname'])?></td>
								<td>
									<?if($item['status']):?>
										分享
									<?else:?>
										上传
									<?endif?>
								</td>
								<td>
								<?
									switch($item['type']){
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
								</td>
								<td><?=$item['size']?></td>								
								<td>
									<span><?=date('Y-m-d',$item['time'])?></span> <i <?if($item['coll']):?>class="s" cmd="uncoll" title="取消收藏"<?else:?>cmd="coll" title="收藏"<?endif?> data-type="file" data-id="<?=$item['fid']?>"></i>
								</td>
							</tr>
						<?endforeach?>
					<?else:?>
						<tr>
							<td colspan="8" align="center">还没有文件哦.</td>
						</tr>
					<?endif?>					
				</table>					
				</div>
				<div class="page-zone">
					<?
						$page['url'] = '/group?id='.$gid.'&type='.$type.'&fid='.$fid.'&';
						create_page($page);
					?>
				</div>	
			<?else:?>
				<div class="empty">你不是该组的成员,<a href="/">返回个人空间</a></div>	
			<?endif?>
		</div>
		<?if($ingroup):?>
		<div class="aside">
			<h3 class="selected"><?=htmlspecialchars($ginfo['name'])?></h3>
			<div class="group-desc" id="groupDesc">
				<h6>小组公告: &nbsp;&nbsp;<a>编辑</a></h6> 
				<p>
				<?if($ginfo['content'] == ''):?>
					暂无公告
				<?else:?>
					<?=$ginfo['content']?>
				<?endif?>
				</p>
			</div>
			<div class="group-desc hide" id="groupEdit">
				<h6>小组公告: &nbsp;&nbsp;<a class="save">保存</a>  <a class="esc">取消</a></h6> 
				<p>
					<textarea></textarea>
				</p>
			</div>			
			<div class="group-board">
				<h4>留言板</h4>
				<div class="group-board-act"><a data-toggle="modal" cmd="toother" data-target="#postWin">发留言</a> <a data-toggle="modal" cmd="toother" data-target="#boardWin">查看全部</a></div>
				<ul class="group-board-list">
					<?if(count($blist)>0):?>
						<?foreach($blist as $row):?>
						<li>
							<?=date('Y-m-d',$row['time'])?>  <?=$row['name']?>
							<p><?=$row['content']?></p>
						</li>
						<?endforeach?>
					<?else:?>
					<li>暂无留言</li>
					<?endif?>
				</ul>

			</div>
			<?if($nav['userinfo']['id']):?>
				<?  $this->load->view('public/userinfo.php',$nav['userinfo']); ?>
			<?endif?>
		</div>
		<?endif?>
		<div class="clear"></div>		
		
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

	<div id="postWin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">发表留言</h4>
				</div>
				<div class="modal-body">
					<textarea></textarea>
					<input class="fid" type="hidden" value="" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					<button type="button" class="btn btn-primary btn-post">发表</button>
				</div>				
			</div>
		</div>
	</div>	

	<div id="boardWin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">发表留言</h4>
				</div>
				<div class="modal-body">
					<iframe id="boardIframe" src="/board?gid=<?=$ginfo['id']?>" width="538" height="570" border="0" frameborder="0" scroll="false" ></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>				
			</div>
		</div>
	</div>		
<!-- 
	<div id="uploadFile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">上传文件</h4>
				</div>
				<div class="modal-body">
					<div id="uploadContainer">
						<button type="button" class="btn btn-default" id="btnUpload">选择文件</button>
						<button type="button" class="btn btn-primary" id="btnStartUload">上传</button>
					</div>
					<input type="hidden" class="foldid" value="<?=$fid?>" />
					<div id="file_uploadList"></div>
				</div>
			</div>
		</div>
	</div> -->

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
					<label>文件名称：</label><input class="foldname" maxlength="20" name="fname" type="text" style="width:80%" />
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
					<input type="hidden" class="parentid" name="groupid" value="<?=$gid?>" />					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					<button type="submit" class="btn btn-primary" id="renameFileBtn">确定</button>
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
						
							<label>文件夹名称：</label><input id="foldname" name="foldname" type="text" style="width:80%" />
							<input type="hidden" class="parentid" name="parentid" value="<?=$fid?>" />
							<input type="hidden" class="groupid" name="groupid" value="<?=$gid?>" />
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<input type="submit" class="btn btn-primary btn-new-fold" value="确定" />
					</div>
				</form>
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
				<i class="<%if(item.child){%>plus<%}%>" data-id="<%=item.id%>"></i><a class="list-link" href="/group?id=<?=$gid?>&fid=<%=item.id%>&od=<?=$od?>&on=<?=$on?>"> <%=item.name%></a>	
			</li>
			<%}%>
		</ul>
	</script>	

	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/lib/jq.validate.js"></script>
	<script src="/js/lib/jQuery.tmp.js"></script>
	<!--<script src="/js/lib/plupload.full.min.js"></script>-->

	<script type="text/javascript" src="/js/lib/moxie.js"></script>
	<script type="text/javascript" src="/js/lib/plupload.dev.js"></script>
	<script src="/js/lib/jquery.plupload.queue.js"></script>
    <script src="/js/common.js"></script>
    <!-- 	// <script type="text/javascript" src="/js/lib/moxie.js"></script>
        // <script type="text/javascript" src="/js/lib/plupload.dev.js"></script>	 -->
	<script>
        var upload_url = '<?=$upload_url?>?fid=<?=$fid?>&gid=<?=$gid?>&csrf_test_name='+$.cookie('csrf_cookie_name'),
            upload_chunk = '<?=$upload_chunk?>';	
		// var folds = '<?=json_encode($fold);?>',
		// 	files = '<?=json_encode($file);?>';
		var ginfo = '<?=json_encode($ginfo);?>';
		var fid = '<?=$fid?>';
		//folds = $.parseJSON(folds);
		//files = JSON.parse(files);//$.parseJSON(files);
		ginfo = $.parseJSON(ginfo);
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


	</script>

	<script src="/js/upload.js"></script>
	<script src="/js/group.js"></script>
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
