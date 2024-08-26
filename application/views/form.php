<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Form</title>
        <link href="<?php echo base_url().'assets/css/bootstrap.min.css'; ?>" rel="stylesheet">
        <link href="<?php echo base_url().'assets/css/responsive.css'; ?>" rel="stylesheet">
        
        <script src="<?php echo base_url().'assets/js/ajax.popper.min.js'; ?>"></script>
        <script src="<?php echo base_url().'assets/js/jquery.min.js'; ?>"></script>
        <script src="<?php echo base_url().'assets/js/bootstrap.min.js'; ?>"></script>

    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <h1 class="heading bg-info rounded text-white p-2">Data Table</h1>

                    <div id="message" class="message bg-danger rounded text-white text-center"></div> 
                    <div id="update" class="update bg-success rounded text-white text-center"></div> 

                    <div id="tabledata">
                
                    </div>
                </div>

                <div class="col-lg-3">
                    <h1 class="heading bg-primary rounded text-white p-2">Form</h1>

                    <div id="success" class="success bg-success rounded text-white text-center"></div>
                    <div id="error" class="error bg-danger rounded text-white text-center"></div>

                    <form method="post" action="form/submission" class="form" id="form" enctype="multipart/form-data">
                        <label for="name" class="label">Name</label>
                        <input type="text" name="name" id="name" class="field form-control" onKeyPress="return validateAlpha(event);">

                        <label for="email" class="label">Email</label>
                        <input type="email" name="email" id="email" class="field form-control">

                        <label for="mobile" class="label">Mobile</label>
                        <input type="text" name="mobile" id="mobile" maxlength="10" class="field form-control" onKeyPress="return validateNumber(event);">

                        <label for="dob" class="label">DOB</label>
                        <input type="date" name="dob" id="dob" class="field form-control">
                        
                        <label for="gender" class="label">Gender</label>
                        <select name="gender" id="gender" class="field form-control">
                        <option value="" class="field form-control">(select gender)</option>
                        <?php $genders = [1 => 'Male', 2 => 'Female', 3 => 'Other']; 
                            foreach ($genders as $key => $row) {?>
                                <option value="<?php echo $key; ?>" class="field form-control"><?php echo $row; ?></option>
                            <?php } ?>
                        </select> 

                        <label for="profile" class="label">Profile Image</label>
                        <input type="file" name="profile" id="profile" accept="image/*" class="field form-control">

                        <br>
                        <div class="text-center">
                            <input type="submit" value="Submit" id="submit" class="butnsub btn btn-success">
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
                    <button type="button" class="butn btn btn-secondary" id="delete_cancel" data-dismiss="modal">Cancel</button>
                    <button type="button" class="butn btn btn-danger" id="delete">Delete Now</button>
                </div>
                </div>
            </div>
        </div>	


        <div class="modal fade" id="updateModalCenter" tabindex="-1" role="dialog" aria-labelledby="updateModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="heading modal-title text-white" id="updateModalCenterTitle">Edit & Update</h5>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="form/updateData" role="form" id="updateForm" class="updateForm" enctype="multipart/form-data">

                            <input type="hidden" name="edit_id" id="edit_id" value="">

                            <div id="editerror" class="editerror bg-danger rounded text-white text-center"></div>

                            <label for="edit_name" class="label">Name</label>
                            <input type="text" name="edit_name" id="edit_name" class="editfield form-control" onKeyPress="return validateAlpha(event);">

                            <label for="edit_email" class="label">Email</label>
                            <input type="email" name="edit_email" id="edit_email" class="editfield form-control">

                            <label for="edit_mobile" class="label">Mobile</label>
                            <input type="text" name="edit_mobile" id="edit_mobile" maxlength="10" class="editfield form-control" onKeyPress="return validateNumber(event);">

                            <label for="edit_dob" class="label">DOB</label>
                            <input type="date" name="edit_dob" id="edit_dob" class="editfield form-control">
                            
                            <label for="edit_gender" class="label">Gender</label>
                            <select name="edit_gender" id="edit_gender" class="editfield form-control">
                            <option value="" class="editfield form-control">(select gender)</option>
                            <?php $genders = [1 => 'Male', 2 => 'Female', 3 => 'Other']; 
                                foreach ($genders as $key => $row) {?>
                                    <option value="<?php echo $key; ?>" class="editfield form-control"><?php echo $row; ?></option>
                                <?php } ?>
                            </select> 

                            <label for="edit_profile" class="label">Profile Image</label>
                            <input type="file" name="edit_profile" id="edit_profile" accept="image/*" class="editfield form-control">
                            <img src="" id="profile_image" class="profile mt-2">

                            <div class="modal-footer">
                                <button type="button" class="butn btn btn-secondary" id="update_cancel" data-dismiss="modal">Cancel</button>
                                <input type="submit" class="butn btn btn-success" id="update" value="Update">
                            </div>
                        </form>
                    </div>                
                </div>
            </div>
        </div>	


    </body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <script>
   
        $(document).ready(function() {
            $('#name').bind('copy paste cut',function(e) { 
                e.preventDefault();
                alert('cut,copy & paste options are disabled !!');
            });
            $('#email').bind('copy paste cut',function(e) { 
                e.preventDefault();
                alert('cut,copy & paste options are disabled !!');
            });
            $('#mobile').bind('copy paste cut',function(e) { 
                e.preventDefault();
                alert('cut,copy & paste options are disabled !!');
            });
            $('#edit_name').bind('copy paste cut',function(e) { 
                e.preventDefault();
                alert('cut,copy & paste options are disabled !!');
            });
            $('#edit_email').bind('copy paste cut',function(e) { 
                e.preventDefault();
                alert('cut,copy & paste options are disabled !!');
            });
            $('#edit_mobile').bind('copy paste cut',function(e) { 
                e.preventDefault();
                alert('cut,copy & paste options are disabled !!');
            });
        });
        
        function validateAlpha(evt) {

            var keyCode = (evt.which) ? evt.which : evt.keyCode
            if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)            
                return false;
            return true;
        }

        function validateNumber(evt){  

            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        $('input[type=email]').on('keypress', function (e) {
            var re = /[A-Z0-9a-z@\._]/.test(e.key);
            if (!re) {
                return false;
            }
        });

        $('input[type=edit_email]').on('keypress', function (e) {
            var re = /[A-Z0-9a-z@\._]/.test(e.key);
            if (!re) {
                return false;
            }
        });


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

                            // $("#editerror").html('');
                            $("#error").html('');
                            $("#message").html('');	
                            $("#success").html('');

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

                if($("input[name='edit_name']").val()==''){
                    alert("Name field is empty");
                    $("input[name='name']").focus();
                    e.preventDefault();
                    return false;
                }
                if($("input[name='edit_name']").val()!=''){
                    let str = $("input[name='edit_name']").val();
                    var flag = 0;
                    for (let i = 0; i < str.length; i++) {
                        if (str[i] >= '0' && str[i] <= '9') {
                            flag = 1;
                            break;
                        }
                    }
                    if(flag==1){
                        alert("Name field doesn't contain digit");
                        $("input[name='edit_name']").focus();
                        e.preventDefault();
                        return false;
                    }
                   
                }
                if($("input[name='edit_email']").val()==''){
                    alert("Email field is empty");
                    $("input[name='email']").focus();
                    e.preventDefault();
                    return false;
                }
                if($("input[name='edit_mobile']").val()==''){
                    alert("Mobile field is empty");
                    $("input[name='mobile']").focus();
                    e.preventDefault();
                    return false;
                }
                if($("input[name='edit_dob']").val()==''){
                    alert("DOB field is empty");
                    $("input[name='dob']").focus();
                    e.preventDefault();
                    return false;
                }
                if($("select[name='edit_gender']").val()==''){
                    alert("Gender field is empty");
                    $("select[name='gender']").focus();
                    e.preventDefault();
                    return false;
                }
               

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

                            $("#editerror").html('');	
                            $('#update_cancel').trigger("click");
                            $("#error").html('');
                            $("#message").html('');	
                            $("#success").html('');
                            $("#update").html(result.message);	  
                            $('#tabledata').load('form/fetchAllData');

                        }
                        if(result.status=='editerror'){
                            $("#success").html('');
                            $("#update").html('');	
                            $("#message").html('');	
                            $("#error").html('');
                            $("#editerror").html(result.message);	
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
                            $("#error").html(''); 
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
                if($("input[name='name']").val()!=''){
                    let str = $("input[name='name']").val();
                    var flag = 0;
                    for (let i = 0; i < str.length; i++) {
                        if (str[i] >= '0' && str[i] <= '9') {
                            flag = 1;
                            break;
                        }
                    }
                    if(flag==1){
                        alert("Name field doesn't contain digit");
                        $("input[name='name']").focus();
                        e.preventDefault();
                        return false;
                    }
                   
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

                            $("#error").html('');	
                            $("#update").html('');	
                            $("#message").html('');	
                            $("#success").html(result.message);	  
                            $('#tabledata').load('form/fetchAllData');

                        }
                           
                        if(result.status=='error'){
                            $("#success").html('');
                            $("#update").html('');	
                            $("#message").html('');	
                            $("#error").html(result.message);	
                        }
                            
                        
                    }
                });         

            }));

        });
    
    </script>

</html>