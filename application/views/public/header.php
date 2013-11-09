	<div id="header" class="header">
		<i class="logo"></i>
		<ul class="navbar-nav header-nav">
			<li class="selected">
				<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">我的工作室<b class="caret"></b></a>
				<ul class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
					<li><a href="/home?type=0">个人文件</a></li>
					<li><a href="/home?type=1">我的备课</a></li>
				</ul>				
			</li>
			<li>
				<a data-toggle="dropdown">小组空间<b class="caret"></b></a>
				<ul class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
					<? foreach($group as $item):?>
						<li><a href="/group?id=<?=$item['id']?>"><?=$item['name']?></a></li>
					<? endforeach?>
				</ul>
			</li>
			<li>
				<a data-toggle="dropdown">部门空间<b class="caret"></b></a>
				<ul class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
					<? foreach($dep as $item):?>
						<li><a href="/group?id=<?=$item['id']?>"><?=$item['name']?></a></li>
					<? endforeach?>					
<!-- 					<li>教育处</li>
					<li>教学处</li>
					<li>电教处</li>
					<li>办公室</li>
					<li>总务处</li>
					<li>食堂</li> -->					
				</ul>				
			</li>
			<li><a>学校空间</a></li>
		</ul>
		<div class="userinfo">
			<?php
				if(!$userinfo['name']):
			?>
				<a href="/login/connect">登录</a>
			<?else:?>
				<a><?=$userinfo['name']?></a>
			<?endif?>
		</div>
	</div>