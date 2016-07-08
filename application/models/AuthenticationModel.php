<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class AuthenticationModel extends CI_Model
{
    public function __construct()
    {
        //error_reporting(0);
        parent::__construct();
        $this->load->database();

    }

    public function authenticateLogin(){

        $username=$this->input->post('username');
        $password=$this->input->post('password');
        $user_data=array();

        if($username && $password){
            $results=$this->db->query("SELECT * FROM user_accounts WHERE username='$username' AND password='$password' AND user_type='employer'");
            if($results->num_rows()){
                $data_fetched=$results->result_array();
                 foreach($data_fetched[0] as $key=>$value):
                     $user_data[$key]=$value;
                 endforeach;
                //debug($user_data);
                $this->session->set_userdata($user_data);
                $this->session->set_userdata('success_message',"Login Successfull, Redirecting to your profile !");
            }
            else{
                $this->session->set_userdata('error_message',"You seem to have entered a wrong credential !");
            }
        }

    }

} // Authentication Model Class Ends here.
?>