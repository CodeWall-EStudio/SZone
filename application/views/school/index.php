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
				<div class="search-zone">
					<form action="/" method="post" accept-charset="utf-8">
					<input type="text" name="key" value="搜索文件" />
					<button type="submit"></button>
					</form>
				</div>
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
						<div class="td_type">类型</div>
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
										<span><a href="/download?id=<?=$item['fid']?>">下载</a></span>
									</dd>
								</dl>
							</div>
							<div class="td_review">
								<?if($item['ttime']):?>
									<p>已审核</p>
								<?else:?>
									<p id="review<?=$item['id']?>"><a cmd="pass" data-id="<?=$item['id']?>">通过</a> <a cmd="notpass"  data-id="<?=$item['id']?>">不通过</a></p>
									<p id="reviewStatus<?=$item['id']?>">未审核</p>
								<?endif?>
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
			<h3><a href="/school/history">审核历史</a></h3>
		</div>


	</div>


	<div id="reviewFile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">审核文件</h4>
				</div>
				<div class="modal-body">
					<label>退回申请附言:</label><input class="review-text" name="fname" type="text" style="width:80%" />
					<input type="hidden" class="id" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					<button type="submit" class="btn btn-primary" id="reviewFileBtn">确定</button>
				</div>
			</div>
		</div>
	</div>

	<script src="/js/lib/jq.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/lib/jquery.ui.min.js"></script>
	<script src="/js/lib/jq.validate.js"></script>

	<script src="/js/common.js"></script>
	<script src="/js/school.js"></script>

</body>
</html>