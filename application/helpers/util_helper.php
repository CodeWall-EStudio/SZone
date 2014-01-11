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
		$ret = '其他';
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
			case 7:
				$ret = '其它';
				break;
		}
		return $ret;
	}
}

if(! function_exists('abslength')){
	function abslength($str)
	{
	    if(empty($str)){
	        return 0;
	    }
	    if(function_exists('mb_strlen')){
	        return mb_strlen($str,'utf-8');
	    }
	    else {
	        preg_match_all("/./u", $str, $ar);
	        return count($ar[0]);
	    }
	}
}

if(! function_exists('utf8_substr')){
	function utf8_substr($str,$start=0) {
	    if(empty($str)){
	        return false;
	    }
	    if (function_exists('mb_substr')){
	        if(func_num_args() >= 3) {
	            $end = func_get_arg(2);
	            return mb_substr($str,$start,$end,'utf-8');
	        }
	        else {
	            mb_internal_encoding("UTF-8");
	            return mb_substr($str,$start);
	        }       	 
	    }
	    else {
	        $null = "";
	        preg_match_all("/./u", $str, $ar);
	        if(func_num_args() >= 3) {
	            $end = func_get_arg(2);
	            return join($null, array_slice($ar[0],$start,$end));
	        }
	        else {
	            return join($null, array_slice($ar[0],$start));
	        }
	    }
	}
}

if(! function_exists('csubstr')){
	function csubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)   
	{  
	   if(function_exists("mb_substr"))  
	   {  
	       if(mb_strlen($str, $charset) <= $length) return $str;  
	       $slice = mb_substr($str, $start, $length, $charset);  
	   }  
	   else
	   {  
	       $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";  
	       $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";  
	       $re['gbk']          = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";  
	       $re['big5']          = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";  
	       preg_match_all($re[$charset], $str, $match);  
	       if(count($match[0]) <= $length) return $str;  
	       $slice = join("",array_slice($match[0], $start, $length));  
	   }  
	   if($suffix) return $slice."…";  
	   return $slice;  
	} 
}

if(! function_exists('sub_string_length')){
	function sub_string_length($str,$len){
		if(abslength($str)>$len){
			return utf8_substr($str,0,$len).'...';
		}else{
			return $str;
		}
	}
}

if(! function_exists('cr_file_type_li')){
	function cr_file_type_li($url){
		echo '<li><a data-type="0" href="'.$url.'&type=0">全部</a></li>';
		echo '<li><a data-type="1" href="'.$url.'&type=1">图片</a></li>';
		echo '<li><a data-type="2" href="'.$url.'&type=2">文档</a></li>';
		echo '<li><a data-type="3" href="'.$url.'&type=3">音乐</a></li>';
		echo '<li><a data-type="4" href="'.$url.'&type=4">视频</a></li>';
		echo '<li><a data-type="5" href="'.$url.'&type=5">应用</a></li>';
		echo '<li><a data-type="6" href="'.$url.'&type=6">压缩包</a></li>';
		echo '<li><a data-type="7" href="'.$url.'&type=7">其它</a></li>';		
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
