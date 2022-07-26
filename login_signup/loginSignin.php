
            <!-- php code for login / register -->

<?php
session_start();
include '../connection.php';
if (isset($_POST['registration'])) {

    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $mobile = $_POST['contact_num'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $age = $_POST['age'];
    
    $encrypted_pwd = password_hash($pwd,PASSWORD_BCRYPT);
    // echo "$email , $password , $f_name , $l_name , $mobile , $gender , $city";
    $insertquery = " INSERT INTO user_data (email_id, pwd ,first_name,last_name,contact,gender,city,age) VALUES ('$email','$encrypted_pwd','$f_name','$l_name','$mobile','$gender','$city','$age') ";
    
  
    $res = mysqli_query($con,$insertquery);

    if ($res) {
    ?>
        <script>
            alert("data inserted !!");
        </script>
    <?php
    } else {
    ?>
        <script>
            alert("data not inserted !!");
        </script>
   <?php

    }
}

else if(isset($_POST['loginform'])) {

    $email = $_POST['loginEmail'];
    $user_enterd_pwd = $_POST['loginPwd'];
    
    $email_search = " select * from user_data where email_id = '$email'";
    $query = mysqli_query($con,$email_search);

    $email_count = mysqli_num_rows($query);

    if($email_count){
        $email_pass = mysqli_fetch_assoc($query);
        $encrypted_pwd =$email_pass['pwd'];
        
        
        // validation of password in case of password in database in encrypted
        $validation = password_verify($user_enterd_pwd,$encrypted_pwd);
        
        if($validation)
        {
            // storing all the data in session storage, after login  
            $_SESSION['first_name'] = $email_pass['first_name'];
            $_SESSION['last_name'] = $email_pass['last_name'];
            $_SESSION['email_id'] = $email_pass['email_id'];
            $_SESSION['contact'] = $email_pass['contact'];
            $_SESSION['gender'] = $email_pass['gender'];
            $_SESSION['city'] = $email_pass['city'];
            $_SESSION['age'] = $email_pass['age'];
           
           ?>
                <script>
                   location.replace("../user_Profile/user_profile.php");
                </script>
           <?php
        }
        else{
            ?>
            <script>alert("password incorrect !!!");</script>
            <?php
        }

    }
    else{
        ?>
        <script>alert(" Invalid Email !! ");</script>
        <?php
    }

}

?>

                   <!-- *********************** html code *******************************  -->
<!DOCTYPE html>
<html>
<head>
     <?php include 'links.php'; ?>
    <title>MediHub-login/sign-up</title>
</head>

<body>
<div class="top_div">
    <nav class="navbar navbar-expand-lg navbar-light" >
        <div class="container-fluid">
            <a href="../index.php" class="navbar-brand text-warning font-weight-bold">
                <img src="../imgs/logoDR.png" class="nav_logo" alt="not found">
            </a>
                <button id="hamburger" class="navbar-toggler bg-light" type="button" data-toggle="collapse"
                    data-target="#collapsenavbar" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" id="hamburger">
                    <i class="fas fa-bars" style="color:rgb(78, 78, 78); font-size:30px;"></i>
                </span>
            </button>
            <div class="collapse navbar-collapse text-center"  id="collapsenavbar">
                <ul class="navbar-nav ml-auto line-height ">
                    <li class="nav-item">
                        <a href="../index.php" class="nav-link text-dark">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-dark">ABOUT</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-dark">SERVICES</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-dark">CONTACT</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>

    <div class="container register">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#login" role="tab" aria-controls="home" aria-selected="true">LOGIN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#sign-up" role="tab" aria-controls="profile" aria-selected="false">REGISTER</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active text-align form-new" id="login" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="register-heading ">Enter Login Details</h3>
                        <div class="row register-form">
                            <div class="col-md-12">
                                <form action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                                    <div class="form-group">
                                        <input type="text" name="loginEmail" class="form-control" placeholder="Login ID*" value="" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="loginPwd" class="form-control" placeholder="Your Password *" value="" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="loginform" class="btnContactSubmit" value="Login" required/>
                                        <a href="#" class="btnForgetPwd" value="Login">Forget Password?</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show text-align form-new" id="sign-up" role="tabpanel" aria-labelledby="profile-tab">
                        <h3 class="register-heading">Create an Account</h3>
                        <div class="row register-form">
                            <div class="col-md-12 ">
                                <form action="./loginSignin.php" method="POST">
                                    <div class="form-group">
                                        
                                        <input type="text" name="email" id="mail_id" class="form-control" onchange="emailValidation()" placeholder="Email Address *"   required/>
                                        <i id="check_icon" class="fas fa-check-circle fa-lg"></i>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="pwd" class="form-control" placeholder="Create Password *" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="f_name" class="form-control" placeholder="First Name *"  required/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="l_name" class="form-control" placeholder="Last Name *" required/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="contact_num" minlength="10" maxlength="10" class="form-control" placeholder="contact number *" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="age" minlength="1" maxlength="3" class="form-control" placeholder="age *" required />
                                    </div>
                                    <div class="form-group">
                                        <p id="redio_btn">Select Gender :<br>
                                            <input class="subButton" class="form-control" type="radio" value="male" name="gender" required> Male<br>
                                            <input class="subButton" type="radio" value="female" name="gender" required> Female<br>
                                            <input class="subButton" type="radio" value="other" name="gender" required> Other<br>
                                        </p>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="city" class="form-control" placeholder="Your City *"  required/>
                                    </div>

                                    <div class="form-group">
                                        <p id="redio_btn">
                                            <input class="subButton" type="checkbox" name="policy" checked required> I Agree to privacy/policy
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="registration" class="btnContactSubmit" value="SIGN-UP" />
                                        <!-- <a href="ForgetPassword.php" class="btnForgetPwd" value="Login">Forget Password?</a> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ****** footer ****** -->
    <footer>
        <div class="row mainfooter sm-auto">
            <div class="col-lg-2 col-md-6 col-12 d-block m-auto ml-auto sm-auto foot1">
                <ul>
                    <li>
                        <h4>MediHUB</h4>
                    </li>
                    <li><a href="#home">About Us</a></li>
                    <li><a href="#home">Blog</a></li>
                    <li><a href="#home">Pricing</a></li>
                    <li><a href="#home">Careers</a></li>
                    <li><a href="#home">How it Works</a></li>
                    <li><a href="#home">What We Treat</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6  col-12 d-block m-auto ml-auto foot2">
                <ul>
                    <li>
                        <h4>BUSSINESS</h4>
                    </li>
                    <li><a href="#home">For Business</a></li>
                    <li><a href="#home">Business Blog</a></li>
                    <li>
                        <h4>LEGAL</h4>
                    </li>
                    <li><a href="#home">Terms of Services</a></li>
                    <li><a href="#home">Privacy Policy</a></li>
                    <li><a href="#home">FAQ's</a></li>

                </ul>
            </div>
            <div class="col-lg-4 col-md-6 col-12 d-block m-auto ml-auto foot3">
                <ul>
                    <li>
                        <h4>MediHUB Health India Pvt Ltd</h4>
                    </li>
                    <li>Bangalore,</li>
                    <li>
                        <p id="address">6th Floor, Unit nos 3 & 4. Vayudooth Chambers,<br>
                            15 & 16, Trinity Junction,<br>
                            Mahatma Gandhi Road,<br>
                            Bangalore – 560001</p>
                    </li>
                    <li>
                        <h4>Contact</h4>
                    </li>
                    <li><a href="#home">91+ 99777 56666</a></li>

                </ul>
            </div>
            <div class="col-lg-3 col-md-5 col-12 d-block m-auto ml-auto foot4">
                <ul>
                    <li>
                        <h4>SOCIAL LINK</h4>
                    </li>
                    <li><a href=""><span class="fa fa-facebook-square" aria-hidden="true"></span> FaceBook</a></li>
                    <li><a href=""><span class="fa fa-instagram" aria-hidden="true"></span> Instagram</a></li>
                    <li> <a href=""><span class="fa fa-youtube-square" aria-hidden="true"></span> YouTube</a></li>
                    <li><a href=""><span class="fa fa-twitter-square" aria-hidden="true"></span> Twitter</a></li>
                    <li><a href=""><span class="fa fa-linkedin-square" aria-hidden="true"></span> Linkedin</a></li>
                    <li><a href="mailto:helpdesk@medihub.com"><span class="fas fa-envelope-square fa-md" aria-hidden="true"></span> Mail</a></li>
                </ul>
            </div>
            <div class="col-lg-1 col-md-1 col-12 d-block m-auto ml-auto top_arrow">
                <a href="#top" onclick=""><span class="fa fa-2x fa-arrow-circle-up" aria-hidden="true"></span></a>
            </div>
        </div>      
        <div class="row mt-5" style="text-align: center;width:97% ">
            <div class="col copyright">
                <p class=""><small class="text-white-50">© 2021 MediHUB, All Rights Reserved.</small></p>
            </div>
        </div>
    </footer>
</div>  
</body>
</html>

