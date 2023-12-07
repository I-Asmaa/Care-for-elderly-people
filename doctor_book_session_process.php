<?php
$page_title = "حجز جلسه جديدة";
?>

<?php include 'header.php'; ?>

<?php
if ($_SESSION ['user_type'] != "doctor") {
	header ( "Location: index.php" );
	die ();
}
?>

<?php
if (isset ( $_GET ['patient_id'] )) {
	// session vars
	$date = $_GET ['date'];
	$time = $_GET ['time'];
	$patient_id = $_GET ['patient_id'];
	$doctor_id = $_SESSION ['user_id'];
	
	// insert query for session
	$query = "INSERT INTO session (date, time, doctor_id, patient_id, status) VALUES ('$date', '$time', '$doctor_id', '$patient_id', 'تمت الموافقة')";
	
	$session_result = mysql_query ( $query ) or die ( "Can't add this session " . mysql_error () );
	
	// if there is affected rows in the database;
	if (mysql_affected_rows () == 1) {
		// send notification to the patient
		mysql_query ("INSERT INTO notification (content, patient_id) VALUES ('لقد تم حجز موعد جديد من قبل الطبيب الخاص بك من فضلك قم بالاطلاع عليه', '$patient_id')") or die ("error send notification " . mysql_error ());

		echo "<script>alert('تم حجز الجلسة  بنجاح');</script>";
		echo "<meta http-equiv='Refresh' content='0; url=doctor_show_sessions.php'>";
	} else {
		echo "<script>alert('حدث خطأ أثناء الحجز');</script>";
		echo "<meta http-equiv='Refresh' content='0; url=doctor_show_sessions.php'>";
	}
}
?>

<?php include 'footer.php';?>