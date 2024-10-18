<?php
require_once 'Utils/credentials.php';
require_once "Models/Utilisateur.php";  
require_once 'Models/Model_algerie.php';

class Controller_connexion extends Controller {
    public function action_CONNECT() {
        return $this->render('view_connexion');
    }

    public function action_ESPACE() {
        
        return $this->render('view_espace');
    }

    public function action_INSCRIPTION(){
        return $this->render('view_inscription'); 
    }

    public function action_RESET(){
        return $this->render('view_reset'); 
    }

    public function action_default() {
        $this->action_CONNECT();
    }
}
?>
