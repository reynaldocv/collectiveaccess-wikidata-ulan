<?php 
    $idno = $this->getVar('idno'); 

    $qr_res = new ca_objects($idno); 

    $value01 = $value04 = $qr_res->getWithTemplate("<l>^ca_objects.preferred_labels<l>");
    
    $exhibitions = $qr_res->getWithTemplate("<unit relativeTo='ca_occurrences' delimiter='$' restrictToTypes='exhibition'>^ca_occurrences.occurrence_id</unit>");

    $list_exhibitions = explode('$', $exhibitions);
	
    //This is the value 4 (Title of work)
    //This is the value 4 (Title of work)
    $tmp = ""; 
    $exhibitions = []; 

    foreach ($list_exhibitions as $key){   
        
        $t_item = new ca_occurrences($key); 

        $vs_template = '^ca_occurrences.preferred_labels';
        $exhibition_name = $t_item->getWithTemplate($vs_template);

        $vs_template = '^ca_occurrences.idno';
        $exhibition_code = $t_item->getWithTemplate($vs_template);

        $vs_template = '^ca_occurrences.exhibitionBeginDate';
        $exhibition_begin = $t_item->getWithTemplate($vs_template);

        $vs_template = '^ca_occurrences.exhibitionEndDate';
        $exhibition_code = $t_item->getWithTemplate($vs_template);

        $vs_template = '^ca_occurrences.idno';
        $exhibition_code = $t_item->getWithTemplate($vs_template);

        $vs_template = '^ca_occurrences.idno';
        $exhibition_code = $t_item->getWithTemplate($vs_template);

        $vs_template = '^ca_occurrences.idno';
        $exhibition_code = $t_item->getWithTemplate($vs_template);
        
        $vs_template = '^ca_occurrences.endereco_exposicao.cidade_endereco_expo.hierarchy.preferred_labels%hierarchyDirection=asc%maxLevelsFromBottom=4%delimiter=$';
		$sentence = $t_item->getWithTemplate($vs_template);

        $cities = explode('$', $sentence);

        $city =  ""; 

        if (sizeof($cities) >= 3)
        {
            $city = "$cities[2], <b>$cities[1]</b>"; 									
        }

        $exhibition_city= $city;

        $vs_template = '<unit relativeTo="ca_entities" restrictToRelationshipTypes="local_exposicao">
                            ^ca_entities.preferred_labels
                        </unit>'; 
        $exhibition_place = $t_item->getWithTemplate($vs_template);
        


        $exhibition = []; 
        $exhibition["name"] = $exhibition_name; 
        $exhibition["code"] = $exhibition_code;      
        $exhibition["begin"] = $exhibition_begin;   
        $exhibition["end"] = $exhibition_begin;           
        $exhibition["place"] = $exhibition_place; 
        $exhibition["city"] = $exhibition_city; 

        $exhibitions[] = $exhibition; 
    }
    
    $value05 = $qr_res->getWithTemplate("^ca_objects.versao_titulo_portugues.titulo_portugues"); 

    $value06 = $qr_res->getWithTemplate("^ca_objects.AlbumSerieInstalacao"); 

    $value07 = $qr_res->getWithTemplate("^ca_objects.versao_portugues_album"); 

    $value08 = $qr_res->getWithTemplate("<unit relativeTo='ca_objects.datePeriod' delimiter=' '> ^ca_objects.datePeriod </unit>"); 					

    $value09 = $qr_res->getWithTemplate("^ca_objects.technicalAttribute"); 

    $value11 = ""; 	
    $value12 = ""; 

    $value14 = ""; 
    $value15 = ""; 
?>


<?php 

foreach ($exhibitions as $exhibition => $data){
    
?>

<tr>
    <td><?php print $idno   ?></td>                  
    <td><?php print $value01?></td>
    <td><?php print $data["name"] ?></td>
    <td><?php print $data["code"] ?></td>    
    <td><?php print $data["begin"] ?></td>    
    <td><?php print $data["end"] ?></td>    
    <td><?php print $data["place"] ?></td>    
    <td><?php print $data["city"] ?></td>        
    
</tr>

<?php 

}

?>
<tr><td></td></tr>
