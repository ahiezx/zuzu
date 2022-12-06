<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=zuzu", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

function add_user($fname, $lname, $email, $address, $postcode, $city) {
  global $conn;
  $sql = "INSERT INTO customer (firstname, lastname, email, address, postcode, city) VALUES (:fname, :lname, :email, :address, :postcode, :city)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':fname', $fname);
  $stmt->bindParam(':lname', $lname);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':address', $address);
  $stmt->bindParam(':postcode', $postcode);
  $stmt->bindParam(':city', $city);
  $stmt->execute();
  return true;
}

function get_sushi() {
  global $conn;
  $sql = "SELECT * FROM sushi";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function get_sushi_by_id($id) {
  global $conn;
  $sql = "SELECT * FROM sushi WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}


?>