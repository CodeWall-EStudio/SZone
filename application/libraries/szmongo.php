<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by IntelliJ IDEA.
 * User: joey
 * Date: 12/27/13
 * Time: 5:33 PM
 */


class SZMongo {

    protected $params;

    public function __construct()
    {
        $ci = &get_instance();
        $this->params = $ci->config->item('mongodb');
    }

    public function dump()
    {
        var_dump($this->m);
    }

    public function user_add($data)
    {
        $handler = new MongoClient($this->params);
        $db = $handler->szone;
        $collection = $db->user;
        $data['size'] = new MongoInt64($data['size']);
        $data['used'] = new MongoInt64($data['used']);
        $collection->insert($data, array('safe'=>true));
        $handler->close(true);
    }
}

/* End of file SZMongo.php */