	<div id="header" class="header">
		<i class="logo"></i>
		<ul class="header-nav">
			<li class="selected"><a>我的工作室</a></li>
			<li>
				<a data-toggle="dropdown">小组空间<b class="caret"></b></a>
				<ul class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
					<li>上次进入的组</li>
					<li>教研组 <a>展开</a></li>
					<li>行政组 <a>展开</a></li>
					<li>自由小组 <a>展开</a></li>
					<li>归档的小组</li>
				</ul>
			</li>
			<li>
				<a data-toggle="dropdown">部门空间<b class="caret"></b></a>
				<ul class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
					<li>教育处</li>
					<li>教学处</li>
					<li>电教处</li>
					<li>办公室</li>
					<li>总务处</li>
					<li>食堂</li>					
				</ul>				
			</li>
			<li><a>学校空间</a></li>
		</ul>
		<div class="userinfo">
			<?php
				if(!$name){
			?>
			<a href="/login/connect">登录</a>
			<?}else{?>
			<a data-toggle="dropdown" id="username"><?=$name?><b class="caret"></b></a>
			<div class="dropdown-menu user-more-info" role="menu" aria-labelledby="username">
				<div class="user-head">
					<img src="css/imgs/file1.png" width="50" height="50">
				</div>
				<div class="user-zone">
					个人空间已用:　30%
					<div> 
						<div class="prog"></div>
						3.15G/30G
					</div>
				</div>
				<ul>
					<li><a>通知</a> <span>1</span></li>
					<li><a>统计</a></li>
					<li><a>个人设置</a></li>
					<li><a>退出登录</a></li>
				</ul>
			</div>
			<?php if($auth>0){?>
			<a href="/manage/">管理</a>
			<?php }?>
			<?}?>
		</div>
	</div>