<!DOCTYPE html>
<html>
<head>
    <title>Edit Asset</title>
    <link rel="stylesheet" href="../../../css/asset_reg/modal.css">
    <script>
        // Function to close modal
        function closeModal(id) {
            document.getElementById(id).style.display = "none";
        }

        // Function to open modal
        function openModal(id) {
            document.getElementById(id).style.display = "block";
        }
    </script>
</head>
<body>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h2>Edit Asset</h2>
            <p class="input">Note: If you input a number make sure when you add</p>
            <p class="input">the Active, In Repair, and Disposed it should be equal</p>
            <p class="input">to Quantity, if not your input will be invalid.</p>

            <form method="POST" action="edit_botton_list.php">
                <input type="hidden" name="asset_tag" id="editAssetTag">

                <label class="input1">Active:</label><br><br>
                <input type="number" name="active" id="editActive"><br><br>

                <label class="input1">In Repair:</label><br><br>
                <input type="number" name="in_repair" id="editInRepair"><br><br>

                <label class="input1">Disposed:</label><br><br>
                <input type="number" name="disposed" id="editDisposed"><br><br>

                <button type="submit" class="close-btn">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Example of calling message modal -->
    <?php
if (!function_exists("renderMessageModal")) {
    function renderMessageModal($id, $title, $message) {
        ?>
        <div id="<?= $id ?>" class="modal" style="display:block;">
            <div class="modal-content">
                <span class="close" onclick="window.location.href='list_assets.php'">&times;</span>
                <h2><?= $title ?></h2>
                <p><?= $message ?></p>
                <button class="close-btn" onclick="window.location.href='list_assets.php'">OK</button>
            </div>
        </div>
        <?php
    }
}
?>

</body>
</html>
