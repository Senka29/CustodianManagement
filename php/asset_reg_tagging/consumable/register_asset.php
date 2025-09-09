<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Asset Registry</title>
    <link rel="stylesheet" href="../../../css/asset_reg/register_asset.css">
    <link rel="stylesheet" href="../../../css/modal.css">
</head>
<body>
    <h2>Register New Asset</h2>

    <!-- Back Button -->
    <a href="list_assets.php" class="btn">&larr; Back to Asset List</a>

    <form method="POST" action="save_asset.php">
        <input type="text" name="name" placeholder="Asset Name" required>
        <input type="text" name="category" placeholder="Category" required><br><br>
        <p class="input">Note: The box and quantity is optional but if you make 
            a mistake you can just edit it in "List Of School Consumable Assets"</p><br><br>
        <input type="number" name="box" placeholder="Box">
        <input type="number" name="quantity" placeholder="Quantity"><br><br>
        <label class="input1">Expiration Date:</label>
        <input type="date" name="expiration" required>
        <button type="submit">Save Asset</button>
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
