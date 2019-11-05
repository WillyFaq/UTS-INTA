<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Text_preprocessing
{
	
	function tes_hoo()
	{
		return "HOHOHOHO";
	}

	function tokenizing($data)
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

	function case_folding($data)
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

	function hapus_tanda_baca($data)
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

	function hapus_kata_tanya($data)
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

	function stopword_removed($data)
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

	function stemming($data)
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

/* End of file Text_preprocessing.php */
/* Location: ./application/libraries/Text_preprocessing.php */
