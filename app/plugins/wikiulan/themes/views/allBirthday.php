<?php

$icon = "<i class='fa fa-list' style='font-size: 15px;'></i>"; 

$count = 0;

$o_items = $this->getVar('items');

$_WikiTitle = "Wikidata"; 
$_Ulantitle = "Ulan";

$data = []; 

$data[] = "ca_entities.wiki.wikicode";
$data[] = "ca_entities.wikiDates.wbirth"; 
$data[] = "ca_entities.wikiDates.wdeath"; 
$data[] = "ca_entities.ulan.ulancode"; 
$data[] = "ca_entities.ulanDates.ubirth"; 
$data[] = "ca_entities.ulanDates.udeath"; 

print "<h3> $icon  List of Artists </h3>"; 
  
?>

<div class="control-box rounded">
		<div class="control-box-left-content">
      <div class="simple-search-box">
        Filtro: 
        <input class="form-control" id="myFilter" type="text" placeholder="Search...">
      </div>
    </div>
	</div>


  

<div class="container">
  <table class="listtable">
    <thead>
      <tr>
        <th>#</th>
        <th>ID</th>        
        <th>NAMES</th>
        <th>wikicode</th>        
        <th>wiki - birthday</th>
        <th>wiki - death</th>
        <th>ulancode</th>
        <th>ulan - birthday</th>
        <th>ulan - deathday</th>
      </tr>
    </thead>
    <tbody id="myTable">

<?php 

/*caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id/EntityRel:100'), 
array('dontURLEncodeParameters' => true)); ?>

//the URL looked like this:

//index.php/Search/objects/search/entity_id:8744/EntityRel:100
*/

while($o_items->nextHit()) {  
  $id = $o_items->get("ca_entities.rank");
  $idno = $o_items->get("ca_entities.idno"); 
  $name= $o_items->get("ca_entities.preferred_labels");   
  
  $cnt += 1;
  ?> 

  <tr>
    <td><?php print $cnt ?> </td>

    <td>      
      <a href="<?php print caNavUrl($this->request, 'editor', 'entities', 'EntityEditor/Edit/entity_id/'.$idno); ?>" target="_blank"> <?php echo $id ?></a>
    </td>
    <td>      
      <?php echo $name ?>
    </td>
    <?php foreach ($data as $sentence){
      $temp = $o_items->get($sentence); 

      echo "<td>$temp</td>"; 
    }
    ?>
    </tr>
  <?php 

}    

print "</table><br><br><br><br><br><br><br>";



/*while($o_items->nextHit()) {
    print "Hit ".$count.": ".$o_items->get('ca_objects.preferred_labels.name')."<br/>\n";
    $count++;
}*/
?>

  <br><br><br><br>

  <?php 
    include("leftmenu.php"); 
  ?>

  </tbody>
  </table>
  </div>
</div>
