<?php
require_once("yachts.php");

class Yacht
{
    public $title;
    public $id;
    public $description;
    public $price;
    public $features;

    public static function parseFromArray($fields)
    {
        $id = isset($fields["id"]) ? $fields["id"] : 0;
        $title = $fields["title"];
        $description = $fields["description"];
        $price = $fields["price"];
        $features = $fields["features"];
        $features = explode('; ', $features);
        return new Yacht($title, $description, $price, $features, $id);
    }

    public function __construct($title, $description, $price, $features, $id)
    {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->features = $features;
        $this->id = $id;
    }
}
