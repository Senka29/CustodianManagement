<?php
include "../../connect/connection.php"; // DB connection
include "reference_generator.php";      // reference generator

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment_id   = $_POST['equipment_id'];   // asset_tag
    $equipment_name = $_POST['equipment_name']; // name
    $quantity       = (int)$_POST['quantity'];
    $custodian_id   = $_POST['user_id'];
    $custodian_name = $_POST['name'];
    $department     = $_POST['department'];
    $remarks        = $_POST['remarks'];
    $assigned_by    = "admin"; // TODO: replace with session user later

    // 1. Validate stock availability
    $sql = "SELECT quantity, active FROM bcp_sms4_asset WHERE asset_tag = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $equipment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $asset = $result->fetch_assoc();

    if (!$asset) {
        die("Error: Asset not found in inventory.");
    }

    if ($asset['quantity'] < $quantity) {
        die("Error: Not enough stock available. Current stock: " . $asset['quantity']);
    }

    // 2. Update inventory: subtract from quantity, add to active
    $sql = "UPDATE bcp_sms4_asset 
            SET quantity = quantity - ?, active = active + ? 
            WHERE asset_tag = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $quantity, $quantity, $equipment_id);
    $stmt->execute();

    // 3. Insert into assignment history
    $sql = "INSERT INTO bcp_sms4_assign_history 
            (reference_no, equipment_id, equipment_name, quantity, custodian_id, custodian_name, department_code,
             assigned_date, remarks, assigned_by) 
            VALUES (NULL, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisssss",
        $equipment_id,
        $equipment_name,
        $quantity,
        $custodian_id,
        $custodian_name,
        $department,
        $remarks,
        $assigned_by
    );
    $stmt->execute();

    $id = $conn->insert_id;

    // 4. Generate reference number and update row
    $reference_no = generateReferenceNo($id);
    $sql = "UPDATE bcp_sms4_assign_history SET reference_no = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $reference_no, $id);
    $stmt->execute();

    // 5. Redirect back with modal
    header("Location: assign.php?success=1&reference=$reference_no");
    exit();
}
?>
