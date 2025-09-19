<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Asset Registry</title>
    <link rel="stylesheet" href="../../../css/asset_reg/register_asset.css">
    <link rel="stylesheet" href="../../../css/modal.css">
    <script src="../../../js/get_current_time.js"></script>
</head>
<body>
    <h2>Register New Asset</h2>

    <!-- Back Button -->
    <a href="list_assets.php" class="btn">&larr; Back to Asset List</a>

    <form method="POST" action="save_asset.php">
        <label class="input1">Item Name:</label>
        <input type="text" name="name" placeholder="Enter Asset Name" required>
        <label class="input1">Category:</label>
        <input type="text" name="category" placeholder="Enter Category" required>
        <p class="input">Note: The box and quantity is optional but if you make 
            a mistake you can just edit it in "List Of School Consumable Assets"</p><br><br>
        <label class="input1">Box:</label>
        <input type="number" name="box" placeholder="Enter Box">
        <label class="input1">Quantity:</label>
        <input type="number" name="quantity" placeholder="Enter Quantity">
        <label class="input1">Quantity per box:</label>
        <input type="number" name="per_box" placeholder="Enter How many Quantity per box"><br><br>
        <label class="input1">Expiration Date:</label>
        <input type="date" name="expiration" required>
        <button type="submit" onclick="saveClientTime()" id="status">Save Asset</button>
    </form>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <h3>Asset Added Successfully!</h3>
            <p>Tag: <strong id="assetTag"></strong></p>
            <button class="close-btn" onclick="closeModal()">OK</button>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById("successModal").style.display = "none";
            // Remove ?success=1 from URL without reloading
            window.history.replaceState({}, document.title, "register_asset.php");
        }

        // Show modal if success flag exists
        <?php if (isset($_GET['success']) && isset($_GET['tag'])): ?>
            document.getElementById("assetTag").textContent = "<?= $_GET['tag'] ?>";
            document.getElementById("successModal").style.display = "block";
        <?php endif; ?>
    </script>
</body>
</html>
