<?php


class Activity extends CI_Model
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default',TRUE);
    }

    public function doFind()
    {
        $query = $this->db->query("select * from ci.activity limit 2,10");

        return $query->result();
    }

    public function doUpdate()
    {
        $query = $this->db->query("update ci.activity set kou_info = 1");
        return $query;
    }

    public function doInsert()
    {
        $query = $this->db->query("insert into work.cwl(uid,use_time,recharge_time) values(542765,1,1) ");
        return $query;
    }
}