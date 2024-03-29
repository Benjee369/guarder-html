<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <title>Manage Users</title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap2.min.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
</head>
<body>
    <!-- nav2 -->
    <header class="header_section">
    <?php
    require_once'nvbr.php'; 
    ?>
    </header>
        <!-- nav2 end -->
    <div class="main-wrapper">
        <!-- side bar thing -->
        <?php
        require_once 'side-bar.php';
        ?>
        <!-- end side bar thing -->

        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <?php
                        if (isset($_SESSION['admin_email'])) {
                            echo "<p>Welcome, " . $_SESSION['admin_email'] . "</p>";
                        }
                        ?>
                </div>
				
				<div class="row">
					<div class="main-card-thing">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title d-inline-block">View and Manage Users</h4>
							</div>
							<div class="user_details">
                            <?php
                        require_once 'DatabaseConn.php';

                        $query = "SELECT *
                    FROM userdetails";
                    

                    $stmt = $conn->prepare($query);
                    $stmt->execute();

                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $user_details = $result->fetch_all(MYSQLI_ASSOC);
                        foreach ($user_details as $user_detail) {
                            echo '<div class="u_details">';
                            echo '<h1>'.$user_detail['First_Name'] . ' ' . $user_detail['Last_Name'] .'</h1>';
                            echo '<hr class="line-thing">';
                            echo '<p>'."<b>Email: </b>".''.$user_detail['Email_Address'].'</p>';
                            echo '<hr class="line-thing">';
                            echo '<p>'."<b>Phone Number: </b>".''.$user_detail['Phone_Number'].'</p>';
                            echo '<hr class="line-thing">';
                            echo '<p>'."<b>Location: </b>".''.$user_detail['Address'].'</p>';
                            echo '<a class="btn btn-outline-primary take-btn">Block User</a>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p class="no_review">No Reviews available at the moment,<br>
                        Be the first To leave a Review.</p>';
                    }
                    $stmt->close();
                    $conn->close();            
                    ?>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</body>
</html>