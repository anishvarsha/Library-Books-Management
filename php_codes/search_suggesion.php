<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = 'root';
$dbName = 'Library';
//connect with the database
$db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
//get search term
$searchTerm = $_GET['term'];
//get matched data from skills table
$query = $db->query("SELECT  B.TITLE, B.ISBN13, A.NAME FROM BOOK B,authors A, book_authors BA WHERE (B.TITLE LIKE '%" . $searchTerm  . "%' OR A.NAME LIKE '%" . $searchTerm  . "%' OR B.ISBN13 LIKE '%" . $searchTerm . "%') AND B.ISBN13 = BA.ISBN13 AND BA.AUTHOR_ID = A.AUTHOR_ID ORDER BY TITLE ASC");

while ($row = $query->fetch_assoc()) {
    $data[] = $row['TITLE'];
}
//return json data
echo json_encode($data);
?>