<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Source_satu extends CI_Controller {


	var $json = [];


	public function __construct()
	{
		parent::__construct();
		$this->json = $this->get_data();
	}

	public function index()
	{
		$data = array(
						'page'		=> 'source_view',
						'tittle'	=> 'Source 1 : seluar.id',
						'json'		=> $this->json,
						'attr'		=> $this->gen_atribute()
						);
		$this->load->view('index', $data);
	}

	public function show_data()
	{
		$attr = [];
		foreach ($this->input->post() as $key => $value) {
			array_push($attr, $key);
		}
		array_push($attr, 'Aksi');
		$data = array(
				'page'		=> 'source_view',
				'tittle'	=> 'Source 1 : seluar.id',
				'json'		=> $this->json,
				'attr'		=> $this->gen_atribute(),
				'attr_sel'	=> $attr,
				'table'		=> $this->gen_table($attr),
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

	public function gen_table($attr)
	{
		
		$tmpl = array(  'table_open'    => '<table class="table table-striped table-hover dataTable">',
				'row_alt_start'  => '<tr>',
				'row_alt_end'    => '</tr>'
			);

		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading($attr);


		$data = [];
		foreach ($this->json as $key => $value) {
			foreach ($value as $k => $v) {
				$dd = [];
				foreach ($attr as $a => $b) {
					if($b=='Tags'){
						$tag = $v->$b;
						unset($tag[0]);
						$dd['Tags'] = join(",", $tag);
					}else if($b=='Aksi'){
						$dd['Aksi'] = '<input type="checkbox" class="form-control" id="chb-'.$key.'_'.$k.'" name="data[]" value="'.$key.'_'.$k.'">';
					}else if($b=='Content'){
						$dd['Content'] = '<p class="review-txt" id="rev-'.$key.'_'.$k.'">';
                        $dd['Content'] .= $v->$b;
                        $dd['Content'] .= '</p><a href="#" class="read_more" data-view="0" data-id="'.$key.'_'.$k.'">Read More</a>';
					}else{
						$dd[$b] = $v->$b;
					}
				}
				array_push($data, $dd);
				$this->table->add_row($dd);
			}
		}
		//print_r($data);
		return $this->table->generate();	
	}

	public function get_data()
	{
		$data = array(
						'xiaomi' 	=> json_decode(file_get_contents("./assets/json/selular.id-xiaomi.json")),
						'asus' 		=> json_decode(file_get_contents("./assets/json/selular.id-asus.json")),
						'oppo' 		=> json_decode(file_get_contents("./assets/json/selular.id-oppo.json")),
						'samsung' 	=> json_decode(file_get_contents("./assets/json/selular.id-samsung.json")),
						'vivo' 		=> json_decode(file_get_contents("./assets/json/selular.id-vivo.json")),
						);
		return $data;
	}




	public function show_hasil()
	{
		$sel_attribut = [];
		foreach ($this->input->post('attr') as $key => $value) {
			array_push($sel_attribut, $value);
		}
		$pdata = [];
		$idata = [];
		foreach ($this->input->post('data') as $key => $value) {
			array_push($idata, $value);
			$a = explode("_", $value);
			$merk = $a[0];
			$i = $a[1];
			foreach ($sel_attribut as $c => $d) {
				$pdata[$key][$d] = $this->json[$merk][$i]->$d;
			}
		}
		$row = [];
		if($this->input->post('tokenizing')){
			$row = $this->tokenizing($pdata);
		}else if($this->input->post('case_folding')){
			$a = $this->tokenizing($pdata);
			$row = $this->case_folding($a);
		}else if($this->input->post('hapus_tanda_baca')){
			$a = $this->tokenizing($pdata);
			$b = $this->case_folding($a);
			$row = $this->hapus_tanda_baca($b);
		}else if($this->input->post('hapus_emoticon')){
			$a = $this->tokenizing($pdata);
			$b = $this->case_folding($a);
			$row = $this->hapus_tanda_baca($b);
		}else if($this->input->post('hapus_kata_tanya')){
			$a = $this->tokenizing($pdata);
			$b = $this->case_folding($a);
			$c = $this->hapus_tanda_baca($b);
			$row = $this->hapus_kata_tanya($c);
		}else if($this->input->post('stopword_removed')){
			$a = $this->tokenizing($pdata);
			$b = $this->case_folding($a);
			$c = $this->hapus_tanda_baca($b);
			$d = $this->hapus_kata_tanya($c);
			$row = $this->stopword_removed($d);
		}else if($this->input->post('stemming')){
			$a = $this->tokenizing($pdata);
			$b = $this->case_folding($a);
			$c = $this->hapus_tanda_baca($b);
			$d = $this->hapus_kata_tanya($c);
			$e = $this->stopword_removed($d);
			$row = $this->stemming($e);
		}
		$hasil_attr = $sel_attribut; 
		array_push($sel_attribut, 'Aksi');
		$data = array(
				'page'		=> 'source_view',
				'tittle'	=> 'Source 1 : seluar.id',
				'json'		=> $this->json,
				'attr'		=> $this->gen_atribute(),
				'attr_sel'	=> $sel_attribut,
				'table'		=> $this->gen_table($sel_attribut),
				'idata'		=> $idata,
				'hasil'		=> $this->gen_table_hasil($hasil_attr, $row),
				);

		$this->load->view('index', $data);
	}

	public function gen_table_hasil($sel_attribut, $row)
	{
		$tmpl = array(  'table_open'    => '<table class="table table-striped table-hover">',
				'row_alt_start'  => '<tr>',
				'row_alt_end'    => '</tr>'
			);

		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading($sel_attribut);
		foreach ($row as $key => $value) {
			$in_row = [];
			foreach ($value as $k => $v) {
				//array_push($in_row, $v);
				$in_row[$k] = join("<br>", $v);
			}
			$this->table->add_row($in_row);
		}
		return $this->table->generate();
	}

	public function tokenizing($data)
	{

		$ret = [];
		foreach ($data as $key => $value) {
			foreach ($value as $a => $b) {
				$ret[$key][$a] = preg_split('/[\s]+/', $b); 
				/*$token = strtok($b, " ");
				$i = 0;
				while ($token !== false){
					//$ret[$key][$a] = $token; 
				   	//echo "$token<br>";
					$ret[$key][$a][$i] = $token; 
				   	$i++;
				   	$token = strtok(" ");
			   	}*/
			}	
		}

		return $ret;
	}

	public function case_folding($data)
	{	
		$ret = [];
		foreach ($data as $key => $value) {
			foreach ($value as $a => $b) {
				if(!is_array($b)){
					$ret[$key][$a] = strtolower($b); 
				}else{
					foreach ($b as $c => $d) {
						$ret[$key][$a][$c] = strtolower($d);	
					}
				}
			}	
		}	
		return $ret;	
	}

	public function hapus_tanda_baca($data)
	{
		$ret = [];
		foreach ($data as $key => $value) {
			foreach ($value as $a => $b) {
				if(!is_array($b)){
					$ret[$key][$a] = preg_replace('/[^\p{L}\p{N}\s]/u', '', $b);
				}else{
					foreach ($b as $c => $d) {
						$ret[$key][$a][$c] = preg_replace('/[^\p{L}\p{N}\s]/u', '', $d);	
					}
				}
			}	
		}	
		return $ret;	
	}

	public function hapus_kata_tanya($data)
	{
		$stopword_arr = json_decode(file_get_contents("./assets/json/stopwords_id.json"));	
		$ret = $data;
		foreach ($data as $a => $b) {
			foreach ($b as $c => $d) {
				foreach ($d as $e => $f) {
					if(in_array($f, $stopword_arr)){
						unset($ret[$a][$c][$e]);
					}
				}
			}
		}
		return $ret;
	}

	public function stopword_removed($data)
	{
		$stopWordRemoverFactory = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
		$ret = $data;
		$stopword = $stopWordRemoverFactory->createStopWordRemover();
		foreach ($data as $a => $b) {
			foreach ($b as $c => $d) {
				foreach ($d as $e => $f) {
					if($stopword->remove($f)==''){
						unset($ret[$a][$c][$e]);
					}
				}
			}
		}
		return $ret;
	}

	public function stemming($data)
	{
		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$ret = $data;
		$stemmer = $stemmerFactory->createStemmer();
		foreach ($data as $a => $b) {
			foreach ($b as $c => $d) {
				foreach ($d as $e => $f) {
					$ret[$a][$c][$e] = $stemmer->stem($f);
				}
			}
		}
		return $ret;
	}

}


//preg_replace('/[^\p{L}\p{N}\s]/u', '', $string)
/* End of file Source1.php */
/* Location: ./application/controllers/Source1.php */