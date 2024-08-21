<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
    </head>
    <body>

        <div class="container w-25 mt-5">
            <h1 class="bg-warning rounded text-white p-2">Form</h1>
            <div id="message" class="message" class="text-center"></div>
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

    </body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <script>
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
                        $('#name').val('');
        				$('#email').val('');
        				$('#mobile').val('');
        				$('#dob').val('');
                        $('#gender').val('');
                        $('#profile').val('');
                        // alert(response);
        				// alert(response['message']);
                        // if(response.status_code='201')
                        $("#message").html(response);	
                        // alert(json_decode(response));
                        
                    },
                    error: function(response) {
                        console.log(response.status + ':' + response.message);
                    }
                });         

            }));
        });



        // $(document).ready(function(){
        //     $('form.form').on('submit', function(form){
        //         form.preventDefault();
        //         console.log($(this).serializeArray());
        //         $.post('./form/submission', $(this).serializeArray(), function(data){
        //             $('div.message').html(data);
        //         });
        //     });
        // });

        // $("form").submit(function (event) {
                
        //     var formData = new FormData($(this));
        
        //     $.ajax({
        //             url: url,
        //             type: 'POST',
        //             data: formData,
        //             async: false,
        //             success: function (data) {
        //                 //success callback
        //             },
        //             cache: false,
        //             contentType: false,
        //             processData: false
        //             });
        
        //     });
    
    </script>

</html>