<?php

    defined('BASEPATH') OR exit('u no here');

    class Data_model extends CI_Model
    {

        public function addData($data=NULL)
        {

            $this->db->insert('test_table', $data);

            return $this->db->insert_id();

        }

        public function updateDataById($id, $data)
        {
            return $this->db->where('id', $id)->update('test_table', $data);
        }

        public function getDataById($id=NULL)
        {
            return $this->db->where('id', $id)->get('test_table')->row_array();
        }

        public function deleteDataById($id=NULL)
        {
            $profile_image = $this->db->select()->where('id', $id)->get('test_table')->row_array();
            $file = './uploads/'.$profile_image['profile'];				    
            unlink($file);
     
            return $this->db->where('id', $id)->delete('test_table');

        }

        public function getAllData()
        {
            return $this->db->order_by('id', 'desc')->get('test_table')->result_array();
        }
    }