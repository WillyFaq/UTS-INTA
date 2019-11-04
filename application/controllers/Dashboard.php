<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function index()
	{
		$json = array(
						'selular.id' => array(
												'xiaomi' 	=> json_decode(file_get_contents("./assets/json/selular.id-xiaomi.json")),
												'ausus' 	=> json_decode(file_get_contents("./assets/json/selular.id-asus.json")),
												'oppo' 		=> json_decode(file_get_contents("./assets/json/selular.id-oppo.json")),
												'samsung' 	=> json_decode(file_get_contents("./assets/json/selular.id-samsung.json")),
												'vivo' 		=> json_decode(file_get_contents("./assets/json/selular.id-vivo.json")),
												)
						);
		$data = array(
						'page'		=> 'dashboard_view',
						'json'		=> $json
						);
		$this->load->view('index', $data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */