<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');    
   
class Vclaim {  
	public $bpjs_config;
    public function __construct() {      
        $this->CI =& get_instance();         
        $this->CI->load->helper('url');
        $this->CI->config->item('base_url');     
        $this->CI->load->model('bpjs/Mbpjs','',TRUE);
        $this->bpjs_config = $this->CI->Mbpjs->get_data_bpjs();		
    }  

    public function get($param,$content_type) 
    {    	
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();  
		$signature = hash_hmac('sha256', $this->bpjs_config->consid . '&' . $timestamp, $this->bpjs_config->secid, true);
		$encoded_signature = base64_encode($signature);			
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: ' . $content_type,
		   'X-cons-id: ' . $this->bpjs_config->consid,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
	  							
		$ch = curl_init($this->bpjs_config->service_url . $param);	
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);  		
		return $result;
    }

    public function post($param,$content_type,$data) 
    {    	
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();  
		$signature = hash_hmac('sha256', $this->bpjs_config->consid . '&' . $timestamp, $this->bpjs_config->secid, true);
		$encoded_signature = base64_encode($signature);			
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: ' . $content_type,
		   'X-cons-id: ' . $this->bpjs_config->consid,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
	  							
		$ch = curl_init($this->bpjs_config->service_url . $param);	
		curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);  		
		return $result;
    }

    public function delete($param,$content_type,$data) 
    {    	
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();  
		$signature = hash_hmac('sha256', $this->bpjs_config->consid . '&' . $timestamp, $this->bpjs_config->secid, true);
		$encoded_signature = base64_encode($signature);			
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: ' . $content_type,
		   'X-cons-id: ' . $this->bpjs_config->consid,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
	  							
		$ch = curl_init($this->bpjs_config->service_url . $param);	
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);          
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);  		
		return $result;
    }

}  
?>