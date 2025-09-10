<?php
include "assign_process.php"; // process file
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Assign Equipment</title>
  <link rel="stylesheet" href="../../../css/assign_trans/assign/assign_trans.css"> <!-- your css -->
  <link rel="stylesheet" href="../../../css/assign_trans/assign/modal.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <script src="/CustodianManagement/js/auto_suggest/assign_trans/search_user.js"></script>
  <link rel="stylesheet" href="../../../css/auto_suggest/auto_suggest.css">
  <!-- Your custom JS -->
</head>
<body>
  <div class="container">
    <h2>Assign Equipment</h2>
    <form action="assign_process.php" method="POST">
      <label>Item Tag:</label>
      <input type="text" name="equipment_id" placeholder="Enter Item Tag" required>

      <label>Item Name:</label>
      <input type="text" name="equipment_name" placeholder="Enter Item Name" required>

      <label>Quantity:</label>
      <input type="number" name="quantity" placeholder="Enter Quantity" required>

      <label>Name:</label>
      <input type="text" id="userName" name="name" placeholder="Enter Name">

      <label>Employee ID:</label>
      <input type="text" id="userId" name="user_id" placeholder="Enter Employee ID">

      <label>Department:</label>
      <input type="text" id="userDept" name="department" placeholder="Enter Department">

      <label>Remarks:</label>
      <textarea name="remarks"></textarea>

      <button type="submit">Assign Equipment</button>
    </form>
  </div>
  <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <h3>Assign Successfully!</h3>
            <p>Reference: <strong id="reference_no"></strong></p>
            <button class="close-btn" onclick="closeModal()">OK</button>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById("successModal").style.display = "none";
            // Remove ?success=1 from URL without reloading
            window.history.replaceState({}, document.title, "assign.php");
        }

        // Show modal if success flag exists
        <?php if (isset($_GET['success']) && isset($_GET['reference'])): ?>
            document.getElementById("reference_no").textContent = "<?= $_GET['reference'] ?>";
            document.getElementById("successModal").style.display = "block";
        <?php endif; ?>
    </script>
</body>
</html>
