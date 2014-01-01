<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by IntelliJ IDEA.
 * User: joey
 * Date: 12/27/13
 * Time: 5:33 PM
 */


class SZMongo {

    protected $m;

    public function __construct($params)
    {
        $this->m = new MongoClient("mongodb://szone:t8ecnVj6RAVMcCF8@localhost/szone");
    }

    public function dump()
    {
        var_dump($this->m);
    }
}

/* End of file SZMongo.php */