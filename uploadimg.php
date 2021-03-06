
<!DOCTYPE html>
<html lang="en">
<?php
require("connect.php");
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>New Image - SMIPO</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/smipo.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <?php require_once("navigation.php"); ?>

    <div class="container">

        <div class="row">
            <div class="box">

                <div class="col-md-12">
                    <?php 
						require('connect.php'); 
						ini_set('display_errors', 1);
						ini_set('display_startup_errors', 1);
						error_reporting(E_ALL);   

						if(empty($_SESSION)) // if the session not yet started 
							session_start();

						$username = $_SESSION['user'];
						$user_id = $_SESSION['user_id'];
						$status = $_SESSION['status'];
						$logged_in = $_SESSION['logged_in'];

						if($logged_in):
							$target_dir = "img/";
							$target_file = $target_dir . basename($_FILES["imgfile"]["name"]);
							$uploadOk = 1;
							$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
							// Check if image file is a actual image or fake image
							if(isset($_POST["submit"])) {
								$check = getimagesize($_FILES["imgfile"]["tmp_name"]);
								if($check !== false) {
									echo "File is an image - " . $check["mime"] . ".";
									$uploadOk = 1;
								} else {
									echo "File is not an image.";
									$uploadOk = 0;
								}
							}
							// Check if file already exists
							if (file_exists($target_file)) {
								echo "Sorry, file already exists. Try using a different name\n";
								$uploadOk = 0;
							}
							// Check file size
							if ($_FILES["imgfile"]["size"] > 500000000) {
								echo "Sorry, your file is too large.";
								$uploadOk = 0;
							}
							// Allow certain file formats
							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
							&& $imageFileType != "gif" && $imageFileType != "JPG") {
								echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
								$uploadOk = 0;
							}
							// Check if $uploadOk is set to 0 by an error
							if ($uploadOk == 0) {
								echo "Sorry, your file was not uploaded.\n";
							// if everything is ok, try to upload file
							} else {
								if (move_uploaded_file($_FILES["imgfile"]["tmp_name"], $target_file)) {
									//echo "The file ". basename( $_FILES["imgfile"]["name"]). " has been uploaded.";
									$filename = basename($_FILES["imgfile"]["name"]);
									$img_sql = "UPDATE members SET img_source='$filename' WHERE username='$username'";
									$db->query($img_sql);
									echo "Upload Successful!";
								} else {
									echo "Sorry, there was an error uploading your file.\n";
								}
							}
							echo "<br><br><br><br><a href='profile.php'>Return to Profile. </a><br><br><br><br>";
					
						else:
							header("Location:login.php");
						endif;
 ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>		

    </div>
    <!-- /.container -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; Radford SMIPO 2016</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>