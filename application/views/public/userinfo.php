		<div class="userinfo">
			<?
				$used = $nav['userinfo']['used'];
				$size = $nav['userinfo']['size'];
				$pre = $nav['userinfo']['per'];
			?>
			<div>个人空间已用 <?=$pre?>%</div>
			<div class="user-zone"> 
				<div class="prog" style="width:<?=$pre?>%"></div><?=$used?>/<?=$size?>
			</div>			
			<div><a href="/logout">退出登录</a></div>
		</div>