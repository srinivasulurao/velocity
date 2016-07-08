<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class VelocityWebModel extends CI_Model
{
    public function __construct()
    {
        //error_reporting(0);
        parent::__construct();
        $this->load->database();

    }

    public function createResumeSnapshot_Model($user_id,$heximage){
     
	   	    $image_URL=$this->HexaDecimalToImage($heximage);
			$data=array('resume_snapshot'=>$image_URL,'user_id'=>$user_id);
			$this->db->insert('resume_snapshots',$data);	
 
    $data['resume_snapshot']=base_url($image_URL);
    $data['snap_id']=$this->db->insert_id();
	return $data;									
		              
    }



    public function HexaDecimalToImage($haxaString)
    {			
			$destFolderName="./uploads/images/resume";			
			$destFileName = $destFolderName."/".uniqid() . '.png';			
			$hex =  preg_replace('/[\s\W]+/','',$haxaString);
			$binary = @pack("H*", $hex);
			$success = file_put_contents($destFileName, $binary);

			if($success===false){
				@unlink($destFileName);
				return false;
			}else{
				$fullImageURL = str_replace('./uploads/', '/uploads/', $destFileName);
				return $fullImageURL;
			}	
    }

public function hexImageSave($haxaString,$folder_name)
    {           
            $destFolderName="./uploads/images/$folder_name";          
            $destFileName = $destFolderName."/".uniqid() . '.png';          
            $hex =  preg_replace('/[\s\W]+/','',$haxaString);
            $binary = @pack("H*", $hex);
            $success = file_put_contents($destFileName, $binary);

            if($success===false){
                @unlink($destFileName);
                return false;
            }else{
                $fullImageURL = str_replace('./uploads/', '/uploads/', $destFileName);
                return $fullImageURL;
            }   
    }

    public function getAllResumeSnapshots_Model(){
    	$results=$this->db->get("resume_snapshots");
    	return $results->result_array();
    }

public function getUserProfileInfo_Model($user_id){

	    $this->db->where('user_id',$user_id);
        $results=$this->db->get("user_accounts");
    	return $results->result_array();

}

public function login_Model($username,$password,$lat,$lng,$user_type){


        $query="select * from user_accounts WHERE username='$username' AND password='$password' AND user_type='$user_type'";
        $result=$this->db->query($query);
        
        if($result->num_rows()){
            $result=$this->db->query($query);
            $result_data=$result->result_array();
            $this->updataUserLocation($result_data[0]['user_id'],$lat,$lng);
            $data=preFormat($result_data);
        }
        else{
            $data=customFormat(false,401,$this->verboseMessages(401),"Invalid Credentials, you seem to have entered a wrong credentials, or you don't have an account in our system !");
        }

        return $data;
}

public function updataUserLocation($user_id,$lat,$lng){
    $this->db->query("UPDATE user_accounts SET latitude='$lat', longitude='$lng' WHERE user_id='$user_id'");
}

public function createAccount_Model($rd){
    
    $insert['username']=$rd['username'];
    $insert['password']=$rd['password'];
    $insert['first_name']=$rd['first_name'];
    $insert['last_name']=$rd['last_name'];
    $insert['personal_email']=$rd['email'];
    $insert['user_type']=$rd['user_type'];

    $this->db->insert('user_accounts',$insert);
    $last_insert_id=$this->db->insert_id();

    if($last_insert_id > 0){
       $result=$this->db->query("select * from user_accounts WHERE user_id='$last_insert_id'");
       $data=customFormat(true,201,$this->verboseMessages(201),$result->result_array());
    }
    else{
        $data=customFormat(false,401,$this->verboseMessages(401),"Database Transaction Error, Please try again later");
    }

    return $data;
}

public function updateAccount_Model(){

    $update_keys=array();
    $update_keys[]="username";
    $update_keys[]="last_name"; 
    $update_keys[]="first_name";   
    $update_keys[]="password";     
    $update_keys[]="business_email";     
    $update_keys[]="personal_email";     
    $update_keys[]="address";     
    $update_keys[]="city";     
    $update_keys[]="state";     
    $update_keys[]="zip";     
    $update_keys[]="current_occupation";     
    $update_keys[]="previous_occupation";     
    $update_keys[]="certifications";     
    $update_keys[]="education";     
    $update_keys[]="associations";     
    $update_keys[]="networks";     
    $update_keys[]="interests";     
    $update_keys[]="phone_number";     
    $update_keys[]="social_media";     
    $update_keys[]="user_type";     
    $update_keys[]="latitude";     
    $update_keys[]="longitude"; 
    $update_keys[]="public_profile";    

    $update=array();
    foreach($update_keys as $key):
      if($_GET['$key'])  
      $update[$key]=$_GET[$key];
    endforeach; 
    $this->db->where("user_id",$_GET['user_id']);
    $this->db->update("user_account",$update);

    if ($this->db->trans_status() === TRUE)
        {
            $data=$data=preFormat($this->getProfile_Model($_GET['user_id']));
        }
        else{
            $data=customFormat(false,401,$this->verboseMessages(401),"Database Transaction Error, Please try again later");
        }

    return $data;
}

public function getUserProfileWithinRadius_Model($radius,$public_profile,$lat,$lng,$user_type){
     $sql1="SELECT *, (
        3959 * acos (
          cos ( radians({$lat}) )
          * cos( radians( latitude ) )
          * cos( radians( longitude ) - radians({$lng}) )
          + sin ( radians({$lat}) )
          * sin( radians( latitude ) )
        )
      ) AS distance
    FROM user_accounts
    WHERE public_profile='$public_profile' 
    OR user_type='user'
    HAVING distance <= '$radius'
    ORDER BY distance
    LIMIT 0 , 100;";

  $sql2="SELECT *, (
        3959 * acos (
          cos ( radians({$lat}) )
          * cos( radians( latitude ) )
          * cos( radians( longitude ) - radians({$lng}) )
          + sin ( radians({$lat}) )
          * sin( radians( latitude ) )
        )
      ) AS distance
    FROM jobs
    HAVING distance <= '$radius'
    ORDER BY distance
    LIMIT 0 , 100;";

  $sql=($user_type=='user')?$sql2:$sql1;

  $result=$this->db->query($sql);
  return $result->result_array();
}

public function getProfile_Model($user_id){
    $result=$this->db->query("SELECT * FROM user_accounts WHERE user_id='$user_id'");
    return $result->result_array();
}

public function getJob_Model($job_id){
    $result=$this->db->query("SELECT * FROM jobs WHERE job_id='$job_id'");
    return $result->result_array();
}

public function updateUserProfileImage_Model($user_id,$image_data){
            
    $image_URL=$this->hexImageSave($image_data,"profile");   
    
    $update['profile_image']=base_url($image_URL);

    $this->db->where('user_id',$user_id);
    $this->db->update("user_accounts",$update);

    if ($this->db->trans_status() === TRUE)
        {
            $data=$data=preFormat($this->getProfile_Model($user_id));
        }
        else{
            $data=customFormat(false,401,$this->verboseMessages(401),"Database Transaction Error, Please try again later");
        }


    return $data;

}

public function verboseMessages($status){
    $vb=array();
    $vb['200']="OK  The request is OK (this is the standard response for successful HTTP requests)";
    $vb['201']="Created The request has been fulfilled, and a new resource is created"; 
    $vb['202']="Accepted    The request has been accepted for processing, but the processing has not been completed";
    $vb['203']="Non-Authoritative Information   The request has been successfully processed, but is returning information that may be from another source";
    $vb['204']="No Content  The request has been successfully processed, but is not returning any content";
    $vb['205']="Reset Content   The request has been successfully processed, but is not returning any content, and requires that the requester reset the document view";
    $vb['206']="Partial Content The server is delivering only part of the resource due to a range header sent by the client";
    
    $vb['400']="Bad Request The request cannot be fulfilled due to bad syntax";
    $vb['401']="Unauthorized    The request was a legal request, but the server is refusing to respond to it. For use when authentication is possible but has failed or not yet been provided";
    $vb['402']="Payment Required    Reserved for future use";
    $vb['403']="Forbidden   The request was a legal request, but the server is refusing to respond to it";
    $vb['404']="Not Found   The requested page could not be found but may be available again in the future";
    $vb['405']="Method Not Allowed  A request was made of a page using a request method not supported by that page";
    $vb['406']="Not Acceptable  The server can only generate a response that is not accepted by the client";
    $vb['407']="Proxy Authentication Required   The client must first authenticate itself with the proxy";
    $vb['408']="Request Timeout The server timed out waiting for the request";
    $vb['409']="Conflict    The request could not be completed because of a conflict in the request";
    $vb['410']="Gone    The requested page is no longer available";
    $vb['411']="Length Required The 'Content-Length' is not defined. The server will not accept the request without it"; 
    $vb['412']="Precondition Failed The precondition given in the request evaluated to false by the server";
    $vb['413']="Request Entity Too Large    The server will not accept the request, because the request entity is too large";
    $vb['414']="Request-URI Too Long    The server will not accept the request, because the URL is too long. Occurs when you convert a POST request to a GET request with a long query information"; 
    $vb['415']="Unsupported Media Type  The server will not accept the request, because the media type is not supported"; 
    $vb['416']="Requested Range Not Satisfiable The client has asked for a portion of the file, but the server cannot supply that portion";
    $vb['417']="Expectation Failed  The server cannot meet the requirements of the Expect request-header field";
    
    return $vb[$status];
}


} // Class Ends here.

?>
