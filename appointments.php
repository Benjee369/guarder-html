<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title></title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap2.min.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
</head>

<body>
    <header class="header_section">
        <?php
        require_once'nvbr.php'; 
        ?>
    </header>
    <div class="main-wrapper">
        <!-- side bar thing -->
        <?php
        require_once'side-bar.php';
        ?>
        <!-- end side bar thing -->
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Manage all the Reports</h4>
                    </div>
                </div>
                <div class="sort_reports">
                    <a href="appointments.php?filter=all">All Reports</a>
                    <a href="appointments.php?filter=unassigned">Unassigned Reports</a>
                    <a href="appointments.php?filter=assigned">Assigned Reports</a>
                    <a href="appointments.php?filter=closed">Closed Reports</a>
                    <a href="appointments.php?filter=inprogress">In Progress Reports</a>
                </div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped custom-table">
								<thead>
									<tr>
										<th>Report ID</th>
										<th>Reporter Name</th>
										<th>Number of People Involved</th>
										<th>Assigned Officer</th>
										<th>Incident Category</th>
										<th>Submission Time</th>
										<th>Wittnessed Time</th>
										<th>Priority Level</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>									
                                <?php
                                    require_once 'DatabaseConn.php';

                                    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

                                    switch ($filter) {
                                        case 'unassigned':
                                            $query = "SELECT * FROM crimereports WHERE ID NOT IN (SELECT ReportID FROM assignments)";
                                            break;
                                        case 'assigned':
                                            $query = "SELECT * FROM crimereports WHERE ID IN (SELECT ReportID FROM assignments)";
                                            break;
                                        case 'closed':
                                            $query = "SELECT * FROM crimereports WHERE ID IN (SELECT ReportID FROM assignments WHERE Status = 'Closed')";
                                            break;
                                        case 'inprogress':
                                            $query = "SELECT * FROM crimereports WHERE ID IN (SELECT ReportID FROM assignments WHERE Status = 'In Progress')";
                                            break;
                                        default:
                                            $query = "SELECT * FROM crimereports";
                                    }

                                    $stmt = $conn->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        $incident_reports = $result->fetch_all(MYSQLI_ASSOC);
                                        foreach ($incident_reports as $incident_report) {
                                            echo '<tr>';
                                            echo '<td>';
                                            echo '<h2><a href="Manage_Users.php">' . $incident_report['ID'] . '</a></h2>';
                                            echo '</td>';

                                            echo '<td>';
                                            echo '<h2><a href="profile.html">' . $incident_report['First_Name'] . ' ' . $incident_report['Last_Name'] . '</a></h2>';
                                            echo '</td>';

                                            echo '<td>';
                                            echo '<p>' . $incident_report['People_Involved'] . '</p>';
                                            echo '</td>';

                                            echo '<td>';
                                            echo '<p>' . $incident_report['CurrentDate'] . '</p>';
                                            echo '</td>';

                                            echo '<td>';
                                            echo '<p>' . $incident_report['Incident_Category'] . '</p>';
                                            echo '</td>';

                                            echo '<td>';
                                            echo '<p>' . $incident_report['CurrentDate'] . '</p>';
                                            echo '</td>';

                                            echo '<td>';
                                            echo '<p>' . $incident_report['WitnessedDate'] . '</p>';
                                            echo '</td>';

                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<p class="no_review">No Reviews available at the moment,<br>
                                        Be the first To leave a Review.</p>';
                                    }
                                    $stmt->close();
                                    $conn->close();
                                ?>
								</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>
            <!-- <div class="notification-box">
                <div class="msg-sidebar notifications msg-noti">
                    <div class="topnav-dropdown-header">
                        <span>Messages</span>
                    </div>
                    <div class="topnav-dropdown-footer">
                        <a href="chat.html">See all messages</a>
                    </div>
                </div>
            </div> -->
		</div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>