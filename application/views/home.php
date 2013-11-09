<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="author" content="Tencent" />
  <title>教师工作室</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="/css/main.css" />
 
  <meta property="qc:admins" content="124110632765637457144563757" />
</head>
<body>
	<?php  $this->load->view('public/header.php',$nav); ?>

	<div class="container">
		<div class="main-section">
			<div class="tool-zone fade-in">
				<div class="btn-zone">
<!-- 					<input type="file" class="upload-input" id="uploadFile" /> -->
					<button class="upload btn btn-primary" data-toggle="modal" data-target="#uploadFile">上传</button>
					<button class="btn btn-default" data-toggle="modal" data-target="#newFold">新建文件夹</button>
				</div>

				<div class="search-zone">
					<input type="text" value="搜索文件" />
					<button></button>
				</div>
			</div>
			<div class="file-act-zone fade-in hide">
				<ul class="nav nav-pills">
					<li>
						<a data-toggle="dropdown">共享<span class="caret"></span></a>
						<ul class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
							<li><a data-toggle="modal" data-target="#sendToOther">发送给别人</a></li>
							<li><a data-toggle="modal" data-target="#sendToGroup">发送到小组</a></li>
							<li><a data-toggle="modal" data-target="#sendToDep">提交到部门</a></li>
							<li><a>推优到学校</a></li>					
						</ul>						
					</li>
					<li><a>下载</a></li>
					<li><a>收藏</a></li>
					<li><a data-toggle="modal" data-target="#renameFile">重命名</a></li>
					<li><a>移动</a></li>
					<li><a>删除</a></li>
					<li><a data-toggle="modal" data-target="#commentFile">评论</a></li>
				</ul>
			</div>

			<div class="section-tit">
				<div class="dropdown">
					<a data-toggle="dropdown" class="section-tit-a-first section-tit-a-border">树</a>
					<ul class="dropdown-menu section-tit-menu" role="menu" aria-labelledby="dLabel" id="myFileList">
						<li>
							<a class="glyphicon glyphicon-plus"> 工作文件</a>
						</li>
						<li>
							<a class="glyphicon glyphicon-minus"> 教学素材</a>
							<ul>
								<li><a class="glyphicon glyphicon-minus"> 图片</a></li>
								<li><a class="glyphicon glyphicon-minus"> 音乐</a></li>
							</ul>
						</li>
						<li><a class="glyphicon glyphicon-minus"> 游戏</a></li>
						<li><a class="glyphicon glyphicon-minus"> 其他</a></li>
					</ul>					
					<a class="section-tit-a-first">个人文件</a>
					<a class="section-tit-a-second hide">文件夹名称</a>
					<a class="section-tit-a-end">返回上级</a>
				</div>
				<ul class="act-zone">
					<li class="all-file file-type dropdown" id="changeFileType">
						<a role="button" data-toggle="dropdown" href="#">全部类型<b class="caret"></b></a>
						<ul class="dropdown-menu section-tit-menu1" role="menu" aria-labelledby="dLabel">
							<li><a data-type="0">全部</a></li>
							<li><a data-type="2">收藏</a></li>
							<li><a data-type="3">视频</a></li>
							<li><a data-type="1">图片</a></li>
							<li><a data-type="4">音乐</a></li>
							<li><a data-type="5">文档</a></li>
							<li><a data-type="6">应用</a></li>
							<li><a data-type="7">压缩包</a></li>
						</ul>						
					</li>
					<!--<li class="list-type" id="changeType"><i></i><span>图标</span></li>-->
				</ul>

			</div>
			<!--dis-list-type -->
			<div id="fileList" class="dis-list-type">
				<ulclass="cl">
					<li class="tit">
						<div class="td1"><input type="checkbox" /></div>
						<div class="td2"><span>文件夹(<b><?=count($fold)?></b>个)</span>  名称 <i></i></div>
						<div class="td3"></div>
						<div class="td4">时间</div>
					</li>
					<?foreach($fold as $item):?>
						<li class="fold" data-id="<?=$item['id']?>">
							<div class="td1"><input type="checkbox" /></div>
							<div class="td2">
								<i class="fold"></i>
								<dl>
									<dt><?=$item['name']?> 
										<span cmd="edit" data-id="<?=$item['id']?>"><?=$item['mark']?></span>
										<span class="hide">
											<input class="name-edit" type="text" value="<?=$item['mark']?>" />
											<i class="edit-comp" cmd="editComp" data-type="fold" data-id="<?=$item['id']?>"></i>
											<i class="edit-close" data-value="<?=$item['mark']?>" cmd="editClose"></i>
										</span>
									</dt>
									<dd>
										<span>下载</span>
									</dd>
								</dl>
							</div>
							<div class="td3"> </div>
							<div class="td4"><span><?=$item['time']?></span> <i></i></div>
						</li>
					<?endforeach?>
					<li class="tit file-list">
						<div class="td1"><input type="checkbox" /></div>
						<div class="td2"><span>文件(<b>4</b>个)</span>  </div>
					</li>	
					<?foreach($file as $item):?>
						<li class="file" data-id="<?=$item['id']?>">
							<div class="td1"><input type="checkbox" /></div>
							<div class="td2">
								<?if($item['type'] == 1):?>
									<img src="<?=$item['path']?>" />
								<?else:?>
									<i class="fold"></i>
								<?endif?>
								<dl>
									<dt><?=$item['name']?> 
										<span cmd="edit" data-id="<?=$item['id']?>"><?=$item['content']?></span>
										<span class="hide">
											<input class="name-edit" type="text" value="<?=$item['content']?>" />
											<i class="edit-comp" cmd="editComp" data-type="file" data-id="<?=$item['id']?>"></i>
											<i class="edit-close" data-value="<?=$item['content']?>" cmd="editClose"></i>
										</span>
									</dt>
									<dd>
										<span>分享</span>
										<span>下载</span>
									</dd>
								</dl>
							</div>
							<div class="td3"> </div>
							<div class="td4"><span><?=$item['time']?></span> <i cmd="coll" <?if(in_array($item['id'],$coll)):?>class="s"<?endif?> data-type="file" data-id="<?=$item['id']?>"></i></div>
						</li>
					<?endforeach?>										
					<li class="last"></li>
				</ul>
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
					<a>通知</a>
				</li>
				<li>
					共享历史
					<p>
						<a data-toggle="modal" data-target="#shareFrom">收件箱</a> 
					</p>
					<P>
						<a data-toggle="modal" data-target="#shareTo">发件箱</a>
					</p>						
					<p>					
						<a data-toggle="modal" data-target="#shareTo">我的贡献</a>
					</p>

						
				</li>
				<li>
					<a data-toggle="modal" data-target="#collection">收藏夹</a>
				</li>				
				<li>
					<a data-toggle="modal" data-target="#recycleBox">回收站</a>
				</li>
			</ul>
		</div>
		<div class="userinfo">
			<div>个人空间已用 30%</div>
			<div class="user-zone"> 
				<div class="prog"></div>3.15G/30G
			</div>			
			<div>修改密码 退出登录</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="footer"></div>

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

					<div id="file_uploadList"></div>
				</div>
<!-- 				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					<button type="button" class="btn btn-primary">确定</button>
				</div> -->
			</div>
		</div>
	</div>

	<div id="sendToOther" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">共享</h4>
				</div>
				<div class="modal-body">
					<div class="share-tit">发送文件(8)个：<i>xxxx,xxxx,xxx等</i></div>
					<div class="share-msg">附言：<p> <input type="text" /></p></div>
					<div class="share-act-zone">
						<p><input type="text" value="搜索用户" /><i></i></p>
						<div>
							<button class="btn btn-default">加入名单</button>
							<button class="btn btn-primary">发送</button>
						</div>
					</div>
					<div class="share-target">
						发送目标
						<ul>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
						</ul>						
					</div>
					<div class="share-select">
						搜索结果
						<ul>
							<li>username</li>
							<li>username</li>
						</ul>						
					</div>	
					<div class="clear"></div>				
				</div>
			</div>
		</div>
	</div>

	<div id="sendToGroup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">共享 到小组空间</h4>
				</div>
				<div class="modal-body">
					<div class="share-tit">发送文件(8)个：<i>xxxx,xxxx,xxx等</i></div>
					<div class="share-act-zone">
						<p><input type="text" value="搜索部门" /><i></i></p>
						<div>
							<button class="btn btn-primary">共享</button>
						</div>
					</div>
					<div class="share-target">
						发送目标
						<ul>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
						</ul>						
					</div>
					<div class="share-select">
						搜索结果
						<ul>
							<li>username</li>
							<li>username</li>
						</ul>						
					</div>	
					<div class="clear"></div>				
				</div>
			</div>
		</div>
	</div>	

	<div id="sendToDep" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">共享 到部门空间</h4>
				</div>
				<div class="modal-body">
					<div class="share-tit">发送文件(8)个：<i>xxxx,xxxx,xxx等</i></div>
					<div class="share-act-zone">
						<p><input type="text" value="搜索部门" /><i></i></p>
						<div>
							<button class="btn btn-primary">共享</button>
						</div>
					</div>
					<div class="share-target">
						发送目标
						<ul>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
							<li><a>username</a></li>
						</ul>						
					</div>
					<div class="share-select">
						搜索结果
						<ul>
							<li>username</li>
							<li>username</li>
						</ul>						
					</div>	
					<div class="clear"></div>				
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

	<div id="reviewFile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="file-review">
						<img src="http://i2.hoopchina.com.cn/blogfile/201310/30/138306711783216.jpg" />
					</div>
					<div class="file-reivew-act">
						<span class="glyphicon glyphicon-repeat rotate"></span>
						<span class="glyphicon glyphicon-repeat"></span>
						<span class="glyphicon glyphicon-zoom-in"></span>
						<span class="glyphicon glyphicon-zoom-out"></span>
					</div>
					  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
					    <span class="glyphicon glyphicon-chevron-left"></span>
					  </a>
					  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
					    <span class="glyphicon glyphicon-chevron-right"></span>
					  </a>					
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
				<div class="modal-body">
					<input type="text" style="width:80%" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					<button type="button" class="btn btn-primary">确定</button>
				</div>
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
				<div class="modal-body">
					<textarea style="width:90%;height:50px;" ></textarea>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					<button type="button" class="btn btn-primary">确定</button>
				</div>
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
				<form class="new-fold" id="newFold" method="get">
					<div class="modal-body">
						
							<label>文件夹名称：</label><input id="foldname" name="foldname" type="text" style="width:80%" />
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<input type="button" class="btn btn-primary btn-new-fold" value="确定" />
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="collection" class="modal fade collection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">收藏夹</h4>
				</div>
				<div class="modal-body collection-body">
					<div class="collection-tit">
						<div class="search-zone">
							<input type="text" value="搜索文件" />
							<button></button>
						</div>
						<div class="collection-act">
							<a>查看作者</a>
							<a>查看全部类型</a>
						</div>
					</div>
					<div class="">
						<ul class="dis-list-type">
							<li class="tit">
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">名称</div>
								<div class="td3">作者</div>
								<div class="td4">位置</div>
								<div class="td5">大小</div>
								<div class="td6">时间</div>
							</li>							
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>															
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div id="shareFrom" class="modal fade collection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">协同历史 来自他人</h4>
				</div>
				<div class="modal-body collection-body">
					<div class="collection-tit">
						<div class="search-zone">
							<input type="text" value="搜索文件" />
							<button></button>
						</div>
						<div class="collection-act">
							<a>查看作者</a>
							<a>查看全部类型</a>
						</div>
					</div>
					<div class="">
						<ul class="dis-list-type">
							<li class="tit">
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">名称</div>
								<div class="td3">作者</div>
								<div class="td4">位置</div>
								<div class="td5">大小</div>
								<div class="td6">时间</div>
							</li>							
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>															
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="shareTo" class="modal fade collection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">协同历史 发给他人</h4>
				</div>
				<div class="modal-body collection-body">
					<div class="collection-tit">
						<div class="search-zone">
							<input type="text" value="搜索文件" />
							<button></button>
						</div>
						<div class="collection-act">
							<a>查看作者</a>
							<a>查看全部类型</a>
						</div>
					</div>
					<div class="">
						<ul class="dis-list-type">
							<li class="tit">
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">名称</div>
								<div class="td3">作者</div>
								<div class="td4">位置</div>
								<div class="td5">大小</div>
								<div class="td6">时间</div>
							</li>							
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>															
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="shareGroup" class="modal fade collection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">协同历史 小组</h4>
				</div>
				<div class="modal-body collection-body">
					<div class="collection-tit">
						<div class="search-zone">
							<input type="text" value="搜索文件" />
							<button></button>
						</div>
						<div class="collection-act">
							<a>查看作者</a>
							<a>查看全部类型</a>
						</div>
					</div>
					<div class="">
						<ul class="dis-list-type">
							<li class="tit">
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">名称</div>
								<div class="td3">作者</div>
								<div class="td4">位置</div>
								<div class="td5">大小</div>
								<div class="td6">时间</div>
							</li>							
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>															
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="shareDev" class="modal fade collection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">协同历史 部门</h4>
				</div>
				<div class="modal-body collection-body">
					<div class="collection-tit">
						<div class="search-zone">
							<input type="text" value="搜索文件" />
							<button></button>
						</div>
						<div class="collection-act">
							<a>查看作者</a>
							<a>查看全部类型</a>
						</div>
					</div>
					<div class="">
						<ul class="dis-list-type">
							<li class="tit">
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">名称</div>
								<div class="td3">作者</div>
								<div class="td4">位置</div>
								<div class="td5">大小</div>
								<div class="td6">时间</div>
							</li>							
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>															
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="shareSchool" class="modal fade collection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">协同历史 学校</h4>
				</div>
				<div class="modal-body collection-body">
					<div class="collection-tit">
						<div class="search-zone">
							<input type="text" value="搜索文件" />
							<button></button>
						</div>
						<div class="collection-act">
							<a>查看作者</a>
							<a>查看全部类型</a>
						</div>
					</div>
					<div class="">
						<ul class="dis-list-type">
							<li class="tit">
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">名称</div>
								<div class="td3">作者</div>
								<div class="td4">位置</div>
								<div class="td5">大小</div>
								<div class="td6">时间</div>
							</li>							
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-share">分享</span>
											<span class="glyphicon glyphicon-save">下载</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>															
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div id="recycleBox" class="modal fade collection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">回收站</h4>
				</div>
				<div class="modal-body collection-body">
					<div class="collection-tit">
						<div class="search-zone">
							<input type="text" value="搜索文件" />
							<button></button>
						</div>
						<div class="collection-act">
							<a>查看作者</a>
							<a>查看全部类型</a>
						</div>
					</div>
					<div class="">
						<ul class="dis-list-type">
							<li class="tit">
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">名称</div>
								<div class="td3">作者</div>
								<div class="td4">位置</div>
								<div class="td5">大小</div>
								<div class="td6">时间</div>
							</li>							
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-retweet">恢复</span>
											<span class="glyphicon glyphicon-trash">彻底删除</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-retweet">恢复</span>
											<span class="glyphicon glyphicon-trash">彻底删除</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-retweet">恢复</span>
											<span class="glyphicon glyphicon-trash">彻底删除</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>
							<li>
								<div class="td1"><input type="checkbox" /></div>
								<div class="td2">
									<i class="fold"></i>
									<dl>
										<dt>接收礼包</dt>
										<dd>
											<span class="glyphicon glyphicon-retweet">恢复</span>
											<span class="glyphicon glyphicon-trash">彻底删除</span>
										</dd>
									</dl>
								</div>
								<div class="td3"></div>
								<div class="td4"></div>
								<div class="td5"> 34.5kb</div>
								<div class="td6"><span>2013-10-13 15:33</span> <i></i></div>
							</li>															
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/lib/jq.validate.js"></script>
	<script src="/js/lib/plupload.full.min.js"></script>
<!-- 	// <script type="text/javascript" src="/js/lib/moxie.js"></script>
	// <script type="text/javascript" src="/js/lib/plupload.dev.js"></script>	 -->
	<script src="/js/common.js"></script>
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