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
if ( ! function_exists('directory_acquire'))
{
    function directory_acquire($source_dir, $limit = 0)
    {
        if ($fp = @opendir($source_dir))
        {
            $filedata = directory_map($source_dir);
            var_dump(count($filedata));
            return $filedata;
        }

        return FALSE;
    }
}