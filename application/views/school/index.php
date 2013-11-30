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
<!-- 					<input type="file" class="upload-input" id="uploadFile" />  data-toggle="modal" data-target="#uploadFile"-->
					<button class="upload btn btn-primary btn-upload" disabled="disabled">上传</button>
					<button class="btn btn-default" data-toggle="modal" data-target="#newFold" disabled="disabled">新建文件夹</button>
				</div>

				<div class="search-zone">
					<form action="/" method="post" accept-charset="utf-8">
					<input type="text" name="key" value="搜索文件" />
					<button type="submit"></button>
					</form>
				</div>
			</div>


			<div class="file-act-zone fade-in">
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
			<div id="fileList" class="dis-list-type">
				<ul class="cl">
					<li class="tit file-list">
						<div class="td1"><input type="checkbox" id="selectAllFile" /></div>
						<div class="td2"><span>文件(<b><?=$allnum?></b>个)</span>  </div>
						<div class="td_review">审核</div>
						<div class="td_uname">作者</div>
						<div class="td_type">来源</div>
						<div class="td_size">大小</div>
						<div class="td_size">类型</div>
						
						<div class="td_time">时间</div>								
					</li>	
					<?foreach($flist as $item):?>
						<li class="file" data-id="<?=$item['id']?>">
							<div class="td1"><input type="checkbox" name="file" class="fclick" value="<?=$item['id']?>" data-type="file" /></div>
							<div class="td2">
								<a class="file-name" data-fid="<?=$item['fid']?>" data-id="<?=$item['id']?>">
								<?if($item['type'] == 1):?>
									<img src="/cgi/getfile?fid=<?=$item['fid']?>" data-fid="<?=$item['fid']?>"  data-id="<?=$item['id']?>"/>
								<?else:?>
									<i class="fold" data-fid="<?=$item['fid']?>" data-id="<?=$item['id']?>" ></i>
								<?endif?>
								</a>
								<dl>
									<dt><?=$item['fname']?> 
										<span cmd="edit" data-id="<?=$item['id']?>"><?=$item['content']?></span>
										<span class="hide">
											<input class="name-edit" type="text" value="<?=$item['content']?>" />
											<i class="edit-comp" cmd="editComp" data-type="file" data-id="<?=$item['id']?>"></i>
											<i class="edit-close" data-value="<?=$item['content']?>" cmd="editClose"></i>
										</span>
									</dt>
									<dd>
										<span><a data-toggle="dropdown" href="#">共享</a>
										</span>										
										<span><a href="/cgi/downfile?fid=<?=$item['fid']?>">下载</a></span>
									</dd>
								</dl>
							</div>
							<div class="td_mark">
								<p>通过</p>
								<p>不通过</p>
							</div>
							<div class="td_uname"><?=$item['uname']?></div>
							<div class="td_source">
								<?if($item['status']):?>
									分享
								<?else:?>
									上传
								<?endif?>
							</div>	
							<div class="td_size"><?=$item['size']?></div>
							<div class="td_type"><?=get_file_type($item['type'])?></div>
							<div class="td_time"><?=date('Y-m-d',$item['time'])?></div>
															
						</li>		

					<?endforeach?>
				</ul>
			</div>
			<div class="page-zone">
				<?
					$page['url'] = '/school?type='.$type.'&key='.$key.'&';
					create_page($page);
				?>
			</div>			
		</div>

		<div class="aside">
			<h3>审核 (<span><?=$nreg?></span>)</h3>
		</div>


	</div>


	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/lib/jq.validate.js"></script>

	<script src="/js/common.js"></script>

</body>
</html>