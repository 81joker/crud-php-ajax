<?php



// Include Connectdatabase
require_once("database_connection.php");



if (isset($_POST["action"])) {
    if ($_POST["action"] == "insert") {
        $query = "
		INSERT INTO tbl_sample (first_name, last_name) VALUES ('" . $_POST["first_name"] . "', '" . $_POST["last_name"] . "')
		";
        $statement = $conn->prepare($query);
        $statement->execute();
        echo '<p>Data Inserted...</p>';
    };



    if ($_POST['action'] == 'fetch_single') {
        $query = "SELECT * FROM tbl_sample WHERE id = '" . $_POST["id"] . "' ";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $output['first_name'] = $row['first_name'];
            $output['last_name'] = $row['last_name'];
        }
        echo json_encode($output);
    }

    if ($_POST['action'] == 'update') {
        $query = "UPDATE tbl_sample SET first_name = '" . $_POST["first_name"] . "', last_name = '" . $_POST["last_name"] . "'  WHERE id = '" . $_POST["hidden_id"] . "' ";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        echo '<p>Data Updated...</p>';
    }
    if ($_POST['action'] == 'delete') {
        $query = "DELETE FROM tbl_sample WHERE id = '" . $_POST["id"] . "'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        echo '<p>Data Deleted...</p>';
    }
}
