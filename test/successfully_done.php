 <?php
 
$name=$_POST["name"];
$email=$_POST["email"];
$mobile=$_POST["mobile"];
$password=$_POST["password"];
  
  $host="localhost";
 $username="root";
 $password1="";
 $dbname="prop_details";
$conn = mysqli_connect($host, $username, $password1, $dbname);
$sql1=
 
 // Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
	
}
$sql = "insert into users(name,email,mobile,password)values('".$name."','".$email."','".$mobile."','".$password."') ";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
     mysqli_error($conn);
}
?>
<html>
<style>
.para{
 margin-top: 80px;
  margin-bottom: 80px;
  margin-left: 130px;
 color:#fff;
}

.form-signin {
  max-width: 380px;
  padding: 15px 35px 45px;
  margin: 0 auto;
 background-color:#fff;
 
}
.form-signin .input-group
{
top:0px;
}

.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 30px;
	
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
#password  { -webkit-text-security: disc; }
 </style>
<body>
  <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">       
  <div style="font-size:24px; text-align:center" ><b>Register Now</b></div>
	  <br>
				<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" name="name" placeholder="Username"  required/>
              </div><br>
				<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="text" class="form-control"  name="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required/>
              </div><br>
			  <div class="input-group" >
               <span class="input-group-addon" ><i class="fa fa-lock" ></i></span>
                <input id="password" type="text" name="password" class="form-control" placeholder="Password" pattern=".{6,}" title="Six or more characters" required/>

              </div><br>
			   <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control" name="mobile" placeholder="Mobile No." pattern="[789][0-9]{9}"  required/>
              </div><br>
			  
	  
      <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block"  value="Register"/> 
    </form>
	</body>
</html>


