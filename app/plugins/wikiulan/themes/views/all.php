<?php

$icon = "<i class='fa fa-list' style='font-size: 15px;'></i>"; 

$count = 0;

$o_items = $this->getVar('items');

$_WikiTitle = "Wikidata"; 
$_Ulantitle = "Ulan";

$_WikiCode = "ca_entities.wiki.wikicode"; 
$_WikiUrl = "ca_entities.wiki.wikiurl"; 
$_WikiComment = "ca_entities.wiki.wikicomment"; 

$_UlanCode = "ca_entities.ulan.ulancode"; 
$_UlanUrl = "ca_entities.ulan.ulanurl"; 
$_UlanComment = "ca_entities.ulan.ulancomment"; 

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
        <th><?php print $_WikiTitle ?></th>
        <th></th>
        <th><?php print $_WikiTitle ?></th>
        <th></th>
      </tr>
    </thead>
    <tbody id="myTable">

<?php 

/*caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id/EntityRel:100'), 
array('dontURLEncodeParameters' => true)); ?>

//the URL looked like this:

//index.php/Search/objects/search/entity_id:8744/EntityRel:100
*/
$urlULAN = "http://vocab.getty.edu/page/ulan/";
$urlWIKI = "https://www.wikidata.org/wiki/";
$cnt = 0; 

while($o_items->nextHit()) {  
  $id = $o_items->get("ca_entities.rank");
  $idno = $o_items->get("ca_entities.idno"); 
  $name= $o_items->get("ca_entities.preferred_labels");   

  $_wcode = $o_items->get($_WikiCode); 
  $_wurl = $o_items->get($_WikiUrl);
  $_wcomment = $o_items->get($_WikiComment);
  
  $_ucode = $o_items->get($_UlanCode); 
  $_uurl = $o_items->get($_UlanUrl);
  $_ucomment = $o_items->get($_UlanComment);
  
  $_wlink = $_wcomment;
  $_ulink = $_ucomment; 
  
  if ($_wcode != "")  
    $_wlink = "<a href='$_wurl' target='_blank'> $_wcode </a>";
  
  if ($_ucode != "")
    $_ulink = "<a href='$_uurl' target='_blank'> $_ucode </a>";
  
  $type = $o_items->get("type_id");

  if (True)
  {
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
      <td>
        <?php 
          print $_wlink;
        ?>
      </td>
      <td width='80px'>
        <form  role="search" 
          action="<?php print caNavUrl($this->request, '*', 'Import', 'ShowProfile'); ?>">
      
          <input type="hidden" name="idno" value="<?php print $id ?>"/> 
          <input type="hidden" name="opt" value="WIKI"/>    
          <button type="submit" class="btn-search" id="headerSearchButton"> <i class="fa fa-search"></i></button>
      
        </form>
      </td>    
      <td>
        <?php 
          print $_ulink;
        ?>
      </td>
      <td width='80px'>
        <form  role="search" 
          action="<?php print caNavUrl($this->request, '*', 'Import', 'ShowProfile'); ?>">
      
          <input type="hidden" name="idno" value="<?php print $id ?>"/>    
          <input type="hidden" name="opt" value="ULAN"/>    
          <button type="submit" class="btn-search" id="headerSearchButton"> <i class="fa fa-search"></i></button>
      
        </form>
      </td>  
      </tr>
    <?php 

  }    
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
