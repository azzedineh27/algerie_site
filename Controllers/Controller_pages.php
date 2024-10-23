<?php
include_once "Controllers/Controller.php";

class Controller_pages extends Controller {

    public function action_VISA() {
        // Code pour afficher la vue VISA
        return $this->render('view_visa');
    }

    public function action_GRATUIT() {
        // Code pour afficher la vue GRATUIT
        return $this->render('view_visa_gratuit');
    }

    public function action_LOTERIE() {
        // Code pour afficher la vue LOTERIE
        return $this->render('view_loterie');
    }

    public function action_PRESSE() {
        // Code pour afficher la vue PRESSE
        return $this->render('view_presse');
    }

    public function action_CULTURE() {
        // Code pour afficher la vue CULTURE
        return $this->render('view_culture');
    }
    public function action_default() {
        $this->action_VISA();
    }
}
?>
