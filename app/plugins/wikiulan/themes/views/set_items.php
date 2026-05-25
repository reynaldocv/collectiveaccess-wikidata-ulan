<?php

$icon = "<i class='fa fa-list' style='font-size: 15px;'></i>"; 

$set_id = $this->getVar('set_id');
$header_content = ($this->getVar("header_content"))->getAssoc("templates");





print "<h3> $icon  Lista de items no Set $set_id</h3>"; 
print caNavUrl($this->request, 'adf', '*', '*', 'ShowAllSets',"adfasdf", "asdf");


$sql = "select t1.*, t2.*, t3.* from ca_sets  as t1 inner join ca_set_items as t2 on t1.set_id = t2.set_id inner join ca_set_item_labels as t3 on t2.item_id = t3.item_id where t1.set_id='$set_id'";
$o_data = new Db();
$items = $o_data->query($sql); 
$cnt = 0;   

while($items ->nextRow()) { 
  $deleted = False; 
  $deleted = $items->get("deleted");

  if ($deleted != "1")
  {
    //var_dump($items); 
    $caption = $items->get("caption"); 
    $table_num = $items->get("table_num"); 
    $row_id = $items->get("row_id"); 
    $cnt += 1; 

    print "<input type='hidden' id='id-$cnt' value='$row_id'>"; 

  }
}
print "<input type='hidden' id='total' value='$cnt'>"; 
?>

  <div class="control-box rounded">
		<div class="control-box-left-content">
      <div class="simple-search-box">
        Filtro: 
        <input class="form-control" id="myFilter" type="text" placeholder="Search...">
      </div>
    </div>
	</div>

  <div class="contenedor">        
      <div class="control-box rounded">        
        <div  class="control-box-right-content" id="div_btn_consulta">              
          templates: <?php echo '<select id="select" style="width:300px" name="items">';

            foreach ($header_content as $key => $values) {
              echo '<option value="' . $key . '">' .$values["label"] . '</option>';
            }
            echo '</select>';

          ?>
          <input type="submit" value="Consultar" id="btn_consultar" onclick='execution(1)'>
          
          <div id="status" style="padding:10px">
            Total: <?php echo $cnt ?>
          </div>
        </div>
        
      </div>                     
    </div>  

<div>
  <table class="listtable">
    <thead id="header">
       
    </thead>
    <tbody id="output">

    </boday>
</table>
</div>


<?php 

/*caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id/EntityRel:100'), 
array('dontURLEncodeParameters' => true)); ?>

//the URL looked like this:

//index.php/Search/objects/search/entity_id:8744/EntityRel:100
*/








/*while($o_items->nextHit()) {
    print "Hit ".$count.": ".$o_items->get('ca_objects.preferred_labels.name')."<br/>\n";
    $count++;
}*/
?>

<br><br><br><br><br><br>


  <?php 
    include(leftmenu.php); 
  ?>


 <script>
    //alert("hola"); 
    const limit = document.querySelector("#total").value.trim();
    let content = ""; 
    var template = document.querySelector("#select").value.trim();  

    function execution(idx)
    {
      template = document.querySelector("#select").value.trim();  
      
      jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', 'header'); ?>', {template}, function(data) {              
        jQuery('#header').html(data["code"]);
      });
      jQuery('#output').html("");
      roboto(idx); 
    }


    function roboto(idx)
    { 
      //alert(idx + "-"+ limit); 
      if (idx <= limit){
        jQuery("#status").html("Processing... " + idx.toString() + " / " + limit.toString() + "");

        var idno = document.querySelector("#id-" + idx.toString()).value.trim();        

        jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', 'recoverInfo'); ?>', {idno, template}, function(data) {    
          //var html = data["results"];  
          
          //alert(data["results"] + " <->"+ idno);   
          content = document.getElementById("output").innerHTML;
          
          jQuery('#output').html(content + data["code"]);

          roboto(idx + 1); 
        });
      }
      else{
        

        //jQuery('#output').html("->" + idx.toString());

      }
    }
    
</script>