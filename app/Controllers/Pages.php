<?php

class Pages extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function page() {
       // $this->login_redirect();
        
        include $this->view . 'pages/page.php';
    }
    
    public function ajax_dashboard(){
        
    }
}
