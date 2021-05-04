<?php
require_once "config.php";

class Database {
    private $conn;

    public function getConnection(): ?PDO
    {
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $exception){
            echo "Database could not be connected: " . $exception->getMessage();
        }

        return $this->conn;
    }

    public function deleteQuestion($question_ID){
        $deleteQuestion = $this->conn->prepare("delete from question where ID = :question_ID");
        $deleteQuestion->bindValue("question_ID", $question_ID);
        $deleteShortAns = $this->conn->prepare("delete from short_ans where question_ID = :question_ID");
        $deleteShortAns->bindValue("question_ID", $question_ID);
        $deleteMoreAns = $this->conn->prepare("delete from more_ans where question_ID = :question_ID");
        $deleteMoreAns->bindValue("question_ID", $question_ID);
        $deletePairsAns = $this->conn->prepare("delete from pair_ans where question_ID = :question_ID");
        $deletePairsAns->bindValue("question_ID", $question_ID);
        try {
            $deleteShortAns->execute();
            $deleteMoreAns->execute();
            $deletePairsAns->execute();
            $deleteQuestion->execute();
        } catch (Exception $e) {
            returnAlert($e);
        }
    }
}


