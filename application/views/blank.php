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
	<?php  $this->load->view('public/blank_header.php'); ?>
	<div class="container">
		<div class="main-section">
			<div class="tool-zone fade-in">
				<div class="btn-zone"></div>

				<div class="search-zone">
					<form action="/" method="post" accept-charset="utf-8">
					<input type="text" name="key" value="搜索文件" />
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
					<li><a>下载</a></li>
					<li><a cmd="coll" id="collFiles">收藏</a></li>
					<li id="renameAct"><a cmd="rename" data-toggle="modal" data-target="#renameFile">重命名</a></li>
					<li><a cmd="copyFile" data-toggle="modal" data-target="#shareWin">复制</a></li>
					<li><a cmd="delFile" data-toggle="modal" data-target="#delFile">删除</a></li>
					<!-- <li id="remarkAct"><a cmd="remark" data-toggle="modal" data-target="#commentFile">评论</a></li> -->
				</ul>
			</div>

			<div class="section-tit">
				<div class="dropdown">
					<a data-toggle="dropdown" class="section-tit-a-first section-tit-a-border">树</a>
					<ul class="dropdown-menu section-tit-menu" role="menu" aria-labelledby="dLabel" id="myFileList">

					</ul>					
					<a class="section-tit-a-first" href="/home">个人文件</a>
				</div>
				<ul class="act-zone">
					<li class="all-file file-type dropdown" id="changeFileType">
						<a role="button" data-toggle="dropdown" href="#">
						<b class="caret"></b></a>
						<ul class="dropdown-menu section-tit-menu1" role="menu" aria-labelledby="dLabel">
							<li><a data-type="0" href="/?type=0">全部</a></li>
							<li><a data-type="2">收藏</a></li>
							<li><a data-type="3" href="/?type=4">视频</a></li>
							<li><a data-type="1" href="/?type=1">图片</a></li>
							<li><a data-type="4" href="/?type=3">音乐</a></li>
							<li><a data-type="5" href="/?type=2">文档</a></li>
							<li><a data-type="6" href="/?type=5">应用</a></li>
							<li><a data-type="7" href="/?type=6">压缩包</a></li>
						</ul>						
					</li>
					<!--<li class="list-type" id="changeType"><i></i><span>图标</span></li>-->
				</ul>

			</div>
			<!--dis-list-type -->
			<div id="fileList" class="dis-list-type">
				<ulclass="cl">
					<li class="last"></li>
				</ul>
			</div>
			<div class="page-zone">

			</div>
		</div>
		<div class="aside">
			<h3 class="selected">个人文件</h3>
			<ul>
				<li>
					<a>通知</a>
				</li>
				<li id="shareHis">
					共享历史
					<p>
						<a cmd="get" data-toggle="modal" data-target="#mailbox">收件箱</a> 
					</p>
					<P>
						<a cmd="send" data-toggle="modal" data-target="#mailbox">发件箱</a>
					</p>						
					<p>					
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
					<input type="hidden" class="foldid" value="" />
					<div id="file_uploadList"></div>
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
						<img  />
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
				<form class="new-fold" id="reName" method="post">
				<div class="modal-body">
					<label>文件名称：</label><input class="foldname" name="fname" type="text" style="width:80%" />
					<input type="hidden" class="fid" />
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
						
							<label>文件夹名称：</label><input id="foldname" name="foldname" type="text" style="width:80%" />
							<input type="hidden" class="parentid" name="parentid" value="" />
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<input type="submit" class="btn btn-primary btn-new-fold" value="确定" />
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