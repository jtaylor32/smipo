<!DOCTYPE html>
<html lang="en">
<!-- SMIPO Search Display
	@author James

 -->
<?php
require("connect.php");

if(empty($_SESSION)) // if the session not yet started 
    session_start();

$status = $_SESSION['status'];
$user = $_SESSION['user'];

$query = $_POST['query'];
/* Sanitize the query */
$query = htmlspecialchars($query);
$query = stripslashes($query);
$query = mysql_real_escape_string($query);
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Forums - SMIPO</title>

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
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center"> 
						<?php echo "<p>Search Results</p><br />";?>
                    </h2>
                    <hr>
                </div>
                <div class="row">
				<!-- main content area -->
						<div id="boards" >
							<?php
                                if($status>0):
    								/* Get threads */
    								$sql2 = "SELECT * FROM (SELECT * FROM Topics INNER JOIN Replies ON thread_id = topic_id) AS q " .
                                    "WHERE q.reply_content LIKE '%" . $query . "%' ORDER BY topic_id";
    								$result2 = $db->query($sql2);
                                else:
                                    $sql2 = "SELECT * FROM (SELECT * FROM Topics INNER JOIN Replies ON thread_id = topic_id) AS q " .
                                    "WHERE q.reply_content LIKE '%" . $query . "%' AND q.topic_cat = 'General Discussion' ORDER BY topic_id";
                                    $result2 = $db->query($sql2);
                                endif;
								/* set up table headers */
								echo "<table class='table forum table-striped'>";
								echo "<thead><tr>";
								echo "<th class='cell-stat text-center hidden-xs hidden-sm'> Date </strong> </th>";
								echo "<th class='cell-stat text-center hidden-xs hidden-sm'> Topic </strong> </th>";
								echo "<th class='cell-stat-2x hidden-xs hidden-sm'> Original Poster </strong> </th>";
								echo "</tr></thead><tbody>";
								/* end table headers */
								
								/* pull threads from database and display */
								while($threads = $result2->fetchRow()) {
									echo "<tr>";
									echo "<td class='text-center'>" . $threads['topic_date'] . "</td>";
									echo "<td class='text-center hidden-xs hidden-sm'>" . "<a href='thread.php?board=" . $threads['board_id'] . "&thread=" . 
									$threads['topic_id'] . "&page=0'>" . $threads['topic_subject'] . "</a></td>";
									echo "<td class='hidden-xs'>" . $threads['topic_by'] . "</td>";
									echo "</tr>";
								}
								echo "</tbody></table>";
								
							?>
							<div class="clearfix"></div>
						</div>
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
