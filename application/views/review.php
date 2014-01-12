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
      height:640px;
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
  		position:absolute;
  		top:640px;
  		width:1000px;
  		text-align : center;
  		margin:0 auto;
  	}
  	.file-reivew-act span{
  		display:inline-block;
  		width:24px;
  		height:24px;  		
  		cursor:pointer;
  	}
  	.flexpaper_viewer{
  		width:960px;height:700px;
  		padding-top:10px;
  		margin:0 auto;
  	}
  	.to-left{

  		background:url(/css/imgs/ll.png) no-repeat;
  	}
  	.to-right{

  		background:url(/css/imgs/rl.png) no-repeat; 		
  	}
  	.zoom-in{
 
  		background:url(/css/imgs/jjj.png) no-repeat; 				
  	}
  	.zoom-out{
  
  		background:url(/css/imgs/jj.png) no-repeat;
  	}  	
  </style>
  <script>
    
	function change(obj){
    if(obj.width >= obj.height){
      if(obj.width>640){
        obj.width= 640;
      }     
      obj.style.marginTop = (640-obj.height)/2+'px';
    }else{
      if(obj.height>640){
        obj.height= 640;
      }   
      obj.style.marginTop = (640-obj.width)/2+'px';
    }

	}    
  </script>  
</head>
<body>
	<div class="modal-body">
		<div class="file-review">
			<?if($finfo['type'] == 1):?>
				<img id="reviewImg" src="/download/media?id=<?=$finfo['fid']?>&gid=<?=$gid?><?if($m):?>&mid=<?=$id?><?endif?>" onload="change(this)" align="absmiddle" />
			<?elseif($finfo['type']==2):?>
				<div id="documentViewer" class="flexpaper_viewer">
					
				</div>
			<?elseif($finfo['type']==3):?>
				<div class="playerZone">
				  <video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="640" height="264"
				      poster="http://video-js.zencoder.com/oceans-clip.png"
				      data-setup="{}">
				    <source src="/download/media?id=<?=$finfo['fid']?>&gid=<?=$gid?><?if($m):?>&mid=<?=$id?><?endif?>" type='video/mp4' />
				    <source src="/download/media?id=<?=$finfo['fid']?>&gid=<?=$gid?><?if($m):?>&mid=<?=$id?><?endif?>" type='video/webm' />
				    <source src="/download/media?id=<?=$finfo['fid']?>&gid=<?=$gid?><?if($m):?>&mid=<?=$id?><?endif?>" type='video/ogg' />
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
		</div>
		<?if($finfo['type']==1):?>
		<div class="file-reivew-act">
			<dl>
				<dt>文件名:<?=$finfo['name']?></dt>
			</dl>
			<div>			
				<span class="to-left"></span>
				<span class="to-right"></span>
				<span class="zoom-out"></span>
				<span class="zoom-in"></span>
			</div>
		</div>
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
				angle: 0-(num-1)*90,
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
     <script type="text/javascript" src="/js/lib/flex/flexpaper_handlers_debug.js"></script>
    <script>
    $('#documentViewer').FlexPaperViewer(
            { config : {

                //SWFFile : encodeURIComponent('/download?id=<?=$finfo['fid']?>&rv=1'),
                SWFFile : encodeURIComponent('/download/review?id=<?=$finfo['fid']?>&rv=1&gid=<?=$gid?><?if($m):?>&mid=<?=$id?><?endif?>'),
                jsDirectory : '/js/lib/flex/',
                Scale : 0.8,
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
                localeChain: 'zh_CN'
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
