<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<link rel="stylesheet" type="text/css" href="/css/main.css" />
</head>
<body>
	<?php  $this->load->view('public/header.php'); ?>	
	<div class="container">

		<div class="main-section">
			<div class="tool-zone">
				<div style="float:left;">
				<input type="file" class="upload-input" id="uploadFile" />
				<button class="upload">上传</button>

				<button>新建文件夹</button>
				</div>

				<div class="search-zone">
					<input type="text" value="搜索文件" />
					<button></button>
				</div>
			</div>

			<div class="section-tit">
				<div>个人文件</div>
				<ul class="act-zone">
					<li class="all-file file-type" id="changeFileType"><i></i><span>全部</span><i class="ar"></i></li>
					<li class="list-type" id="changeType"><i></i><span>图标</span></li>
				</ul>
				<ul class="file-types">
					<li class="all-file"><i></i>全部</li>
					<li class="col-file"><i></i>收藏</li>
					<li class="vod-file"><i></i>视频</li>
					<li class="pic-file"><i></i>图片</li>
					<li class="music-file"><i></i>音乐</li>
					<li class="doc-file"><i></i>文档</li>
					<li class="app-file"><i></i>应用</li>
					<li class="zip-file"><i></i>压缩包</li>
				</ul>
			</div>
			<!--dis-list-type -->
			<div id="fileList" class="dis-ico-type">
				<ulclass="cl">
					<li class="tit">
						<div class="td1"><input type="checkbox" /></div>
						<div class="td2"><span>文件夹(<b>4</b>个)</span>  名称 <i></i></div>
						<div class="td3">大小</div>
						<div class="td4">时间</div>
					</li>
					<li class="selected">
						<div class="td1"><input type="checkbox" /></div>
						<div class="td2">
							<i class="fold"></i>
							<dl>
								<dt>接收礼包</dt>
								<dd>
									<span><i class="share"></i>分享</span>
									<span><i class="down"></i>下载</span>
									<span><i class="more"></i>更多</span>
								</dd>
							</dl>
						</div>
						<div class="td3"> 34.5kb</div>
						<div class="td4"><span>2013-10-13 15:33</span> <i></i></div>
					</li>
					<li>
						<div class="td1"><input type="checkbox" /></div>
						<div class="td2">
							<i class="fold"></i>
							<dl>
								<dt>接收礼包</dt>
								<dd>
									<span><i class="share"></i>分享</span>
									<span><i class="down"></i>下载</span>
									<span><i class="more"></i>更多</span>
								</dd>
							</dl>
						</div>
						<div class="td3"> 34.5kb</div>
						<div class="td4"><span>2013-10-13 15:33</span> <i></i></div>
					</li>					
					<li>
						<div class="td1"><input type="checkbox" /></div>
						<div class="td2">
							<i class="gife"></i>
							<dl>
								<dt>接收礼包</dt>
								<dd>
									<span><i class="share"></i>分享</span>
									<span><i class="down"></i>下载</span>
									<span><i class="more"></i>更多</span>
								</dd>
							</dl>
						</div>
						<div class="td3"> 34.5kb</div>
						<div class="td4"><span>2013-10-13 15:33</span> <i></i></div>
					</li>	
					<li>
						<div class="td1"><input type="checkbox" /></div>
						<div class="td2">
							<i class="fold"></i>
							<dl>
								<dt>接收礼包</dt>
								<dd>
									<span><i class="share"></i>分享</span>
									<span><i class="down"></i>下载</span>
									<span><i class="more"></i>更多</span>
								</dd>
							</dl>
						</div>
						<div class="td3"> 34.5kb</div>
						<div class="td4"><span>2013-10-13</span> <i></i></div>
					</li>

					<li class="tit">
						<div class="td1"><input type="checkbox" /></div>
						<div class="td2"><span>文件(<b>4</b>个)</span>  </div>
					</li>	
					<li>
						<div class="td1"><input type="checkbox" /></div>
						<div class="td2">
							<img src="css/imgs/file.png" />
							<dl>
								<dt>接收礼包</dt>
								<dd>
									<span><i class="share"></i>分享</span>
									<span><i class="down"></i>下载</span>
									<span><i class="more"></i>更多</span>
								</dd>
							</dl>
						</div>
						<div class="td3"> 34.5kb</div>
						<div class="td4"><span>2013-10-13</span> <i></i></div>
					</li>
					<li class="last"></li>
				</ul>
			</div>
		</div>

		<div class="aside">
			<h3>个人文件</h3>
			<ul>
				<li>
					共享
					<p>我提供的共享</p>
					<p>提供给我的共享</p>
				</li>
				<li>
					收藏
				</li>
				<li>
					贡献
					<p>工作小组</p>
					<p>学校空间</p>
				</li>
				<li>
					收发
					<p>收件箱</p>
					<p>已发送的邮件</p>
				</li>
			</ul>
		</div>

		<div class="clear"></div>		
	</div>
	<div class="footer"></div>
	<script src="js/lib/jq.js"></script>
	<script src="js/common.js"></script>
	<script src="js/tips.js"></script>
	<script src="js/main.js"></script>
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