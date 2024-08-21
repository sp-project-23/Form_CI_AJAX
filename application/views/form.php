<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
    </head>
    <body>

        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-9">
                    <h1 class="bg-warning rounded text-white p-2">Data Table</h1>
                    <div id="message" class="message bg-danger rounded text-white text-center"></div> 
                    <table class="table">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Mobile</td>
                                <td>DOB</td>
                                <td>Gender</td>
                                <td>Profile</td>
                                <td>ACTION</td>
                            </tr>
                        </thead>
                        <tbody id="tabledata" class="tabledata">
            
                        </tbody>
                    </table>
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
                        <input type="text" name="mobile" id="mobile" pattern="^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$" maxlength="10" class="form-control">

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

    </body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <script>

        $(document).ready(function () {
            getAllData();
        });

        function getAllData(){
                     
            $.ajax({
                type: "get",
                url: "form/fetchAllData",
                success: function(response){

                    var result = JSON.parse(response);

                    var baseUrl = "http://localhost/Form_CI_AJAX/uploads/";

                    $.each(result, function (key, value) { 
                        $('.tabledata').append('<tr>'+
                                '<td>'+'#'+'</td>\
                                <td>'+value['name']+'</td>\
                                <td>'+value['email']+'</td>\
                                <td>'+value['mobile']+'</td>\
                                <td>'+value['dob']+'</td>\
                                <td>'+value['gender']+'</td>\
                                <td><img src="'+baseUrl+value['profile']+'" class="w-50 h-50"/></td>\
                                <td>\
                                    <button onclick="getdata('+value['id']+')" class="btn btn-sm btn-success" id="edit">Edit</button>\
                                    <button onclick="return delData('+value['id']+')" class="btn btn-sm btn-danger id="delete">Delete</button>\
                                </td>\
                            </tr>');
                    });
                }
            });
        }       



        function delData(id){
            alert(id);
                     
            $.ajax({
                type: "post",
                url: "form/deleteData",
                data: {id: id},
                dataType: "JSON",
                success: function(response){

                    var result = JSON.parse(response);

                    if(result.status=='success')
                        $("#message").html(result.message);	

                }
            });
        }       



        $(document).ready(function () {

            $("#form").on('submit',(function(e) {

                e.preventDefault();    

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
                    url: "form/submission",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,       		
                    cache: false,					
                    processData:false,  
                    success: function(response) {

                        var result = JSON.parse(response);
                   
                        $('#name').val('');
        				$('#email').val('');
        				$('#mobile').val('');
        				$('#dob').val('');
                        $('#gender').val('');
                        $('#profile').val('');
                        // $("#message").html(response);	
                        if(result.status=='success')
                            $("#success").html(result.message);	
                        if(result.status=='error')
                            $("#error").html(result.message);	
                        
                    }
                    // error: function(response) {
                    //     console.log(response.status + ':' + response.message);
                    // }
                });         

            }));
        });
    
    </script>

</html>