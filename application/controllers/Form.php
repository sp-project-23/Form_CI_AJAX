<?php

    defined('BASEPATH') OR exit('u no here');

    class Form extends CI_Controller {
        public function __construct ()
        {
            parent::__construct();
            $this->load->model('Data_model');
            $this->load->helper(array('form','url'));
            $this->load->library('form_validation');
            // $this->load->library('upload');
        }

        public function index()
        { 
            $this->load->view('form');
        }

        public function submission()
        {

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required');
            $this->form_validation->set_rules('dob', 'DOB', 'required');
            $this->form_validation->set_rules('gender', 'Gender', 'required');
            // $this->form_validation->set_rules('profile', 'Image', 'required');

            if ($this->form_validation->run() == false) {
                $response = array(
                    'status' => 'error',
                    'message' => validation_errors()
                );
            }

            else {    

                $fields = ['name', 'email', 'mobile', 'dob', 'gender', 'profile'];

                $data = [];

                foreach ($fields as $field)
                {
				    $data[$field] = $this->input->post($field);
                    if($field == 'gender')
                        $data[$field] = $this->input->post($field)=='1'?'Male':($this->input->post($field)=='2'?'Female':'Other');
                }

                // print_r($data);
                // die;

                $filename = $_FILES['profile']['name'];
                // $location = "./uploads/".$filename;
                // $uploadOk = 1;
                // $imageFileType = pathinfo($location,PATHINFO_EXTENSION);

                // $valid_extensions = array("jpg","jpeg","png");

                // if( !in_array(strtolower($imageFileType),$valid_extensions) ) 
                //     $uploadOk = 0;
                // if($uploadOk == 0)
                //     echo 0;
                // else
                // {
                //     if(move_uploaded_file($_FILES['profile']['tmp_name'],$location))
                //         echo $location;
                //     else
                //         echo 0;
                // }

                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload',$config);	

                $this->upload->initialize($config);

                $this->upload->do_upload('profile');

                $this->upload->data();
      
                // $img = $this->upload->data();

                // echo "<pre>";
                // print_r($img);
                // die;
    
                // $data['profile'] = $img['file_name']; 
                $data['profile'] = $filename; 

                $this->Data_model->addData($data);
    
                $response = array(
                    'status' => 'success',
                    'message' => "<h3>Data added successfully.</h3>"
                );
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($response));

            header("location: http://localhost/Form_CI_AJAX/");
        }

    }