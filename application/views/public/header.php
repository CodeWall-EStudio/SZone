	<div id="header" class="header">
		<i class="logo"></i>
		<ul class="navbar-nav header-nav">
			<li class="nav selected">
				<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">我的工作室<b class="caret"></b></a>
				<ul class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
					<li><a href="/home?type=0">个人文件</a></li>
					<li><a href="/home/prepare">我的备课</a></li>
				</ul>				
			</li>
			<li class="nav">
				<a data-toggle="dropdown">小组空间<b class="caret"></b></a>
				<ul class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
					<? foreach($group as $item):?>
						<?if(!isset($item['type'])):?>
						<li>
							<a href="/group?id=<?=$item['id']?>"><?=htmlspecialchars($item['name'])?></a>
							<?if($item['auth']):?>
								<span><a data-toggle="modal" data-id="<?=$item['id']?>" cmd="manage" data-target="#manageWin">管理</a></span>
							<?endif?>
							<?if(count($item['list'])>0):?>
								<ul class="head-second">
								<?foreach($item['list'] as $row):?>
									<li>
										<a href="/group?id=<?=$row['id']?>" title="<?=htmlspecialchars($row['name'])?>"><?=htmlspecialchars($row['name'])?></a>
										<?if($row['auth']):?>
											<span><a data-toggle="modal" data-id="<?=$row['id']?>" cmd="manage" data-target="#manageWin">管理</a></span>
										<?endif?>										
									</li>
								<?endforeach?>
								</ul>
							<?endif?>
						</li>
						<?endif?>
					<? endforeach?>
					<li><a id="createNewGroup" data-toggle="modal" cmd="newgroup" data-target="#manageWin">申请新的小组</a></li>
				</ul>
			</li>
			<li class="nav">
				<a data-toggle="dropdown">部门空间<b class="caret"></b></a>
				<ul class="dropdown-menu menu" role="menu" aria-labelledby="dLabel">
					<? foreach($dep as $item):?>
						<li><a href="/group?id=<?=$item['id']?>"><?=htmlspecialchars($item['name'])?></a></li>
					<? endforeach?>					
<!-- 					<li>教育处</li>
					<li>教学处</li>
					<li>电教处</li>
					<li>办公室</li>
					<li>总务处</li>
					<li>食堂</li> -->					
				</ul>				
			</li>
			<?if(isset($school)):?>
			<li class="nav"><a href="/school">学校空间</a></li>
			<?endif?>
		</ul>
		<div class="userinfo">
			<?if(!$userinfo['name']):?>
				<a href="/login/connect">登录</a>
			<?else:?>
				<a><?=htmlspecialchars($userinfo['nick'])?></a>
			<?if($userinfo['auth']>0):?>
				<a href="/manage/">管理</a>
			<?endif?>
			<?endif?>
		</div>
	</div>