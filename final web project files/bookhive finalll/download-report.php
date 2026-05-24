<?php
include "db.php"; // your DB connection file

$type = $_GET['type'] ?? 'csv';

header("Cache-Control: no-cache, must-revalidate");

function fetchTable($conn, $table){
    $data = [];
    $res = mysqli_query($conn, "SELECT * FROM $table");
    while($row = mysqli_fetch_assoc($res)){
        $data[] = $row;
    }
    return $data;
}

$tables = [
  "members" => fetchTable($conn, "members"),
  "books" => fetchTable($conn, "books"),
  "issued_books" => fetchTable($conn, "issued_books"),
  "returned_books" => fetchTable($conn, "returned_books")
];

if($type === "csv" || $type === "excel"){
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=library_report.csv");

    $out = fopen("php://output", "w");

    foreach($tables as $name => $rows){
        fputcsv($out, [$name]);
        if(!empty($rows)){
            fputcsv($out, array_keys($rows[0]));
            foreach($rows as $r){
                fputcsv($out, $r);
            }
        }
        fputcsv($out, []);
    }
    fclose($out);
    exit;
}

if($type === "pdf"){
    echo "<h2>Library Report</h2>";
    foreach($tables as $name => $rows){
        echo "<h3>$name</h3><table border='1' cellpadding='5'>";
        if(!empty($rows)){
            echo "<tr>";
            foreach(array_keys($rows[0]) as $col){
                echo "<th>$col</th>";
            }
            echo "</tr>";
            foreach($rows as $r){
                echo "<tr>";
                foreach($r as $v){
                    echo "<td>$v</td>";
                }
                echo "</tr>";
            }
        }
        echo "</table><br>";
    }
    echo "<script>window.print()</script>";
}
?>
