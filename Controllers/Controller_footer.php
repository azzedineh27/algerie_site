<?php
include_once "Controllers/Controller.php";

class Controller_footer extends Controller {

    public function action_CONTACT() {
        // Code pour afficher la vue QSN
        return $this->render('view_contact');
    }
    public function action_FAQ() {
        // Code pour afficher la vue FAQ
        return $this->render('view_faq');
    }
    public function action_RGPD() {
        // Code pour afficher la vue RGPD
        return $this->render('view_rgpd');
    }

    public function action_AVIS() {
        // Code pour afficher la vue AVIS
        return $this->render('view_avis');
    }

    public function action_default() {
        $this->action_contact();
    }
}
?>
