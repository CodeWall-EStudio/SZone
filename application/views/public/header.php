	<div id="header" class="header">
		<i class="logo"></i>
		<ul class="navbar-nav header-nav">
			<li class="nav selected">
				<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">我的工作室<b class="caret"></b></a>
				<ul class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
					<li><a href="/home?type=0">个人文件</a></li>
					<li><a href="/home?type=1">我的备课</a></li>
				</ul>				
			</li>
			<li class="nav">
				<a data-toggle="dropdown">小组空间<b class="caret"></b></a>
				<ul class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
					<? foreach($group as $item):?>
						<li>
							<a href="/group?id=<?=$item['id']?>"><?=$item['name']?></a>
							<?if($item['auth']):?>
								<span><a href="/manage/group?id=<?=$item['id']?>">管理</a></span>
							<?endif?>
							<?if(count($item['list'])>0):?>
								<ul>
								<?foreach($item['list'] as $row):?>
									<li>
										<a href="/group?id=<?=$row['id']?>"><?=$row['name']?></a>
										<?if($row['auth']):?>
											<span><a href="/manage/group?id=<?=$row['id']?>">管理</a></span>
										<?endif?>										
									</li>
								<?endforeach?>
								</ul>
							<?endif?>
						</li>
					<? endforeach?>
				</ul>
			</li>
			<li class="nav">
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
			<li class="nav"><a>学校空间</a></li>
		</ul>
		<div class="userinfo">
			<?if(!$userinfo['name']):?>
				<a href="/login/connect">登录</a>
			<?else:?>
				<a><?=$userinfo['name']?></a>
			<?if($userinfo['auth']>0):?>
				<a href="/manage/">管理</a>
			<?endif?>
			<?endif?>
		</div>
	</div>