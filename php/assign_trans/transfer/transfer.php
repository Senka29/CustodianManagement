<?php
include "transfer_process.php"; // process file
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Transfer Equipment</title>
  <link rel="stylesheet" href="../../../css/assign_trans/assign_trans.css">
</head>
<body>
  <div class="container">
    <h2>Transfer Equipment</h2>
    <form action="transfer_process.php" method="POST">
      <label>Reference No:</label>
      <input type="text" name="reference_no" placeholder="Ex: REF-20250910-XYZ12" required>

      <label>New Custodian ID:</label>
      <input type="text" name="custodian_id" placeholder="Employee ID" required>

      <label>New Custodian Name:</label>
      <input type="text" name="custodian_name" placeholder="Employee Name" required>

      <label>Remarks:</label>
      <textarea name="remarks"></textarea>

      <button type="submit">Transfer Equipment</button>
    </form>
  </div>
</body>
</html>
