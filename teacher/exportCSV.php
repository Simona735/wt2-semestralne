<?php
require_once "../Controllers/TestGradingController.php";

if (isset($_POST["type"]) && $_POST["type"] == "exportCSV") {
    $id = explode("-", $_POST["id"])[1];
    $result = (new TestGradingController())->getStudentsPerTest($id);
    $f = fopen('php://output', 'a');

    foreach ($result as $item) {
        $surname = "";
        $array = explode(" ", $item["name"]);
        for($i = 0; $i < sizeof($array)-1; $i++){
            $surname .= $array[$i];
        }
        $name = end($array);
        fputcsv($f, [$item["IDStudent"], $name, $surname, $item["score"]]);
    }

    fclose($f);
}

?>
