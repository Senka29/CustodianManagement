<?php
include "../../connect/connection.php"; // connection file
include "reference_generator.php"; // reference generator
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment_id   = $_POST['equipment_id'];
    $equipment_name = $_POST['equipment_name'];
    $quantity = $_POST['quantity'];
    $custodian_id   = $_POST['user_id'];      
    $custodian_name = $_POST['name'];         
    $department     = $_POST['department'];   
    $remarks        = $_POST['remarks'];
    $assigned_by    = "admin"; // replace with session user later

    // End any existing assignment for this equipment
    $sql = "UPDATE bcp_sms4_assign_history 
            SET end_date = NOW() 
            WHERE equipment_id = ? AND end_date IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $equipment_id);
    $stmt->execute();

    // Insert new assignment with reference number
    $sql = "INSERT INTO bcp_sms4_assign_history 
            (reference_no, equipment_id, equipment_name, quantity, custodian_id, custodian_name, department_code,
             assigned_date, remarks, assigned_by) 
            VALUES ( NULL, '$equipment_id', '$equipment_name', '$quantity', '$custodian_id', '$custodian_name', 
            '$department', NOW(), '$remarks', '$assigned_by')";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param(
    //     "sisisssss",
    //     $reference_no,
    //     $equipment_id,
    //     $equipment_name,
    //     $quantity,
    //     $custodian_id,
    //     $custodian_name,
    //     $department,
    //     $remarks,
    //     $assigned_by
    // );

    if ($conn->query($sql) === TRUE) {
        $id = $conn->insert_id;

        // Step 2: Generate unique asset tag from ID
        $reference_no = generateReferenceNo($id);

        // Step 3: Update the row with the tag
        $conn->query("UPDATE bcp_sms4_assign_history SET reference_no='$reference_no' WHERE id=$id");

        // Redirect back to registration page with modal flag
        header("Location: assign.php?success=1&reference=$reference_no");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
