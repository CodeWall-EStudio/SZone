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
    function directory_acquire($upload_dir, $md5, $limit, &$error)
    {
        if(!is_dir($upload_dir))
        {
            if(!mkdir($upload_dir,DIR_WRITE_MODE))
            {
                $error = 'upload_not_writable';
                return FALSE;
            };
        }
        /*$upload_dir .= substr($md5, 0, 2).'/';
        if(!is_dir($upload_dir))
        {
            if(!mkdir($upload_dir,DIR_WRITE_MODE))
            {
                $error = 'upload_not_writable';
                return FALSE;
            };
        }*/
        $file_data = directory_map($upload_dir);
        var_dump($file_data);
        return FALSE;
        $file_count = count($file_data);
        if ($file_count == 0)
        {
            $upload_dir .= '1d/';
            if(!mkdir($upload_dir,DIR_WRITE_MODE))
            {
                $error = 'upload_not_writable';
                return FALSE;
            };
            return $upload_dir;
        }
        else
        {
            for ($i = 1; $i <= $file_count; $i++)
            {
                $tmp_dir = $upload_dir . $i . 'd/';
                if(!is_dir($tmp_dir))
                {
                    $error = 'upload_not_fixable';
                    return FALSE;
                }
                $tmp_count = count($file_data[$i . 'd/']);
                if ($tmp_count < $limit)
                {
                    return $tmp_dir;
                }
            }

            if ($file_count >= $limit)
            {
                $error = 'upload_dir_exceeds_limit';
                return FALSE;
            }

            $file_count = $file_count + 1;
            $upload_dir .= $file_count . 'd/';
            if(!mkdir($upload_dir,DIR_WRITE_MODE))
            {
                $error = 'upload_not_writable';
                return FALSE;
            };
            return $upload_dir;

        }

        return FALSE;
    }
}

if ( ! function_exists('directory_check'))
{
    function directory_check($upload_dir, $md5, &$error)
    {
        if(!is_dir($upload_dir))
        {
            if(!mkdir($upload_dir, DIR_WRITE_MODE))
            {
                $error = 'upload_not_writable';
                return FALSE;
            };
            chmod($upload_dir,DIR_WRITE_MODE);
        }

        //echo implode('|',$allowed);
        $dirname = $upload_dir.substr($md5,0,2).'/';
        if (!is_dir($dirname)){
            if(!mkdir($dirname, DIR_WRITE_MODE))
            {
                $error = 'upload_not_writable';
                return FALSE;
            };
            chmod($dirname,DIR_WRITE_MODE);
        }

        $dirname = $dirname.substr($md5,2,2).'/';
        if (!is_dir($dirname)){
            if(!mkdir($dirname, DIR_WRITE_MODE))
            {
                $error = 'upload_not_writable';
                return FALSE;
            };
            chmod($dirname,DIR_WRITE_MODE);
        }

        return $dirname;
    }
}