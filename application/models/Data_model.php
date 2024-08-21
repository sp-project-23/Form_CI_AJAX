<?php

    defined('BASEPATH') OR exit('u no here');

    class Data_model extends CI_Model
    {

        public function addData($data)
        {

            $this->db->insert('test_table', $data);

            return $this->db->insert_id();

        }

        public function deleteDataById($id)
        {
            // echo $id;

            $profile_image = $this->db->select('profile')->where('id', $id)->get('test_table')->row_array();

            // $f = unlink(base_url()."uploads/".$profile_image['profile']);
            
            // if($f) 
                return $this->db->where('id', $id)->delete('test_table')->result();
        }

        public function getAllData()
        {
            return $this->db->get('test_table')->result();
        }
    }