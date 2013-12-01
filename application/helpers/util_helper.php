<?
if ( ! function_exists('get_file_size')){
	function get_file_size($size){
		if($size > 1000000){
			$size = round($used/1000000,2);
			$size .='GB';
		}elseif($size>1000){
			$size = round($size/1000,2);
			$size .='MB';
		}else{
			$size = (int) $size.'kb';
		}
		return $size;
	}
}

if ( ! function_exists('get_file_type')){
	function get_file_type($type){
		switch($type){
			case 1:
				return '图片';
			case 2:
				return '文档';
			case 3:
				return '音乐';
			case 4:
				return '视频';
			case 5:
				return '应用';
			case 6:
				return '压缩包';
		}
		return '未知类型';
	}
}

if(! function_exists('get_page_status')){
	function get_page_status($np,$n,$al){
		$page = array(
			'prev' => 0,
			'next' => 0,
			'prevnum' => 0,
			'nextnum' => 0,
			'start' => $np*$n,
			'end' => ($np+1)*$n
		);
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
		$ret;
		switch($item['type']){
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
	}
}


if(! function_exists('create_page')){
	function create_page($config){
		if($config['prev']){
			echo '<a href="'.$config['url'].'page='.$config['prevnum'].'">上一页</a>';
		}
		if($config['next']){
			echo '<a href="'.$config['url'].'page='.$config['nextnum'].'">下一页</a>';
		}
	}
}