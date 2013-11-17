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