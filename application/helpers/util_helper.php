<?php

if(! function_exists('get_page_status')){
	function get_page_status($np,$n,$al){
		$page = array(
			'prev' => 0,
			'next' => 0,
			'prevnum' => 0,
			'nextnum' => 0,
			'now' => $np,
			'start' => $np*$n,
			'end' => ($np+1)*$n
		);
		$page['all'] = ceil($al/$n);
		if($np>0){
			$page['prev'] = 1;
			$page['prevnum'] = $np-1>0?$np-1:0;
		}
		if($page['end'] < $al){
			$page['next'] = 1;
			$page['nextnum'] = $np+1;
		}else{
			$page['next'] = 0;
			$page['end'] = $al;
		}
		return $page;
		
	}
}

if(! function_exists('get_file_type')){
	function get_file_type($type){
		$ret = '未知类型';
		switch($type){
			case 0:
				$ret = '全部类型';
				break;
			case 1:
				$ret = '图片';
				break;
			case 2:
				$ret = '文档';
				break;
			case 3:
				$ret = '音乐';
				break;
			case 4:
				$ret = '视频';
				break;
			case 5:
				$ret = '应用';
				break;
			case 6:
				$ret = '压缩包';
				break;
		}
		return $ret;
	}
}


if(! function_exists('create_page')){
	function create_page($config){
		if($config['prev']){
			echo '<a href="'.$config['url'].'page='.$config['prevnum'].'">上一页</a>';
		}
		for($i = 0;$i<$config['all'];$i++){
			if($config['now'] == $i){
				echo '<a class="page-select" href="'.$config['url'].'page='.$i.'">'.($i+1).'</a>';
			}else{
				echo '<a href="'.$config['url'].'page='.$i.'">'.($i+1).'</a>';
			}
		}
		if($config['next']){
			echo '<a href="'.$config['url'].'page='.$config['nextnum'].'">下一页</a>';
		}
	}
}

if(! function_exists('sort_folds')){
	function sort_folds($data){
		
	}
}
