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
  	.file-reivew-act{
  		width:300px;
  		text-align : center;
  		margin:0 auto;
  	}
  	.file-reivew-act span{
  		border:1px solid #000;
  		cursor:pointer;
  	}
  	.flexpaper_viewer{
  		width:500px;
  		margin:0 auto;
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
				<div id="documentViewer" class="flexpaper_viewer" style="width:770px;height:500px">
					
				</div>
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
		<?if($finfo['type']==1):?>
		<div class="file-reivew-act">
			<span class="glyphicon glyphicon-repeat rotate to-left"></span>
			<span class="glyphicon glyphicon-repeat to-right"></span>
			<span class="glyphicon glyphicon-zoom-in zoom-in"></span>
			<span class="glyphicon glyphicon-zoom-out zoom-out"></span>
		</div>
		<?endif?>
		<?if($prev):?>
		  <a class="left carousel-control" href="/review?fid=<?=$prev?>&gid=<?=$gid?>&id=<?=$id?>" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left"></span>
		  </a>
		<?endif?>
		<?if($next):?>
		  <a class="right carousel-control" href="/review?fid=<?=$next?>&t=2&gid=<?=$gid?>&id=<?=$id?>" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right"></span>
		  </a>	
		<?endif?>				
	</div>	
<?if($finfo['type']==1):?>
	<script type="text/javascript" src="/js/lib/jq.js" charset="utf-8"></script>	
	<script type="text/javascript" src="/js/lib/jq.rotate.js" charset="utf-8"></script>	
	<script>
		var num = 0;
		$('.to-left').bind('click',function(){
			num++;
			$('#reviewImg').rotate({                          
						angle: (num-1)*90,
	                    animateTo: num*90,
					});
		});
		$('.to-right').bind('click',function(){
			num--;
			$('#reviewImg').rotate({
				angle: 0-(num+1)*90,
	            animateTo: 0-num*90,
			});
		});	
		$('.zoom-in').bind('click',function(){
			$('#reviewImg').css('width',function(i,v){
				var nv = parseInt(v,10);
				return nv*0.8;
			});	
		});
		$('.zoom-out').bind('click',function(){
			$('#reviewImg').css('width',function(i,v){
				var nv = parseInt(v,10);
				return nv*1.2;
			});	
		});	
	</script>
<?endif?>
<?if($finfo['type']==2):?>
    <script type="text/javascript" src="/js/lib/jq.js" charset="utf-8"></script>	
    <script type="text/javascript" src="/js/lib/flex/flexpaper.js"></script>
    <script type="text/javascript" src="/js/lib/flex/flexpaper_handlers.js"></script>
    <script>
    $('#documentViewer').FlexPaperViewer(
            { config : {

                SWFFile : encodeURIComponent('/download?id=<?=$finfo['fid']?>&rv=1'),
                //SWFFile : '/cgi/downfile_test?fid=<?=$finfo['fid']?>&rv=1',
                jsDirectory : '/js/lib/flex/',
                Scale : 0.6,
                ZoomTransition : 'easeOut',
                ZoomTime : 0.5,
                ZoomInterval : 0.2,
                FitPageOnLoad : true,
                FitWidthOnLoad : false,
                FullScreenAsMaxWindow : false,
                ProgressiveLoading : false,
                MinZoomSize : 0.2,
                MaxZoomSize : 5,
                SearchMatchAll : false,
                InitViewMode : 'Portrait',
                RenderingOrder : 'flash',
                StartAtPage : '',

                ViewModeToolsVisible : true,
                ZoomToolsVisible : true,
                NavToolsVisible : true,
                CursorToolsVisible : true,
                SearchToolsVisible : true,
                WMode : 'window',
                localeChain: 'en_US'
            }}
    );
    </script>
<?endif?>
<?if($finfo['type']==3):?>
	<script type="text/javascript" src="/js/player/video.js" charset="utf-8"></script>
	<script type="text/javascript">
		videojs.options.flash.swf = "video-js.swf";
	</script>
<?endif?>
</body>
</html>