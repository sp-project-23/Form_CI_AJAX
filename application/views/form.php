<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" type="text/javascript"></script>
        
    </head>
    <body>

        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-9">
                    <h1 class="bg-warning rounded text-white p-2">Data Table</h1>

                    <div id="message" class="message bg-danger rounded text-white text-center"></div> 
                    <div id="update" class="update bg-success rounded text-white text-center"></div> 

                    <div id="tabledata">
                
                    </div>
                </div>

                <div class="col-lg-3">
                    <h1 class="bg-warning rounded text-white p-2">Form</h1>

                    <div id="success" class="success bg-success rounded text-white text-center"></div>
                    <div id="error" class="error bg-danger rounded text-white text-center"></div>

                    <form method="post" action="form/submission" class="form" id="form" enctype="multipart/form-data">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control">

                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control">

                        <label for="mobile">Mobile</label>
                        <input type="text" name="mobile" id="mobile"]lg maxlength="10" class="form-control">

                        <label for="dob">DOB</label>
                        <input type="date" name="dob" id="dob" class="form-control">
                        
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                        <option value="">(select gender)</option>
                        <?php $genders = [1 => 'Male', 2 => 'Female', 3 => 'Other']; 
                            foreach ($genders as $key => $row) {?>
                                <option value="<?php echo $key; ?>"><?php echo $row; ?></option>
                            <?php } ?>
                        </select> 

                        <label for="profile">Profile Image</label>
                        <input type="file" name="profile" id="profile" accept="image/*" class="form-control">

                        <br>
                        <div class="text-center">
                            <input type="submit" value="Submit" id="submit" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>           
        </div>



        <div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalCenterTitle">Are You Sure Delete This Record ?</h5>
                </div>
                <div class="modal-body">
                    <p>If You Click On "Delete Now" Button Record Will Be Deleted. We Don't have Backup. So Be Careful.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" id="delete_cancel" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-danger" id="delete">Delete Now</button>
                </div>
                </div>
            </div>
        </div>	


        <div class="modal fade" id="updateModalCenter" tabindex="-1" role="dialog" aria-labelledby="updateModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalCenterTitle">Edit & Update</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                        <!-- <span aria-hidden="true">&times;</span> -->
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="form/updateData" role="form" id="updateForm" class="updateForm" enctype="multipart/form-data">

                            <input type="hidden" name="edit_id" id="edit_id" value="">

                            <label for="edit_name">Name</label>
                            <input type="text" name="edit_name" id="edit_name" class="form-control">

                            <label for="edit_email">Email</label>
                            <input type="email" name="edit_email" id="edit_email" class="form-control">

                            <label for="edit_mobile">Mobile</label>
                            <input type="text" name="edit_mobile" id="edit_mobile" maxlength="10" class="form-control">

                            <label for="edit_dob">DOB</label>
                            <input type="date" name="edit_dob" id="edit_dob" class="form-control">
                            
                            <label for="edit_gender">Gender</label>
                            <select name="edit_gender" id="edit_gender" class="form-control">
                            <option value="">(select gender)</option>
                            <?php $genders = [1 => 'Male', 2 => 'Female', 3 => 'Other']; 
                                foreach ($genders as $key => $row) {?>
                                    <option value="<?php echo $key; ?>"><?php echo $row; ?></option>
                                <?php } ?>
                            </select> 

                            <label for="edit_profile">Profile Image</label>
                            <input type="file" name="edit_profile" id="edit_profile" accept="image/*" class="form-control">
                            <img src="" id="profile_image" class="w-25 h-25 mt-2">

                            <!-- <div class="text-center">
                                <input type="submit" value="Submit" id="submit" class="btn btn-success">
                            </div> -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" id="update_cancel" data-dismiss="modal">Cancel</button>
                                <input type="submit" class="btn btn-sm btn-success" id="update" value="Update">
                            </div>
                        </form>
                    </div>                
                </div>
            </div>
        </div>	


    </body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <script>

        $(document).ready(function () {

            $('#tabledata').load('form/fetchAllData');


            $(document).on("click", "button.editdata", function(){

                var edit_id = $(this).data('dataid');

                var baseUrl = '<?php echo base_url(); ?>'+'uploads/';

                $.ajax({
                    type: "POST",
                    url: "form/editData",
                    data: {id : edit_id},
                    success: function(response){

                        var result = JSON.parse(response);

                        if(result.status == 'success'){

                            $('#edit_id').val(result.id);
                            $('#edit_name').val(result.name);
                            $('#edit_email').val(result.email);
                            $('#edit_mobile').val(result.mobile);
                            $('#edit_dob').val(result.dob);
                            $('#edit_gender').val(result.gender);
                            $('#profile_image').attr("src", baseUrl+result.profile);

                            $('#update').attr("data-id", edit_id);

                        }

                    }
                    
                });
            });

  
                

            $("#updateForm").on('submit',(function(e) {

                e.preventDefault();    

                $.ajax({
                    url: "form/updateData",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,       		
                    cache: false,					
                    processData:false,  
                    success: function(response) {

                        var result = JSON.parse(response);
                
                        if(result.status=='success'){

                            $('#update_cancel').trigger("click");
                            $("#error").html();
                            $("#message").html('');	
                            $("#success").html('');
                            $("#update").html(result.message);	                             
                            $('#tabledata').load('form/fetchAllData');

                        }
                        
                    }
                });         

            }));
           

    
           

            var deleteid;

            $(document).on("click", "button.deletedata", function(e){
                deleteid = $(this).data("dataid");    
            });   

            $('#delete').click(function (){
                $.ajax({
                    type: "POST",
                    url: "form/deleteData",
                    data: {id : deleteid},
                    success: function(response){

                        var result = JSON.parse(response);

                        if(result.status == 'success'){

                            $("#message").html(result.message);	 
                            $("#error").html(); 
                            $("#update").html('');	
                            $("#success").html('');
                            $('#delete_cancel').trigger("click");
                            $('#tabledata').load('form/fetchAllData');

                        }
                    }
                });
            });


            $("#form").on('submit',(function(e) {

                e.preventDefault();   
                
                $("#error").html();	

                if($("input[name='name']").val()==''){
                    alert("Name field is empty");
                    $("input[name='name']").focus();
                    e.preventDefault();
                    return false;
                }
                if($("input[name='email']").val()==''){
                    alert("Email field is empty");
                    $("input[name='email']").focus();
                    e.preventDefault();
                    return false;
                }
                if($("input[name='mobile']").val()==''){
                    alert("Mobile field is empty");
                    $("input[name='mobile']").focus();
                    e.preventDefault();
                    return false;
                }
                if($("input[name='dob']").val()==''){
                    alert("DOB field is empty");
                    $("input[name='dob']").focus();
                    e.preventDefault();
                    return false;
                }
                if($("select[name='gender']").val()==''){
                    alert("Gender field is empty");
                    $("select[name='gender']").focus();
                    e.preventDefault();
                    return false;
                }
                if($("input[name='profile']").val()==''){
                    alert("Profile Image not uploaded");
                    $("input[name='profile']").focus();
                    e.preventDefault();
                    return false;
                }

                $.ajax({
                    url: "form/insertData",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,       		
                    cache: false,					
                    processData:false,  
                    success: function(response) {

                        var result = JSON.parse(response);
                   
                        // $('#name').val('');
        				// $('#email').val('');
        				// $('#mobile').val('');
        				// $('#dob').val('');
                        // $('#gender').val('');
                        // $('#profile').val('');

                        if(result.status=='success'){

                            $('#name').val('');
                            $('#email').val('');
                            $('#mobile').val('');
                            $('#dob').val('');
                            $('#gender').val('');
                            $('#profile').val('');

                            $("#error").html();	
                            $("#update").html('');	
                            $("#message").html('');	
                            $("#success").html(result.message);	  
                            $('#tabledata').load('form/fetchAllData');

                        }
                           
                        if(result.status=='error'){
                            $("#success").html();
                            $("#error").html(result.message);	
                        }
                            
                        
                    }
                });         

            }));

        });
    
    </script>

</html>