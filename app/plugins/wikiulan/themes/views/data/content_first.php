<?php 
    $idno = $this->getVar('idno'); 

    $qr_res = new ca_objects($idno); 

    $name = $qr_res->get("ca_objects.preferred_labels"); 

    $value01 = $qr_res->getWithTemplate("<unit relativeTo='ca_entities' delimiter=' , ' restrictToRelationshipTypes='creator,collective_creator'>
																		<l>^ca_entities.preferred_labels <l>
                                               						</unit>");

					//This is the value 2 and 3 (recovering the city, country and year of birthday and death)
    $values02 = $qr_res->getWithTemplate("<unit relativeTo='ca_entities' delimiter='$' restrictToRelationshipTypes='creator,collective_creator'>
                                            ^ca_entities.entity_id
                                          </unit>");

    

	
	$list_authors = explode('$', $values02);
	
    //This is the value 4 (Title of work)
    //This is the value 4 (Title of work)
    $tmp = ""; 
    $authors = []; 
    foreach ($list_authors as $key){
        $t_item = new ca_entities($key); 

        $vs_template = '^ca_entities.preferred_labels';
        $author_name= $t_item->getWithTemplate($vs_template);
        
        $vs_template = '^ca_entities.DadosBiograficos.LocalNascimento.hierarchy.preferred_labels%hierarchyDirection=asc%maxLevelsFromBottom=4%delimiter=$';
        $sentence = $t_item->getWithTemplate($vs_template);

        $vs_template = '^ca_entities.DadosBiograficos.AnoNascimento';
        $ano = trim($t_item->getWithTemplate($vs_template));
        
        $cities = explode('$', $sentence);
        $birthdata = "";

        if (sizeof($cities) >= 3)
        {
            if ($cities[1] === "Brasil")
            {
                $birthdata = "$cities[3], $cities[2] (<b>$cities[1]</b>)"; 
            }
            else
            {
                $birthdata = "$cities[2] (<b>$cities[1]</b>)"; 
            }
        }
        if (trim($birthdata) !== "")
        {
            if ($ano !== ""){
                $birthdata .= ", $ano"; 
            }
            else {
                $birthdata .= $ano; 
            }
        }
        else{
            $birthdata = $ano; 
        }

        $vs_template = '^ca_entities.DadosBiograficos.LocalMorte.hierarchy.preferred_labels%hierarchyDirection=asc%maxLevelsFromBottom=4%delimiter=$';
        $sentence = $t_item->getWithTemplate($vs_template);

        $vs_template = '^ca_entities.DadosBiograficos.AnoMorte';
        $ano = trim($t_item->getWithTemplate($vs_template));
        
        $cities = explode('$', $sentence);
        $deathdata = "";

        if (sizeof($cities) >= 3)
        {
            if ($cities[1] === "Brasil")
            {
                $deathdata = "$cities[3], $cities[2], (<b>$cities[1]</b>)"; 
            }
            else
            {
                $deathdata = "$cities[2] (<b>$cities[1]</b>)"; 
            }
        }
        if (trim($deathdata) !== "")
        {
            if ($ano !== ""){
                $deathdata .= ", $ano"; 
            }
            else {
                $deathdata .= $ano; 
            }
        }
        else{
            $deathdata = $ano; 
        }

        if (trim($birthdata) !== "")
        {
            $birthdata = "☼ $birthdata";
        }

        if (trim($deathdata) !== "")
        {
            $deathdata = "&nbsp† &nbsp$deathdata";
        }

        $author = []; 
        $author["key"] = $key; 
        $author["name"] = $author_name; 
        $author["birth"] = $birthdata;        
        $author["death"] = $deathdata;

        $authors[] = $author; 
        
    }

    $value04 = $qr_res->getWithTemplate("<l>^ca_objects.preferred_labels<l>"); 

    $value05 = $qr_res->getWithTemplate("^ca_objects.versao_titulo_portugues.titulo_portugues"); 

    $value06 = $qr_res->getWithTemplate("^ca_objects.AlbumSerieInstalacao"); 

    $value07 = $qr_res->getWithTemplate("^ca_objects.versao_portugues_album"); 

    $value08 = $qr_res->getWithTemplate("<unit relativeTo='ca_objects.datePeriod' delimiter=' '> ^ca_objects.datePeriod </unit>"); 					

    $value09 = $qr_res->getWithTemplate("^ca_objects.technicalAttribute"); 

    $value10 = $qr_res->getWithTemplate("<unit relativeTo='ca_objects.dimensions.' delimiter='<br>'>
                                                        <b>^ca_objects.dimensions.Descritivo:</b> ^ca_objects.dimensions.dimensions_width x ^ca_objects.dimensions.dimensions_height
                                                        <ifdef code='ca_objects.dimensions.dimensions_depth'> x ^ca_objects.dimensions.dimensions_depth </ifdef>
                                                    </unit>");

    
?>

<?php 
foreach ($authors as $author => $data){
    
?>
<tr>
    <td><?php print $idno   ?></td>                  
    <td><?php print $data["name"] ?></td>
    <td><?php print $data["birth"] ?></td>
    <td><?php print $data["death"] ?></td>
    <td><?php print $value04?></td>
    <td><?php print $value05?></td>
    <td><?php print $value06?></td>
    <td><?php print $value07?></td>    
    <td><?php print $value08?></td>
    <td><?php print $value09?></td>
    <td><?php print $value10?></td>    
</tr>

<?php 
}
?>
<tr><td></td></tr>