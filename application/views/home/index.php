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
	<div class="container">
		<div class="main-section">
			<div class="tool-zone fade-in">
				<div class="btn-zone">
					<button class="upload btn btn-primary btn-upload" <?if(!$nav['userinfo']['uid']):?>disabled="disabled"<?endif?>>上传</button>
					<button class="btn btn-default" data-toggle="modal" data-target="#newFold" <?if(!$nav['userinfo']['uid']):?>disabled="disabled"<?endif?>>新建文件夹</button>
				</div>

				<div class="search-zone">
					<form action="/" method="post" accept-charset="utf-8">
					<input type="text" name="key" value="搜索文件" />
					<button type="submit"></button>
					</form>
				</div>
			</div>
			<div class="file-act-zone fade-in hide">
				<ul class="nav nav-pills">
					<li class="share-act">
						<a data-toggle="dropdown">共享<span class="caret"></span></a>
						<ul id="actDropDown" class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
							<li><a data-toggle="modal" cmd="toother" data-click-share-other data-target="#shareWin">发送给别人</a></li>
							<li><a data-toggle="modal" cmd="togroup" data-click-share-group data-target="#shareWin">发送到小组</a></li>
							<li><a data-toggle="modal" cmd="todep"  data-click-share-dep data-target="#shareWin">提交到部门</a></li>				
						</ul>						
					</li>
					<li class="down-act"><a cmd="downfile" data-click-downfile id="donwFiles">下载</a></li>
					<li class="coll-act"><a cmd="coll" data-click-coll id="collFiles">收藏</a></li>
					<li class="rename-act"><a cmd="rename" data-click-rename data-toggle="modal" data-target="#renameFile">重命名</a></li>
					<li class="copy-act"><a cmd="copyFile" data-click-copy data-toggle="modal" data-target="#shareWin">复制</a></li>
					<li class="del-act"><a cmd="delFile" data-click-del data-toggle="modal" data-target="#delFile">删除</a></li>
				</ul>
			</div>

			<div class="section-tit" id="sectionTit">

			</div>
			<!--dis-list-type -->
			<div id="fileList" class="dis-list-type">
				<ul class="cl">
					<li class="last"></li>
				</ul>
			</div>
			<div class="page-zone">

			</div>
		</div>
		<div class="aside">
			<h3>备课成果</h3>
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
		<?if($nav['userinfo']['uid']):?>
			<?  $this->load->view('public/userinfo.php',$nav['userinfo']); ?>
		<?endif?>
		<div class="clear"></div>		
	</div>	
	<div class="footer"></div>
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

<div id="reviewFile" class="modal fade collection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">预览文件</h4>
			</div>
			<div class="modal-body">
				<iframe id="reviewIframe" width="750" height="640" border="0" frameborder="0" scroll="false" ></iframe>
			</div>
		</div>
	</div>
</div>

<div id="fileWin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<script type="text/javascript" src="/js/lib/jquery/jquery-1.9.1.min.js"></script>
<script src="/js/common.js"></script>
<script src="/js/bootstrap.min.js"></script>
<!--
<script src="/js/lib/jquery.ui.min.js"></script>
<script src="/js/lib/jq.validate.js"></script>
-->
<script type="text/javascript" src="/js/lib/moxie.js"></script>
<script type="text/javascript" src="/js/lib/plupload.dev.js"></script>
<script src="/js/lib/jquery.plupload.queue.js"></script>

<script data-main="/js/school/homemain.js" src="/js/lib/require/require.2.1.9.js"></script>
<!-- <script src="/js/lib/plupload.full.min.js"></script> -->



<!--
<script src="/js/common.js"></script>
<script src="/js/upload.js"></script>
<script src="/js/home.js"></script>
-->

<?php  $this->load->view('public/footer.php'); ?>