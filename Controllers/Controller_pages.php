<?php
include_once "Controllers/Controller.php";

class Controller_pages extends Controller {

    public function action_VISA() {
        // Code pour afficher la vue QSN
        return $this->render('view_visa');
    }
    public function action_default() {
        $this->action_VISA();
    }
}
?>
