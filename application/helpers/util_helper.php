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