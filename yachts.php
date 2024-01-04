<?php
require_once("yacht.php");

class Yachts
{
    const dsn = "mysql:host=127.0.0.1;port=10000;dbname=yacht_club";
    const user = "root";
    const pass = "";
    const yachtsTable = "yachts";

    private static $instance;

    private $db;

    public static function get()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Yachts();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->db = new PDO(Yachts::dsn, Yachts::user, Yachts::pass);
    }

    function findYacht($id)
    {
        $foundYacht = $this->db->query("SELECT * FROM " . Yachts::yachtsTable . " WHERE id=$id")->fetch(PDO::FETCH_ASSOC);
        if (!isset($foundYacht)) {
            http_response_code(404);
            include("not_found.html");
            die();
        }
        return Yacht::parseFromArray($foundYacht);
    }

    function addYacht(Yacht $yacht)
    {
        $features = implode("; ", $yacht->features);
        $this->db->query(
            "INSERT INTO " . Yachts::yachtsTable . "(title, description, price, features) 
                    VALUES (
                            '$yacht->title', 
                            '$yacht->description', 
                            '$yacht->price', 
                            '$features'
                    )"
        );
    }

    function updateYacht(Yacht $yacht)
    {
        $features = implode("; ", $yacht->features);
        $this->db->query(
            "UPDATE " . Yachts::yachtsTable . " SET 
                title = '$yacht->title', 
                description = '$yacht->description', 
                price = '$yacht->price', 
                features = '$features' 
                WHERE id = $yacht->id"
        );
    }

    function getAll()
    {
        $yachts = array();
        $dbYachts = $this->db->query("SELECT * FROM " . Yachts::yachtsTable)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($dbYachts as $yachtColumns) {
            $yachts[] = Yacht::parseFromArray($yachtColumns);
        }
        return $yachts;
    }

    function deleteYacht($id)
    {
        $this->db->query("DELETE FROM " . Yachts::yachtsTable . " WHERE id=$id");
    }
}
