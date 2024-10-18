<?php
include_once "Controllers/Controller.php";

class Controller_footer extends Controller {

    public function action_QSN() {
        // Code pour afficher la vue QSN
        return $this->render('view_qsn');
    }
    public function action_FAQ() {
        // Code pour afficher la vue FAQ
        return $this->render('view_faq');
    }

    public function action_RGPD() {
        // Code pour afficher la vue RGPD
        return $this->render('view_rgpd');
    }

    public function action_default() {
        $this->action_RGPD();
    }
}
?>
