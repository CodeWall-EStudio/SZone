	<div id="header" class="header">
		<i class="logo"></i>
		<div class="userinfo" style="width:240px">
			<?if(!$userinfo['name']):?>
				<a href="/login/connect">登录</a>
			<?else:?>
				<a><?=htmlspecialchars($userinfo['nick'])?></a>
			<?if($userinfo['auth']>0):?>
				<a href="/manage/">管理</a>
				<a href="/">退出管理</a>
			<?endif?>
			<?endif?>
		</div>
	</div>