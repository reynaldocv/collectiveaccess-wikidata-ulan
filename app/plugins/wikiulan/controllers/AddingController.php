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

class AddingController extends ActionController {
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
		
		parent::__construct($po_request, $po_response, $pa_view_paths);

		/*if (!$this->request->user->canDoAction('can_import_ulan')) {
			$this->response->setRedirect($this->request->config->get('error_display_url').'/n/3000?r='.urlencode($this->request->getFullUrlPath()));
			return;
		}

		// Load plugin stylesheet*/
		
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function Artists() {
		$this->render("adding.php");
	}	

	public function CreateArtist() {
		$name = $this->request->getParameter('name', pString);
		$idno = $this->request->getParameter('idno', pString);

		$t_entity = new ca_entities();

		$msg = ""; 

		if ($t_entity->load(array('idno' => $idno))) {
    
			// Success: The record exists and is now loaded into the $t_entity object
			$entity_id = $t_entity->getPrimaryKey();
			

			$t_entity->replaceLabel(
				array(
					'displayname' => $name
				), 
				'en_US',    // Locale code matching your system installation
				null,       // Type ID (null default uses preferred label)
				true        // Set as the primary preferred label
			);
			// 5. Insert the record
			$display_name = $t_entity->get('ca_entities.preferred_labels.displayname');
			
			$t_entity->UPDATE(); 
			
			$msg = "Found Entity ID: {$entity_id} with Name: {$display_name}";
			
		}
		else{

			$t_entity->set('type_id', 'ind'); 

			// 3. Set intrinsic fields (like idno)
			$t_entity->set('idno', $idno);

			$t_entity->insert();
			
			// 4. Add the preferred label (The name)
			$t_entity->addLabel(
				array(
					'displayname' => $name
				), 
				'en_US',    // Locale code matching your system installation
				null,       // Type ID (null default uses preferred label)
				true        // Set as the primary preferred label
			);
			// 5. Insert the record
			
			$t_entity->UPDATE(); 
			
			$msg = ""; 

			if ($t_entity->numErrors()) {
				$msg = "Error: " . join('; ', $t_entity->getErrors());
			} else {
				$msg = "Created Entity ID: " . $t_entity->getPrimaryKey();
			}
		}

		$this->view->setVar('results',  "->".$msg);
		
		$this->render("jsonresult.php");
	}	
}
