<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller
{

    public function __construct()
    {

        error_reporting(~E_NOTICE); // Only serious errors are shown.
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
        $this->load->helper('velocity');
        //$this->load->library('table');
        $this->load->model('authenticationModel', 'auth', true);

    }

    public function index()
    {
        $this->load->view('Home');

    }

    public function login(){
        $this->data['Title']="Login to Velocity !";
        $this->auth->authenticateLogin();
        $this->load->view('authentication/login');
        $this->session->unset_userdata(array('error_message','success_message'));
    }


} // Authentication class ends here.
?>