<html>
    <body>
    <form method="post" action="search.php">
    <!-- Your input fields go here -->
    <tr>
        <th>Employee no</th>
        <th>
            <input type="text" name="txtid" id="txtid" placeholder="Enter Emp no" required>
            <button type="submit" name="btnsearch">Search</button>
        </th>
    </tr>
</form>

</body>
    </html>
<?php
include('dbconnect.php');

if(isset($_POST['btnsearch'])) {
    $empNo = $_POST['txtid'];

    $query = "SELECT basic_salary FROM tblsalary WHERE emp_id = '$empNo'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $basicSalary = $row["basic_salary"];
        }
    } else {
        echo "No results found";
    }
}
?>
