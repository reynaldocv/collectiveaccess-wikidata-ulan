<?php
/* ----------------------------------------------------------------------
 * app/plugins/ULAN/controllers/ImportController.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This source code is free and modifiable under the terms of
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */

require_once(__CA_MODELS_DIR__.'/ca_entities.php');
require_once(__CA_MODELS_DIR__.'/ca_objects.php');
require_once(__CA_LIB_DIR__.'/Search/EntitySearch.php');
require_once(__CA_LIB_DIR__.'/Search/SetSearch.php');
#require_once(__CA_LIB_DIR__.'/ca/Search/EntitySearch.php');

class ImportController extends ActionController {
	# -------------------------------------------------------
	/**
	 *
	 */
	protected $opo_config;		// plugin configuration file

	# -------------------------------------------------------
	# Constructor
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
		// Set view path for plugin views directory
		if (!is_array($pa_view_paths)) { $pa_view_paths = array(); }
		$pa_view_paths[] = __CA_APP_DIR__."/plugins/wikiulan/themes/views/";

		// Load plugin configuration file
		$this->opo_config = Configuration::load(__CA_APP_DIR__.'/plugins/wikiulan/conf/wikiulan.conf');

		parent::__construct($po_request, $po_response, $pa_view_paths);

		/*if (!$this->request->user->canDoAction('can_import_ulan')) {
			$this->response->setRedirect($this->request->config->get('error_display_url').'/n/3000?r='.urlencode($this->request->getFullUrlPath()));
			return;
		}

		// Load plugin stylesheet*/
		MetaTagManager::addLink('stylesheet', __CA_URL_ROOT__."/app/plugins/wikiulan/themes/css/wikiulan.css",'text/css');
		
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function Index() {
		$this->render("index.php");
	}


	public function WikiRoboto() {
		$o_search = new EntitySearch();
		$o_items = $o_search->search('*'); 

		$this->view->setVar('items', $o_items);
		$this->view->setVar('option', "WIKI");
		
		$this->render("roboto.php");
	}
	
	public function Birthday() {
		$o_search = new EntitySearch();
		$o_items = $o_search->search('*'); 

		$this->view->setVar('items', $o_items);		
		$this->render("allBirthday.php");
	}

	public function UlanRoboto() {
		$o_search = new EntitySearch();
		$o_items = $o_search->search('*'); 

		$this->view->setVar('items', $o_items);
		$this->view->setVar('option', "ULAN");
		
		$this->render("roboto.php");
	}

	public function WikiBirthday() {
		$o_search = new EntitySearch();
		$o_items = $o_search->search('*'); 

		$this->view->setVar('items', $o_items);
		$this->view->setVar('option', "WIKI");

		
		$this->render("birthday.php");
	}

	public function UlanBirthday() {
		$o_search = new EntitySearch();
		$o_items = $o_search->search('*'); 

		$this->view->setVar('items', $o_items);
		$this->view->setVar('option', "ULAN");
		
		$this->render("birthday.php");
	}

	public function WikiLista() {
		$o_search = new EntitySearch();
		$o_items = $o_search->search('*'); 

		$this->view->setVar('items', $o_items);
		$this->view->setVar('option', "WIKI");
		
		$this->render("lista.php");
	}

	public function UlanLista() {
		$o_search = new EntitySearch();
		$o_items = $o_search->search('*'); 

		$this->view->setVar('items', $o_items);
		$this->view->setVar('option', "ULAN");
		
		$this->render("lista.php");
	}

	public function Lista() {
		$o_search = new EntitySearch();
		$o_items = $o_search->search('*'); 

		$this->view->setVar('items', $o_items);
		
		$this->render("lista.php");
	}

	public function ShowAll() {
		$o_search = new EntitySearch();		
		
		$o_items = $o_search->search("*");

		$this->view->setVar('items', $o_items);
		
		$this->render("all.php");
	}
	
	
	public function ShowProfile() {		
		$id = $this->request->getParameter('idno', pString); 
		$option = $this->request->getParameter('opt', pString); 		

		$o_entity = new ca_entities($id);

		$this->view->setVar('idno', $id);
		$this->view->setVar('item', $o_entity);	
		$this->view->setVar('option', $option);		
		
		$this->render("profile.php");
	}

	public function ShowProfileWikidata() {
		//$obj = new ca_objects('123');
		//$obj-->setMode(ACCESS_WRITE);
		//$abc = $obj-->replaceAttribute(array('attr'=->'NewValue'), 'attr');
		//$obj-->update();

		//$AUTH_CURRENT_USER_ID = 1; 
		$id = $this->request->getParameter('idno', pString); 		

		$o_entity = new ca_entities($id);

		//$o_entity->setMode(ACCESS_WRITE);	

		$this->view->setVar('idno', $id);
		$this->view->setVar('entity', $o_entity);			
		
		$this->render("profilewiki.php");
	}

	public function ModifyBiography() {		
		$o_search = new EntitySearch();
		$qr_result = $o_search->search('*');

		$id = $this->request->getParameter('idno', pString); 
		$newBio = $this->request->getParameter('newBiography', pString); 

		$o_entity = new ca_entities($id);

		//$o_entity->setMode(ACCESS_WRITE);		
		
		$o_entity->replaceAttribute(array('biography' => $newBio),'biography');	
		$o_entity->update();

		$o_entity = new ca_entities($id);

		$this->view->setVar('idno', $id."-".$newBio);
		$this->view->setVar('entity', $o_entity);
		$this->view->setVar('label', $o_entity->get("ca_entities.preferred_labels"));
		
		$this->view->setVar('list', $qr_result);
		
		$this->render("profile.php");
	}
	public function QueryToWikidata(){

		$query = $this->request->getParameter('consulta', pString);

		if (trim($query) == "") 
			$query = "Leornado da vinci";
		
		$query = str_replace(" ","%20", $query);
		// Entity to look up (e.g., Q42 is the Wikidata ID for Douglas Adams)
		//$itemId = 'Q42';

		// Construct the API URL
		//$url = "https://www.wikidata.org/w/api.php?action=wbgetentities&ids=$itemId&format=json";

		$url = "https://www.wikidata.org/w/api.php?action=wbsearchentities&format=json&language=en&search=$query";

		// Set headers for the request
		$options = [
			"http" => [
				"header" => "User-Agent: PHP Wikidata Example"
			]
		];
		$context = stream_context_create($options);

		// Make the HTTP request
		$response = file_get_contents($url, false, $context);

		// Decode the JSON response
		$data = json_decode($response, true);

		//$array = array("results" => $data); 

		$this->view->setVar('results', $data);
		
		$this->render("jsonresult.php");
	}

	public function QueryToULAN(){
		$_text = $this->request->getParameter('consulta', pString);

		$va_search = preg_split('/[\s]+/', $_text);
		$vs_search = join(' AND ', $va_search);

		if (trim($_searchText) == "") 
			$_searchText = "Rafael Sanzio";
		
		$query = 'select ?Subject ?name ?Term ?Parents ?bio {
			?Subject a skos:Concept; luc:term "'.$vs_search.'"; skos:inScheme ulan: ;
			gvp:prefLabelGVP [xl:literalForm ?Term].		  
			{?Subject gvp:parentStringAbbrev ?Parents}				
			{?Subject foaf:focus/gvp:biographyPreferred/schema:description ?bio}
			}';

		$url = 'https://vocab.getty.edu/sparql?query='.urlencode($query) .'&format=json';
	
		//$ch= curl_init();
		
		//curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_USERAGENT, "Google Chrome Browser");
		//curl_setopt($ch, CURLOPT_HEADER, "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8");

		//$data = curl_exec($ch);

		//curl_close($ch);

		$options = [
			"http" => [
				"header" => "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8". 
							"User-agent: Google Chrome Browser"			
			]
		];

		$context = stream_context_create($options);

		// Make the HTTP request
		$response = file_get_contents($url, false, $context);

		// Decode the JSON response
		$data = json_decode($response, true);

		$this->view->setVar('results', $data["results"]["bindings"]);
		
		$this->render("jsonresult.php");
	}

	public function WikipediaLinks(){
		

		$query = $this->request->getParameter('consulta', pString);
		
		if (trim($query) == "") 
			$query = "Q5588";
		
		$query = str_replace(" ","%20", $query);
		// Entity to look up (e.g., Q42 is the Wikidata ID for Douglas Adams)
		//$itemId = 'Q42';

		// Construct the API URL
		//$url = "https://www.wikidata.org/w/api.php?action=wbgetentities&ids=$itemId&format=json";
		//https://www.wikidata.org/wiki/Special:EntityData/Q61965584.json

		//$url = "https://www.wikidata.org/w/api.php?action=wbsearchentities&format=json&language=en&search=$query";
		$url = "https://www.wikidata.org/wiki/Special:EntityData/$query.json";

		// Set headers for the request
		$options = [
			"http" => [
				"header" => "User-Agent: PHP Wikidata Example"
			]
		];
		$context = stream_context_create($options);

		// Make the HTTP request
		$response = file_get_contents($url, false, $context);

		// Decode the JSON response
		$data = json_decode($response, true);

		//$array = array("results" => $data); 

		$this->view->setVar('results', $data["entities"][$query]["sitelinks"]);
		
		$this->render("jsonresult.php");
	}

	public function SaveLinks()
	{	
		try {
			//$query = $this->request->getParameter('consulta', pString);
			//$link = $this->request->getParameter('wikibioText', pString);
			
			$o_item= new ca_entities("1");

			//$o_entity->setMode(ACCESS_WRITE);		
			
			//$attributes = array();

			//$attributes = $o_item->getParameter("webpages");

			//$attributes[] = "Hola.com";

			//$o_entity->replaceAttribute(array('wikibio' =>'https://www.google.com/'),'IDcodes');
			//$o_entity->replaceAttribute(array('ulancode' =>'ulan'),'IDcodes');
			//$o_entity->replaceAttribute(array('wikicode' =>'wiki'),'wikicode');
			
			//$attributes["wikibio"] = "https://www.google.com/";
			//$attributes["wikicode"] = "wiki";
			//$attributes["ulancode"] = "ulan";
			
			//$o_item->getAttribute($arr, 'webpages');
			
			//$o_item->replaceAttribute(array('wikicode' => "jaja1"), 'IDcodes');
			//$o_item->replaceAttribute(array('ulancode' => "jaja2"), 'IDcodes');
			//$o_item->replaceAttribute(array('wikicode' => "jaja1", 'ulancode' => "jaja2"), 'IDcodes');
			//$o_item->replaceAttribute(array('wikicode' => "jaja1"), 'IDcodes.wikicode');
			//$o_item->replaceAttribute(array('ulancode' => "jaja1"), 'IDcodes.ulancode');
			//$arr = getAttribute('IDcodes');
			//$arr["ulancode"] = "ulan"; 
			//$arr["wikicode"] = "wiki"; 


			//$o_item->replaceAttribute($arr, 'IDcodes');

			$o_item->addAttribute(array('wikicode' => "wiki"), 'IDcodes');

			$o_item->addAttribute(array('url'=>"fin.com"), 'webpages'); 
		
			$o_item->update();
			
			$array = array("results" => $arr);			
			$this->view->setVar('results', $array);
			$this->render("jsonresult.php");
			
		
		}
		 catch (Exception $e) {
			$array = array("results" => "Error!!!");			
			$this->view->setVar('results', $array);
			$this->render("jsonresult.php");
		}

		
	}	
	public function SaveData()
	{	
		try {
			$_option = $this->request->getParameter('ioption', pString);
			$_idno = $this->request->getParameter('iidno', pString);

			$_code 		= $this->request->getParameter('icode', pString);			
			$_url  		= $this->request->getParameter('iurl', pString);
			$_comment 	= $this->request->getParameter('icomment', pString);

			//$query = $this->request->getParameter('consulta', pString);
			//$link = $this->request->getParameter('wikibioText', pString);
			
			$item= new ca_entities($_idno);

			//$o_item->addAttribute(array('url'=>$value), 'webpages');

			$ans = "Nenhum dado foi salvado!!!";

			if ($_option == "WIKI")			
			{	
				$link = array("wikicode" => $_code, "wikiurl" => $_url, "wikicomment" => $_comment);
				$o_item->addAttribute($link, 'wiki');	
					
				$o_item->setMode(ACCESS_WRITE);			
				$o_item->update();

				$ans = "The following data <br>"; 
				$ans .= " <b>WIKIcode </b>".$o_item->get("wiki"); 
				$ans .= " <br>was saved! <br>";			
			}

			if ($_option == "ULAN")			
			{	
				$link = array("ulancode" => $_code, "ulanurl" => $_url, "ulancomment" => $_comment);
				$o_item->addAttribute($link, 'ulancode');	
					
				$o_item->setMode(ACCESS_WRITE);			
				$o_item->update();

				$ans = "The following data <br>"; 
				$ans .= " <b>ULANcode </b>".$o_item->get("ulancode"); 
				$ans .= " <br>was saved! <br>";
			}
			
			
			$array = array("results" => $ans);		

			$this->view->setVar('results', $array);
			$this->render("jsonresult.php");			
		
		}
		catch (Exception $e) {
			$array = array("results" => "Error!!!");			
			$this->view->setVar('results', $array);
			$this->render("jsonresult.php");
		}

		
	}	
	public function SaveCodes()
	{	
		try {
			$option = $this->request->getParameter('option', pString);
			$idno = $this->request->getParameter('idno', pString);

			$_code 		= $this->request->getParameter('_code', pString);			
			$_url  		= $this->request->getParameter('_url', pString);
			$_comment 	= $this->request->getParameter('_comment', pString);
			
			$item= new ca_entities($idno);

			if ($option == "WIKI")
			{	
				$newData = array("wikicode" => $_code, "wikiurl" => $_url, "wikicomment" => $_comment);
				$item->replaceAttribute($newData, 'wiki');	
			
			}
			if ($option == "ULAN")
			{
				$newData = array("ulancode" => $_code, "ulanurl" => $_url, "ulancomment" => $_comment);
				$item->replaceAttribute($newData, 'ulan');	
			}	

			$item->setMode(ACCESS_WRITE);			
			$item->update();

			$_results = "No code saved!";
			$_status = "No code saved!";
			$_msg = "No code saved"; 

			if ($option == "WIKI")
			{	
				$_code = $item->get("ca_entities.wiki.wikicode");
				$_url = $item->get("ca_entities.wiki.wikiurl");
				$_info = $item->get("ca_entities.wiki");

				$_results = "<a href='$_url' target='_blank'>$_code</a>";
				$_status = $item->get("ca_entities.wiki.wikicomment");
				$_msg = "Operacion realizada com sucesso...<br> WIKIDATA: $_info";
					
			}
			if ($option == "ULAN")
			{
				$_code = $item->get("ca_entities.ulan.ulancode");
				$_url = $item->get("ca_entities.ulan.ulanurl");
				$_info = $item->get("ca_entities.ulan");

				$_results = "<a href='$_url' target='_blank'>$_code</a>";
				$_status = $item->get("ca_entities.ulan.ulancomment");
				$_msg = "Operacion realizada com sucesso...<br> ULAN: $_info";
				
			}
			
			$array = array("results" => $_results, "status" => $_status, "msg" => $_msg);		
			$this->view->setVar('results', $array);

			$this->render("jsonresult.php");
			
		
		}
		 catch (Exception $e) {
			$array = array("results" => "Error!!!");			
			$this->view->setVar('results', $array);
			$this->render("jsonresult.php");
		}

		
	}
	public function SaveBirthday()
	{	
		try {
			$option = $this->request->getParameter('option', pString);
			$idno = $this->request->getParameter('idno', pString);

			$_code 		= $this->request->getParameter('_code', pString);			
			$_url  		= $this->request->getParameter('_url', pString);
			$_comment 	= $this->request->getParameter('_comment', pString);
			
			$item= new ca_entities($idno);

			if ($option == "WIKI")
			{	
				$newData = array("wikicode" => $_code, "wikiurl" => $_url, "wikicomment" => $_comment);
				$item->replaceAttribute($newData, 'wiki');	
			
			}
			if ($option == "ULAN")
			{
				$newData = array("ulancode" => $_code, "ulanurl" => $_url, "ulancomment" => $_comment);
				$item->replaceAttribute($newData, 'ulan');	
			}	

			$item->setMode(ACCESS_WRITE);			
			$item->update();

			$_results = "No code saved!";
			$_status = "No code saved!";
			$_msg = "No code saved"; 

			if ($option == "WIKI")
			{	
				$_code = $item->get("ca_entities.wiki.wikicode");
				$_url = $item->get("ca_entities.wiki.wikiurl");
				$_info = $item->get("ca_entities.wiki");

				$_results = "<a href='$_url' target='_blank'>$_code</a>";
				$_status = $item->get("ca_entities.wiki.wikicomment");
				$_msg = "Operacion realizada com sucesso...<br> WIKIDATA: $_info";
					
			}
			if ($option == "ULAN")
			{
				$_code = $item->get("ca_entities.ulan.ulancode");
				$_url = $item->get("ca_entities.ulan.ulanurl");
				$_info = $item->get("ca_entities.ulan");

				$_results = "<a href='$_url' target='_blank'>$_code</a>";
				$_status = $item->get("ca_entities.ulan.ulancomment");
				$_msg = "Operacion realizada com sucesso...<br> ULAN: $_info";
				
			}
			
			$array = array("results" => $_results, "status" => $_status, "msg" => $_msg);		
			$this->view->setVar('results', $array);

			$this->render("jsonresult.php");
			
		
		}
		 catch (Exception $e) {
			$array = array("results" => "Error!!!");			
			$this->view->setVar('results', $array);
			$this->render("jsonresult.php");
		}

		
	}	
	public function Test()
	{	
		$this->view->setVar('results', "this is a test...");
		$this->render("jsonresult.php");
	}
	
	public function ShowAllSets() {
		$sql = "select * from ca_sets";
		$o_data = new Db();
		$qr_result_exposicoes = $o_data->query($sql);

		$this->view->setVar('items', $qr_result_exposicoes);
		
		$this->render("sets.php");
	}
	public function ShowSetItems() {	
		$this->view->setVar('header_content', $this->opo_config); 

		$id = $this->request->getParameter('id', pString);
		
		$this->view->setVar('set_id', $id );
		
		$this->render("set_items.php");
	}

	public function recoverInfo() {		
		$idno = $this->request->getParameter('idno', pString);
		$template = $this->request->getParameter('template', pString);

		$this->view->setVar('idno', $idno);
		
		$code = $this->render("data/content_$template.php", ['idno', 'template']); 
		
		$data = array(
			'code' => $code
			); 

		print json_encode($data);
	}

	public function recoverInfo123() {		
		//$idno = $this->request->getParameter('idno', pString);
		
		//$this->view->setVar('idno', $idno );
		
		$data = array(
			'code' => "hola"
			); 

		print json_encode($data);
	}

	public function header() {		
		$template = ($this->request->getParameter('template', pString)).trim();
		
		//$this->view->setVar('idno', $idno );
		
		$code = $this->render("data/header_$template.php", ['template']); 
		
		$data = array(
			'code' => $code
			); 

		print json_encode($data);
	}

	public function wiki(){	
		$this->render("wikiulan/wikidata.php");
	}
	public function ulan(){	
		$this->render("wikiulan/ulan.php");
	}
	public function QueryToUlanBirthday()
	{
		$code = $this->request->getParameter('code', pString);
		$idno = $this->request->getParameter('idno', pString);

		if (trim($code) !== "")
		{

			$url = "https://vocab.getty.edu/ulan/$code.json";

			// 1. Initialize cURL session
			$ch = curl_init();

			// 2. Set options
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the transfer as a string
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects if any
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);          // Max execution time in seconds
			curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Script'); // Some APIs require a user-agent header

			// 3. Execute the request
			$response = curl_exec($ch);

			// 4. Check for errors
			if (curl_errno($ch)) {
				$array = array("results" => "Error!!!");			
				$this->view->setVar('results', $array);				
				
			} else {
				// 5. Decode the JSON string into an associative array
				$data = json_decode($response, true);
				
				$birth_year = substr($data["born"]["timespan"]["begin_of_the_begin"], 0, 4);
				$death_year = substr($data["died"]["timespan"]["begin_of_the_begin"], 0, 4);

				if ($death_year >= "2027")
					$death_year = ""; 

				$t_entity = new ca_entities();

				if ($t_entity->load(array('idno' => $idno))) {
		
					// Success: The record exists and is now loaded into the $t_entity object
					$t_entity->replaceAttribute(
						array(
							'ubirth' => $birth_year, 
							'udeath' => $death_year
						),
						"ulanDates" 					
					);				
					$t_entity->UPDATE(); 
					
					$msg = $t_entity->get("ca_entities.ulanDates");
					$this->view->setVar('results', $msg);
				
				}
				else{
					$this->view->setVar('results', "Unknown idno");
				}
				
			}
			curl_close($ch);
		}	
		else{
			$this->view->setVar('results', "Unknown ulan code");
		}
			
		
		$this->render("jsonresult.php");
	}
	public function QueryToWikiBirthday(){
		$code = $this->request->getParameter('code', pString);
		$idno = $this->request->getParameter('idno', pString);

		if (trim($code) !== "")
		{

			$sparql = "
			SELECT ?birthday ?deathday WHERE {  
			wd:{$code} wdt:P569 ?birthday .
			OPTIONAL { wd:{$code} wdt:P570 ?deathday . }
			}
			";

			// 3. Encode for URL
			$url = 'https://query.wikidata.org/sparql?query=' . urlencode($sparql) . '&format=json';

			// 4. Set Headers (Important for Wikidata)
			$opts = [
				"http" => [
					"method" => "GET",
					"header" => "Accept: application/sparql-results+json\r\n" .
								"User-Agent: MyPHPApp/1.0\r\n" // Best practice to include User-Agent
				]
			];
			$context = stream_context_create($opts);

			// 5. Fetch and Parse
			$response = file_get_contents($url, false, $context);
			$data = json_decode($response, true);
			$this->view->setVar('results', "Unknown idno");

			$t_entity = new ca_entities();
			// 6. Extract Birthday
			if ($t_entity->load(array('idno' => $idno))){
				$this->view->setVar('results', "No data...");
				if (!empty($data['results']['bindings'])) {
					$bindings = $data['results']['bindings'][0]; // Fetch first matching row
					
					$birthday = isset($bindings['birthday']['value']) ? $bindings['birthday']['value'] : '';
					$deathday = isset($bindings['deathday']['value']) ? $bindings['deathday']['value'] : '';

					$t_entity->replaceAttribute(
							array(
								'wbirth' => substr($birthday, 0, 10), 
								'wdeath' => substr($deathday, 0, 10)
							),
							"wikiDates" 					
						);				
					$t_entity->UPDATE(); 
					
					$msg = $t_entity->get("ca_entities.wikiDates");
					
					$this->view->setVar('results', $msg);
				}
				
			}	
		}
		else{
			$this->view->setVar('results', "Unknown wiki code");
		}

		$this->render("jsonresult.php");		
	}
}
