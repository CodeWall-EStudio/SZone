<?php
/**
 * Created by IntelliJ IDEA.
 * User: code
 * Date: 11/21/13
 * Time: 14:47
 * To change this template use File | Settings | File Templates.
 */

/**
 * Create a Directory Map
 *
 * Reads the specified directory and builds an array
 * representation of it.  Sub-folders contained with the
 * directory will be mapped as well.
 *
 * @access	public
 * @param	string	path to source
 * @param	int		depth of directories to traverse (0 = fully recursive, 1 = current dir, etc)
 * @return	array
 */
if ( ! function_exists('format_size'))
{
    function format_size($size)
    {
        $prec = 3;
        $size = round(abs($size));
        $units = array(
            0 => " B ",
            1 => " KB",
            2 => " MB",
            3 => " GB",
            4 => " TB"
        );
        if ($size == 0)
        {
            return str_repeat(" ", $prec) . "0$units[0]";
        }
        $unit = min(4, floor(log($size) / log(2) / 10));
        $size = $size * pow(2, -10 * $unit);
        $digi = $prec - 1 - floor(log($size) / log(10));
        $size = round($size * pow(10, $digi)) * pow(10, -$digi);
        return $size . $units[$unit];
    }

}