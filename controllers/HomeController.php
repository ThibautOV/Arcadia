<?php


require_once 'model/Database.php';
require_once 'NoSql.php';

class HomeController
{
    private $db;
    private $noSql;

    public function __construct($db)
    {
        $this->db = $db;
        $this->noSql = new NoSql();
    }

    public function index()
    {

        $habitats = $this->getHabitats();




        include 'public/views/home/index.php';
    }

    private function getHabitats()
    {
        $stmt = $this->db->prepare("SELECT id, name, description, image_url FROM habitats");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
