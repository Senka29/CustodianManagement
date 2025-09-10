<?php
include "../../connect/connection.php"; // DB connection

// By default just select all records
$result = $conn->query("SELECT * FROM bcp_sms4_assign_history ORDER BY reference_no DESC");
?>