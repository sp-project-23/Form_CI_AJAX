<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
    </head>
    <body>

        <div class="container w-25 mt-5">
            <h3>Form</h3>
            <div id="message"></div>
            <?php //echo validation_errors(); ?>
            <form method="post" action="form/submission" enctype="multipart/form-data">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control">

                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control">

                <label for="mobile">Mobile</label>
                <input type="number" name="mobile" id="mobile" class="form-control">

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

                <label for="profile"></label>
                <input type="file" name="profile" id="profile" class="form-control">

                <br>
                <input type="submit" value="Submit" id="submit" class="btn btn-success">
            </form>
        </div>

    </body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- <script src="jslibs/jquery.js" type="text/javascript"></script> -->
<!-- <script src="jslibs/ajaxupload-min.js" type="text/javascript"></script> -->

<script>
  
    // $('#submit').click(function(e){
    //     e.preventDefault();
    //     var name = $('#name').val();
    //     var email = $('#email').val();
    //     var mobile = $('#mobile').val();
    //     var dob = $('#dob').val();
    //     var gender = $('#gender').val();
    //     // var s = $('#profile').val();
    //     // s = s.replace(/\\/g, '/');
    //     // s = s.substring(s.lastIndexOf('/')+ 1);
    //     // profile = s.substring(s.lastIndexOf('/')+ 1);

    //     if($("input[name='name']").val()==''){
    //         alert("Name field is empty");
    //         $("input[name='name']").focus();
    //         e.preventDefault();
    //         return false;
    //     }
    //     if($("input[name='email']").val()==''){
    //         alert("Email field is empty");
    //         $("input[name='email']").focus();
    //         e.preventDefault();
    //         return false;
    //     }
    //     if($("input[name='mobile']").val()==''){
    //         alert("Mobile field is empty");
    //         $("input[name='mobile']").focus();
    //         e.preventDefault();
    //         return false;
    //     }
    //     if($("input[name='dob']").val()==''){
    //         alert("DOB field is empty");
    //         $("input[name='dob']").focus();
    //         e.preventDefault();
    //         return false;
    //     }
    //     if($("select[name='gender']").val()==''){
    //         alert("Gender field is empty");
    //         $("select[name='gender']").focus();
    //         e.preventDefault();
    //         return false;
    //     }

    //     var form_data = new FormData();
    //     var files = $('#profile')[0].files[0];
    //     form_data.append("profile", files);
    //     console.log(files);

    //     $.ajax({
    //         url: "./form/submission",
    //         method: "post",
    //         // data: { 'name' : name, 'email' : email, 'mobile' : mobile, 'dob' : dob, 'gender' : gender, 'profile' : profile},
    //         data: form_data,
    //         // dataType: "html",
    //         contentType: false,
    //         processData: false,
    //         success: function (response) {
    //             alert('Data Added');
    //             // $('#form')[0].reset();
    //             if(response.status == 'success') {
    //                 window.location.reload();
    //             }
    //             $("#message").html(response.message);
    //         }
    //     });
    // }) 
</script>


<script>
     $('#submit').click(function(e){
        var name = $('#name').val();
        var email = $('#email').val();
        var mobile = $('#mobile').val();
        var dob = $('#dob').val();
        var gender = $('#gender').val();

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
    });


    $(document).ready(function (e) {
        $("#form").on('submit',(function(e) {
            e.preventDefault();    

            $.ajax({
                url: "./form/submission",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                        cache: false,
                processData:false,
                success: function(data)
                {
                    if(data=='invalid')
                    {
                        $("#err").html("Invalid File !").fadeIn();
                    }
                    else
                    {
                        alert('Data added successfully');
                        // view uploaded file.
                        $("#preview").html(data).fadeIn();
                        $("#form")[0].reset(); 
                    }
                },
                error: function(e) 
                    {
                        $("#err").html(e).fadeIn();
                    }          
            });
        }));
    });
</script>