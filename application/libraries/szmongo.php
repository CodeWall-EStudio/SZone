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
        if (empty($this->m)) {
            $this->m = new MongoClient($params['db']);
            $this->m = $this->m->szone;
        }
    }

    public function dump()
    {
        var_dump($this->m);
    }

    public function user_add($user)
    {

    }
}

/* End of file SZMongo.php */