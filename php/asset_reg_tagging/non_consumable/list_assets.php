<?php
include "../../connect/connection.php";
include "edit_botton_list.php"; // to funtion edit button
include "edit_modal.php";   // to show modal
include "get_rows.php"; // to get $total_assets
include "delete_asset.php"; // to funtion delete button
$result = $conn->query("SELECT * FROM bcp_sms4_asset ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Asset List</title>
    <link rel="stylesheet" href="../../../css/table_size.css">
    <link rel="stylesheet" href="../../../css/asset_reg/list_assets.css">
    <script src="../../../js/asset_reg_tagging/list_assets.js"></script>
    
    <script>
        function searchAssets() {
            let input = document.getElementById("search").value.toLowerCase();
            let rows = document.querySelectorAll("table tbody tr");
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(input) ? "" : "none";
            });
        }
    </script>
</head>
<body>
    <h2>List Of School Non-Consumable Assets</h2>

    <!-- Show success message if redirected from save -->
    <?php if (isset($_GET['success'])): ?>
        <div class="success">
             Asset <strong><?=$_GET['tag']?></strong> added successfully!
        </div>
    <?php endif; ?>

    <!-- Add New Asset Button -->
    <a href="register_asset.php" class="btn">+ Add New Asset</a>

    <!-- Search -->
    <input type="text" id="search" placeholder="Search assets..." onkeyup="searchAssets()">
    <div class="card">
         <h2><?= $total_assets ?> Total Rows</h2>
    </div>


    <table>
        <thead>
            <tr>
                <th>Tag</th>
                <th>Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Active</th>
                <th>In Repair</th>
                <th>Disposed</th>
                <th>Date Added</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['asset_tag'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['category'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= $row['active'] ?></td>
                    <td><?= $row['in_repair'] ?></td>
                    <td><?= $row['disposed'] ?></td>
                    <td><?= $row['purchase_date'] ?></td>
                    <td style="display:flex; gap:8px;">
                    <button class="btn_table"
                        data-asset_tag="<?= $row['asset_tag'] ?>"
                        data-active="<?= $row['active'] ?>"
                        data-in_repair="<?= $row['in_repair'] ?>" 
                        data-disposed="<?= $row['disposed'] ?>" 
                        onclick="openEditModal(this)">
                        Edit
                    </button> 
                    <form method="POST" action="delete_asset.php" style="margin:0;" onsubmit="return confirmDelete(this);">
                        <input type="hidden" name="asset_tag" value="<?= $row['asset_tag'] ?>">
                        <button type="submit" class="btn-delete">Drop</button>
                    </form>
                </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <script>
    function confirmDelete(form) {
        // Show a custom modal instead of local confirm()
        document.getElementById("confirmModal").style.display = "block";

        // Handle confirm button
        document.getElementById("confirmYes").onclick = function() {
            form.submit(); // now submit the form
        };

        // Cancel just closes the modal
        document.getElementById("confirmNo").onclick = function() {
            document.getElementById("confirmModal").style.display = "none";
        };

        return false; // prevent immediate submit
    }
    </script>

<!-- Example confirm modal -->
<div id="confirmModal" class="modal">
  <div class="modal-content">
    <p>Are you sure you want to delete this asset?</p>
    <button id="confirmYes">Yes</button>
    <button id="confirmNo">No</button>
  </div>
</div>
</body>
</html>
