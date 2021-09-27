<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once("Secure_area.php");
class Beranda extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->helper('pdf_helper');

	}
	
	public function index()
	{
		$data['title'] = 'Beranda';
		$this->load->view('rsvberanda',$data);
		
	}
	
	public function load_pdf($link)
	{
		echo '<script type="text/javascript">window.open("'.site_url("beranda/load/$link").'", "");window.focus();</script>';
		$data['title'] = 'Beranda';
		$this->load->view('rsvberanda',$data);
	}
	
	public function load($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'doc/'.$link));
	}
}

?>