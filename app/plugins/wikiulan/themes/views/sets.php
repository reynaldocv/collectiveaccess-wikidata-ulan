<?php

$icon = "<i class='fa fa-list' style='font-size: 15px;'></i>"; 

$count = 0;

$o_items = $this->getVar('items');

$_WikiTitle = "Wikidata"; 
$_Ulantitle = "Ulan";

$_WikiCode = "ca_entities.wikidata.wikicode"; 
$_WikiUrl = "ca_entities.wikidata.wikiurl"; 
$_WikiComment = "ca_entities.wikidata.wikicomment"; 

$_UlanCode = "ca_entities.ulan.ulancode"; 
$_UlanUrl = "ca_entities.ulan.ulanurl"; 
$_UlanComment = "ca_entities.ulan.ulancomment"; 


print "<h3> $icon  Lista de Sets </h3>"; 

    
  
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
        <th>NAME</th>
        <th>TABLE</th>
        <th>Items</th>
      </tr>
    </thead>
    <tbody id="myTable">

<?php 

/*caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id/EntityRel:100'), 
array('dontURLEncodeParameters' => true)); ?>

//the URL looked like this:

//index.php/Search/objects/search/entity_id:8744/EntityRel:100
*/
$sql = "select t1.*, t2.name as label from ca_sets  as t1 inner join ca_set_labels as t2 on t1.set_id = t2.set_id";
$o_data = new Db();
$items = $o_data->query($sql);

$cnt = 0; 

while($items ->nextRow()) { 
  $deleted = $items->get("deleted");

  if ($deleted != "1")
  {
    //var_dump($items); 
    $cnt += 1; 
    $name = $items->get("label");
    $id = $items->get("set_id");
    $code = $items->get("set_code");
    $table_num = $items->get("table_num");
    $num_rows = $items->get("num_rows");
    
  



  ?> 

    <tr>
      <td><?php print $cnt ?> </td>
  
      <td>      
        <a href="<?php print caNavUrl($this->request, 'editor', 'entities', 'EntityEditor/Edit/entity_id/'.$id); ?>" target="_blank"> <?php echo $id ?></a>
      </td>
      <td>      
        <?php echo "$name (<span style='color:red'>$code</span>)"; ?>        
      </td>
      <td>      
        <?php echo $table_num ?>        
      </td>
      <td width='80px'>
        <form  role="search" 
          action="<?php print caNavUrl($this->request, '*', '*', 'ShowSetItems'); ?>">
      
          <input type="hidden" name="id" value="<?php print $id ?>"/>              
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
