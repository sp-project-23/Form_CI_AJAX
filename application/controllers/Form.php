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

        public function fetchAllData()
        {
            if (!$this->input->is_ajax_request()) { exit('no valid req.'); }

            $data = $this->Data_model->getAllData();

            ?>
            <table class="table" style="vertical-align: middle; text-align: center;">
				  <thead class="thead-dark">
                    <tr>
                        <td scope="col">#</td>
                        <td scope="col">Name</td>
                        <td scope="col">Email</td>
                        <td scope="col">Mobile</td>
                        <td scope="col">DOB</td>
                        <td scope="col">Gender</td>
                        <td scope="col">Profile</td>
                        <td scope="col">Action</td>
                    </tr>
				  </thead>
				  <tbody>
				  	<?php if($data){ foreach($data as $se_data){ ?>
					<tr>
					    <!-- <th scope="row"><?php //echo $counter; $counter++; ?></th> -->
                        <td><?php echo $se_data['id']; ?></td>
					  	<td><?php echo $se_data['name']; ?></td>
					  	<td><?php echo $se_data['email']; ?></td>
					  	<td><?php echo $se_data['mobile']; ?></td>
						<td><?php echo $se_data['dob']; ?></td>
                        <td><?php echo $se_data['gender']; ?></td>
                        <td><img src="<?php echo base_url().'uploads/'.$se_data['profile']; ?>" class="w-25 h-25"/></td>
						<td>
							<button type="button" data-dataid="<?php echo $se_data['id']; ?>" data-toggle="modal" data-target="#updateModalCenter" class="btn btn-sm btn-success editdata">Edit</button>
							<button type="button" data-dataid="<?php echo $se_data['id']; ?>" data-toggle="modal" data-target="#deleteModalCenter" class="btn btn-sm btn-danger deletedata">Delete</button>
						</td>
					</tr>
					<?php }}else{ echo "<tr><td colspan='9'><h2>No Result Found</h2></td></tr>"; } ?>
				  </tbody>
				</table>
            <?php	

        }

        public function editData()
        {

            // if (!$this->input->is_ajax_request()) { exit('no valid req.'); }

            $id = $this->input->post('id');

            $data = $this->Data_model->getDataById($id);

            $response = array(
                'status' => "success",
                'id' => $data['id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'dob' => $data['dob'],
                'gender' => $data['gender']=='Male'?'1':($data['gender']=='Female'?'2':'3'),
                'profile' => $data['profile']
            );
            
            echo json_encode($response);

        }

        public function updateData()
        {

            $this->load->helper(array('form','url'));

            // if (!$this->input->is_ajax_request()) { exit('no valid req.'); }
            
            if($this->input->method()=='post') {       

                $this->form_validation->set_rules('name', 'Name', 'required|trim');
                $this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[test_table.email]');
                $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|is_unique[test_table.mobile]');
                $this->form_validation->set_rules('dob', 'DOB', 'required');
                $this->form_validation->set_rules('gender', 'Gender', 'required');

                $fields = ['name', 'email', 'mobile', 'dob', 'gender', 'profile'];

                $data = [];

                $id = $this->input->post('edit_id');

                $oldData = $this->Data_model->getDataById($id);

                $oldImg = $oldData['profile'];

                foreach ($fields as $field){

                    $data[$field] = $this->input->post('edit_'.$field);
                    if($field == 'gender')
                        $data[$field] = $this->input->post('edit_'.$field)=='1'?'Male':($this->input->post('edit_'.$field)=='2'?'Female':'Other');
                
                }

                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload',$config);	

                $this->upload->initialize($config);

                $this->upload->do_upload('edit_profile');

                $img = $this->upload->data();

                $data['profile'] = $img['file_name']; 


                if($img['file_name']=='')
				    $data['profile'] = $oldImg;

                if($img['file_name']!='' && $img['file_name']!=$oldImg){

                    $data['profile'] = $img['file_name'];
                    $file = './uploads/'.$oldImg;		
                    unlink($file);
                }	

                // print_r($data);
                // die;

                if( $this->Data_model->updateDataById($id, $data) == true ){
                    $response = array(
                        'status' => "success",
                        'message' => "Data updated successfully"
                    );  
                }
                 
            }         
            
            echo json_encode($response);

        }

        public function deleteData()
        {

            // if (!$this->input->is_ajax_request()) { exit('no valid req.'); }

            $id = $this->input->post('id');

            $this->Data_model->deleteDataById($id);

            $response = array(
                'status' => "success",
                'message' => "Data deleted successfully"
            );            
            
            echo json_encode($response);

        }

        public function insertData()
        {
            $this->load->helper(array('form','url'));
            $this->load->library('form_validation');
            if (!$this->input->is_ajax_request()) { exit('no valid req.'); }

            if($this->input->method()=='post') {

                $this->form_validation->set_rules('name', 'Name', 'required|trim');
                $this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[test_table.email]');
                $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|is_unique[test_table.mobile]');
                $this->form_validation->set_rules('dob', 'DOB', 'required');
                $this->form_validation->set_rules('gender', 'Gender', 'required');
                // $this->form_validation->set_rulkes('profile', 'Profile', 'required');
                
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
                            'message' => "Data inserted successfully"
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