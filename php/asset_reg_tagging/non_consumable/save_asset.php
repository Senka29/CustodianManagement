<?php
session_start();
include "../../connect/connection.php";
include "code_generator.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $category = $_POST["category"];
    $quantity = $_POST["quantity"];
    $purchase_date = $_POST["purchase_date"];

    // Step 1: Insert asset with NULL tag
    $sql = "INSERT INTO bcp_sms4_asset (name, category, quantity, purchase_date, asset_tag) 
            VALUES ('$name', '$category', '$quantity', '$purchase_date', NULL)";

    if ($conn->query($sql) === TRUE) {
        $id = $conn->insert_id;

        // Step 2: Generate unique asset tag from ID
        $asset_tag = generateAssetTag($id);

        // Step 3: Update the row with the tag
        $conn->query("UPDATE bcp_sms4_asset SET asset_tag='$asset_tag' WHERE id=$id");

        // Redirect back to registration page with modal flag
        header("Location: register_asset.php?success=1&tag=$asset_tag");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
