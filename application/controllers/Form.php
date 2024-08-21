<?php

    defined('BASEPATH') OR exit('u no here');

    class Form extends CI_Controller {
        public function __construct ()
        {
            parent::__construct();

            $this->load->model('Data_model');
            $this->load->helper(array('form','url'));
            $this->load->library('form_validation');

        }

        public function index()
        { 
            $this->load->view('form');
        }

        public function submission()
        {
            $this->load->helper(array('form','url'));
            $this->load->library('form_validation');
            // if (!$this->input->is_ajax_request()) { exit('no valid req.'); }

            if($this->input->method()=='post') {

                $this->form_validation->set_rules('name', 'Name', 'required|trim');
                $this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[test_table.email]');
                $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|is_unique[test_table.mobile]');
                $this->form_validation->set_rules('dob', 'DOB', 'required');
                $this->form_validation->set_rules('gender', 'Gender', 'required');
                // $this->form_validation->set_rulkes('profile', 'Profile', 'required');
                
                // $response = array('status'=>'FAILED','message'=>'Something went wrong! Try again later.');

                if ($this->form_validation->run() == true) {

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

                    // $filename = $_FILES['profile']['name'];
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

                    // $this->upload->data();
        
                    $img = $this->upload->data();

                    // echo "<pre>";
                    // print_r($img);
                    // die;
        
                    $data['profile'] = $img['file_name']; 
                    // $data['profile'] = $filename; 

                    $result = $this->Data_model->addData($data);
        
                    if($result == true)
                    {
                        $response = array(
                            'status' => "success",
                            'message' => "Data added successfully"
                        );
                       
                        // echo '<p class="bg-success text-white rounded p-1">'."Data added successfully".'</p>';
                    }
                    
                }

                else {    
                    $response = array(
                        'status' => "error",
                        'message' => validation_errors()
                    );
                    // echo '<div class="bg-danger text-white rounded p-1">'.validation_errors().'</div>';
                
                }

                // echo $response;
                echo json_encode($response);
                // exit();

            }
        }

    }