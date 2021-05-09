<?php
session_start();

if (isset($_POST["type"]) && $_POST["type"] == "exportCSV") {
    $id = explode("-", $_POST["id"])[1];
    $result = $_SESSION["students"];
    $f = fopen('php://output', 'a');

    foreach ($result as $item) {
        $surname = explode(" ", $item["name"])[0];
        $name = explode(" ", $item["name"])[1];
        fputcsv($f, [$item["IDStudent"], $name, $surname, $item["score"]]);
    }

    fclose($f);
}

?>
