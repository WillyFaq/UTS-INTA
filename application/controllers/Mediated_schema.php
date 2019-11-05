<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mediated_schema extends CI_Controller {

	var $json = [];

	public function __construct()
	{
		parent::__construct();

		$this->json = $this->get_data();
	}

	public function index()
	{
		$data = array(
						'page'		=> 'mediated_view',
						'tittle'	=> 'Mediated Schema',
						'json'		=> $this->json,
						//'attr'		=> $this->gen_atribute(),
						'form'		=> 'Mediated_schema'
						);
		$this->load->view('index', $data);
	}

	public function gen_atribute()
	{
		$ret = "";
		$attr = ['DatePost', 'Author', 'Title', 'Content', 'Tags'];
		foreach ($attr as $key => $value) {
			$ret .= '<div class="form-group">';
                $ret .= '<label for="'.$value.'" class="col-sm-4 control-label">'.$value.'</label>';
                $ret .= '<div class="col-sm-2">';
                    $ret .= '<input type="checkbox" class="form-control" id="chb_'.$value.'" name="'.$value.'" >';
                $ret .= '</div>';
            $ret .= '</div>';
		}
		return $ret;
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
		$data = array(
						'twitter'	=> $twitter,
						'seluar.id'	=> $seluar,
					);
		return $data;
	}
}

/* End of file Mediated_schema.php */
/* Location: ./application/controllers/Mediated_schema.php */