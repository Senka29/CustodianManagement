<?php
include "history_process.php"; // process file
include "get_rows.php"; // get total rows
$result = $conn->query("SELECT * FROM bcp_sms4_assign_history ORDER BY reference_no DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Custodian History</title>
  <link rel="stylesheet" href="../../../css/table_size.css">
  <link rel="stylesheet" href="../../../css/asset_reg/list_assets.css">
  <script src="../../../js/assign_trans/history/history.js"></script>
</head>
<body>
  <div class="container">
    <h2>Custodian History</h2>
    <input type="text" id="search" placeholder="Search..." onkeyup="searchTable()">
    <div class="card">
         <h2><?= $total_assets ?> Total Rows</h2>
    </div>

    <table>
      <thead>
        <tr>
          <th>Reference No</th>
          <th>Equipment ID</th>
          <th>Equipment Name</th>
          <th>Quantity</th>
          <th>Custodian ID</th>
          <th>Custodian Name</th>
          <th>Department</th>
          <th>Assigned Date</th>
          <th>End Date</th>
          <th>Remarks</th>
          <th>Assigned By</th>
        </tr>
      </thead>
      <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['reference_no'] ?></td>
                    <td><?= $row['equipment_id'] ?></td>
                    <td><?= $row['equipment_name'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= $row['custodian_id'] ?></td>
                    <td><?= $row['custodian_name'] ?></td>
                    <td><?= $row['department_code'] ?></td>
                    <td><?= $row['assigned_date'] ?></td>
                    <td><?= $row['end_date'] ?></td>
                    <td><?= $row['remarks'] ?></td>
                    <td><?= $row['assigned_by'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
      </tbody>
    </table>
  </div>
</body>
</html>