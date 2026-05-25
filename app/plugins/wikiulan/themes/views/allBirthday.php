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
      <a href="<?php print caNavUrl($this->request, 'editor', 'entities', 'EntityEditor/Edit/entity_id/'.$id); ?>" target="_blank"> <?php echo $id ?></a>
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
<?php 
    #Criando o menu
    $link1 = caNavUrl($this->request, '*', 'Import', 'Index');
    $link2 = caNavUrl($this->request, '*', 'Import', 'ShowAll');
    
    $link5 = caNavUrl($this->request, '*', 'Import', 'WikiLista');
    $link6 = caNavUrl($this->request, '*', 'Import', 'WikiRoboto');
    
    $link7 = caNavUrl($this->request, '*', 'Import', 'UlanLista');
    $link8 = caNavUrl($this->request, '*', 'Import', 'UlanRoboto');

    $menu = " ";
    $menu .= "<br><h3><a class='sf-menu-enabled' href='$link1'> <i class='fa fa-home' style='font-size: 25px;'></i> Index </a> </h3><hr>";
    $menu .= "<br><h3><a class='sf-menu-enabled' href='$link2'> <i class='fa fa-list' style='font-size: 25px;'></i> Lista de artistas </a> </h3>";
    
    $menu .= "<hr><h3><a class='sf-menu-enabled' href='$link5'> <i class='fa fa-wikipedia-w' style='font-size: 20px;'></i> Wikipedia (Artistas) </a> </h3>";
    $menu .= "<br><h3><a class='sf-menu-enabled' href='$link6'> <i class='fa fa-rocket' style='font-size: 20px;'></i> Wikipedia (Rocket) </a> </h3>";

    $menu .= "<br><h3><a class='sf-menu-enabled' href='$link7'> <i class='fa fa-paint-brush' style='font-size: 20px;'></i> Getty ULAN (Artistas) </a> </h3>";
    $menu .= "<br><h3><a class='sf-menu-enabled' href='$link8'> <i class='fa fa-rocket' style='font-size: 20px;'></i> Getty ULAN (Rocket) </a> </h3><hr>";

    
  ?>
  <br><br><br><br>

<script>
      var menu = "<?php print $menu ?>";
      jQuery("#leftNavSidebar").html(menu);

      $(document).ready(function(){
        $("#myFilter").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#myTable tr").filter(function() {
            
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
      });
</script>

  </tbody>
  </table>
  </div>
</div>
