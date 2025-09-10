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
        <input type="text" name="name" placeholder="Asset Name" required>
        <input type="text" name="category" placeholder="Category" required>
        <input type="text" name="quantity" placeholder="quantity" required>
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
