<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="author" content="Tencent" />
  <title>教师工作室</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="/css/player/video-js.min.css" />
  <style>
  	.file-review{
  		text-align:center;
  	}
  	.playerZone{
  		margin:10px auto;
  		width:640px;
  	}
  	.text{
  		width:640px;
  		margin:0 auto;
  		text-align:left;
  	}
  	dl{
  		padding: 10px;
  		width:500px;
  		margin:0 auto;
  		text-align:left;
  	}
  </style>
  <script>
    
	function change(obj){
		if(obj.width>640){
			obj.width= 640;
		}
	}    
  </script>  
</head>
<body>
	<div class="modal-body">
		<div class="file-review">
			<?if($finfo['type'] == 1):?>
				<img id="reviewImg" src="/cgi/getfile?fid=<?=$finfo['fid']?>" onload="change(this)" />
			<?elseif($finfo['type']==2):?>
				<?if(isset($finfo['text'])):?>
					<p class="text"><?=$finfo['text']?></p>
				<?else:?>
				 	其他文本
				 	
				<?endif?>
			<?elseif($finfo['type']==3):?>
				<div class="playerZone">
				  <video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="640" height="264"
				      poster="http://video-js.zencoder.com/oceans-clip.png"
				      data-setup="{}">
				    <source src="/cgi/getfile?fid=<?=$finfo['fid']?>" type='video/mp4' />
				    <source src="/cgi/getfile?fid=<?=$finfo['fid']?>" type='video/webm' />
				    <source src="/cgi/getfile?fid=<?=$finfo['fid']?>" type='video/ogg' />
				    <track kind="captions" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
				    <track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
				  </video>
				</div>
			<?elseif($finfo['type']==4):?>

			<?elseif($finfo['type']==5):?>
				可执行文件
			<?elseif($finfo['type']==6):?>
				压缩文件
			<?endif?>
			<dl>
				<dt>文件名:<?=$finfo['name']?></dt>
				<dd>说明：<?=$finfo['content']?></dd>
			</dl>
		</div>
		<div class="file-reivew-act">
			<span class="glyphicon glyphicon-repeat rotate"></span>
			<span class="glyphicon glyphicon-repeat"></span>
			<span class="glyphicon glyphicon-zoom-in"></span>
			<span class="glyphicon glyphicon-zoom-out"></span>
		</div>
		  <a class="left carousel-control" href="/review?fid=<?=$finfo['fid']?>&t=1&gid=<?=$gid?>&id=<?=$id?>" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left"></span>
		  </a>
		  <a class="right carousel-control" href="/review?fid=<?=$finfo['fid']?>&t=2&gid=<?=$gid?>&id=<?=$id?>" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right"></span>
		  </a>					
	</div>	
<?if($finfo['type']==3):?>
<script type="text/javascript" src="/js/player/video.js" charset="utf-8"></script>
<script type="text/javascript">
	videojs.options.flash.swf = "video-js.swf";
//		f:'http://szone.codewalle.com/cgi/getfile?fid=<?=$finfo->fid?>',
</script>
<?endif?>
</body>
</html>