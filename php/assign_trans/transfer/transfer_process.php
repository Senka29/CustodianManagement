<?php
include "../../connect/connection.php"; // connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reference_no = $_POST['reference_no']; // <-- capture from form
    $new_custodian_id = $_POST['custodian_id'];
    $new_custodian_name = $_POST['custodian_name'];
    $department = $_POST['department_code'];
    $remarks = $_POST['remarks'];
    $assigned_by = "admin"; // replace with session user later

    // 1. Verify reference exists and get equipment info
    $sql = "SELECT equipment_id, equipment_name 
            FROM bcp_sms4_assign_history 
            WHERE reference_no = ? 
            ORDER BY assigned_date DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $reference_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        die("Invalid reference number");
    }

    $equipment_id = $row['equipment_id'];
    $equipment_name = $row['equipment_name'];

    // 2. End the current assignment
    $sql = "UPDATE bcp_sms4_assign_history 
            SET end_date = NOW() 
            WHERE equipment_id = ? AND end_date IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $equipment_id);
    $stmt->execute();

    // 3. Insert new assignment (transfer) with same reference
    $sql = "INSERT INTO bcp_sms4_assign_history 
            (reference_no, equipment_id, equipment_name, custodian_id, custodian_name, assigned_date, department_code, remarks, assigned_by) 
            VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisissss", $reference_no, $equipment_id, $equipment_name, $new_custodian_id, $new_custodian_name, $department, $remarks, $assigned_by);

    if ($stmt->execute()) {
        echo "Equipment transferred successfully under Reference: " . $reference_no;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
