<?php
// Vars for PDO connection
$host = "localhost";
$user = "phpmyadmin";
$pass = "chickenWingsandFries123!";
$dbname = "rensselaer_list";
// PDO Connection
try {
    $dbconn = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo $exception->getMessage();
}
try {
    $selected_subcategory_id = $_POST['subcategory'];
    $query = "SELECT subcategory2, id FROM subcategories2 WHERE subcategoryid = '$selected_subcategory_id'";
    $stmt = $dbconn->prepare($query);
    $stmt->execute();
    $json_data = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    echo $json_data;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>