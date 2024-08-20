<?php

    defined('BASEPATH') OR exit('u no here');

    class Data_model extends CI_Model
    {

        public function addData($data)
        {

            $this->db->insert('test_table', $data);

            return $this->db->insert_id();

        }
    }