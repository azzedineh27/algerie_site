<?php 
require_once "Utils/credentials.php";
require_once "Models/Model_algerie.php";
class Utilisateur {
    private $bd;

    public function __construct($bd) {
        $this->bd = $bd;
    }
 
}


