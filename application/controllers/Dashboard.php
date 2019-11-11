<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function index()
	{
		$data = array(
						'page'		=> 'dashboard_view',
						'json'		=> $this->get_data()
						);
		$this->load->view('index', $data);
	}



	public function get_data()
	{
		$seluar = array(
						'xiaomi' 	=> json_decode(file_get_contents("./assets/json/selular.id-xiaomi.json")),
						'asus' 		=> json_decode(file_get_contents("./assets/json/selular.id-asus.json")),
						'oppo' 		=> json_decode(file_get_contents("./assets/json/selular.id-oppo.json")),
						'samsung' 	=> json_decode(file_get_contents("./assets/json/selular.id-samsung.json")),
						'vivo' 		=> json_decode(file_get_contents("./assets/json/selular.id-vivo.json")),
						);
		$twitter = array(
						'xiaomi' 	=> json_decode(file_get_contents("./assets/json/tweet_xiaomi.json")),
						'asus' 		=> json_decode(file_get_contents("./assets/json/tweet_asus.json")),
						'oppo' 		=> json_decode(file_get_contents("./assets/json/tweet_oppo.json")),
						'samsung' 	=> json_decode(file_get_contents("./assets/json/tweet_samsung.json")),
						'vivo' 		=> json_decode(file_get_contents("./assets/json/tweet_vivo.json")),
						);
		$sel = [];
		foreach ($seluar as $k => $v) {
			for($i=0; $i<20; $i++){
				$sel[$k][$i] = $v[$i];
			}
		}
		$data = array(
						'twitter'	=> $twitter,
						'seluar.id'	=> $sel,
					);
		return $data;
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */