<?php


// Include Connectdatabase
require_once("database_connection.php");

$query = "SELECT * FROM tbl_sample";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll();

$totalrow = $stmt->rowcount();


$output = "<table class='table table-striped table-bordered text-center'>
<tr>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Edit</th>
    <th>Delete</th>
</tr>";
if ($totalrow > 0) {
    # code...
    foreach ($result  as $row) :
        $output .= "
<tr>
<td>" . $row['first_name'] . "</td>
<td>" . $row['last_name'] . "</td>
 <td>
 <button name='edit' class='btn btn-info  edit' id='" . $row['id'] . "'>Edit</button></td>
<td><button name='delete' class='btn btn-danger delete' id='" . $row['id'] . "'>Delete</button></td>
</tr>
";
    endforeach;
} else {
    $output .= "
    <tr> 
    <td colspan='4' class='bg-danger'> No data Faound </td>
    </tr>";
}
$output .= "</table>";

echo $output;
