<?php
session_start();
include "../../connect/connection.php";
include "code_generator.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $category = $_POST["category"];
    $box = $_POST["box"];
    $quantity = $_POST["quantity"];
    $expiration = $_POST["expiration"];

    // Step 1: Insert asset with NULL tag
    $sql = "INSERT INTO bcp_sms4_consumable (name, category, box, quantity, expiration, asset_tag) 
            VALUES ('$name', '$category', '$box', '$quantity', '$expiration', NULL)";

    if ($conn->query($sql) === TRUE) {
        $id = $conn->insert_id;

        // Step 2: Generate unique asset tag from ID
        $asset_tag = generateAssetTag($id);

        // Step 3: Update the row with the tag
        $conn->query("UPDATE bcp_sms4_consumable SET asset_tag='$asset_tag' WHERE id=$id");

        // Redirect back to registration page with modal flag
        header("Location: register_asset.php?success=1&tag=$asset_tag");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
