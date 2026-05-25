<?php

$caracteres_sem_acento = array(
  'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Â'=>'Z', 'Â'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
  'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
  'Ï'=>'I', 'Ñ'=>'N', 'Å'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
  'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
  'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
  'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'Å'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
  'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
  'Ä'=>'a', 'î'=>'i', 'â'=>'a', 'È'=>'s', 'È'=>'t', 'Ä'=>'A', 'Î'=>'I', 'Â'=>'A', 'È'=>'S', 'È'=>'T', "ł" => "l", 
  "š"=>'s', 'ć' => 'i', 'č' => 'c', 'ě'=> 'e', 'Ś'=> 'S', 'ń' => 'n', 
);

// decode three byte unicode characters $string = preg_replace("/([\340-\357])([\200-\277])([\200-\277])/", "'&#'.((ord('\\1')-224)*4096 + (ord('\\2')-128)*64 + (ord('\\3')-128)).';'", $string); // decode two byte unicode characters $string = preg_replace("/([\300-\337])([\200-\277])/", "'&#'.((ord('\\1')-192)*64+(ord('\\2')-128)).';'", $string); return $string; }


$count = 0;
$o_items = $this->getVar('items');
$option = $this->getVar('option');


if ($option == "WIKI")
{
  $link = "https://www.wikidata.org/wiki/";
  $subtitle = "Wikidata code"; 
}

if ($option == "ULAN")
{
  $link ="http://vocab.getty.edu/page/ulan/";
  $subtitle = "ULAN code"; 
}

?>

<input type='hidden' id="option" value="<?php print $option ?>"/>

<?php print "<h3>Lista de Artistas </h3>" ?>
  <div class="contenedor">
        
          <div class="control-box rounded">
            <div class="control-box-left-content">
              <div class="simple-search-box"> Search: 
                <input type="text" id="myFilter" value="<?php print $labels ?>" size="50">
              </div>
            </div>
            <input type="text" id="start" value="1" size="3">           
            <div id="div_btn_consulta">                 
              <input type="submit" value="Consultar" id="btn_consultar" onclick='proccess()'>
            </div>
          </div>                  
        <div id="resultado-ulan">
        </div>     
    </div>  

<div class="container">
  <table class="listtable">
    <thead>
      <tr>
        <th>#</th>
        <th>ID</th>        
        <th>NAMES</th>
        <th><?php print $subtitle;  ?></th>
        <th>Comment</th>
        <th >  </th>
      </tr>
    </thead>
    <tbody id="myTable">

<?php 

/*caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id/EntityRel:100'), 
array('dontURLEncodeParameters' => true)); ?>

//the URL looked like this:

//index.php/Search/objects/search/entity_id:8744/EntityRel:100
*/


$cnt = 0; 

while($o_items->nextHit()) {  
  $id = $o_items->get("ca_entities.rank");
  $idno = $o_items->get("ca_entities.idno"); 
  $name= $o_items->get("ca_entities.preferred_labels"); 
  
  $_name = strtr($name, $caracteres_sem_acento);
  //$_name = utf8_encode($name);

  if ($option == "WIKI")
  {
    $_code = $o_items->get("ca_entities.wiki.wikicode"); 
    $_comment= $o_items->get("ca_entities.wikiDates"); 
  }
  if ($option == "ULAN")
  {
    $_code = $o_items->get("ca_entities.ulan.ulancode");     
    $_comment= $o_items->get("ca_entities.ulanDates"); 

  }
  //$ulancode = $o_items->get("ca_entities.IDcodes.ulancode"); 
  //$ulancode = "<a href='https://www.getty.edu/vow/ULANFullDisplay?find=&role=&nation=&subjectid=$ulancode'> $ulancode </a>";
  //$ulancodeUrl = "<a href='$urlULAN$ulancode'  target='_blank'> $ulancode </a>";
  
  $type = $o_items->get("type_id");

  //if ($type == "488")
  if (True)
  {
    $cnt += 1;
  ?> 
    <tr>
        <td><?php print $cnt ?> </td>
    
        <td>      
          <a target='blank' href="<?php print caNavUrl($this->request, 'editor', 'entities', 'EntityEditor/Edit/entity_id/'.$id); ?>"> <?php echo $idno ?></a>
        </td>
        <td>
          <?php 
            print "$name" ;
          ?>
          <input type='hidden' id="code-<?php print $cnt ?>" value="<?php print $_code ?>"/>
          <input type='hidden' id="idno-<?php print $cnt ?>" value="<?php print $idno ?>"/>
        </td>
        <td>        
          <?php print "<div id='wikicode-$cnt'> $_code </div>";  ?>      
        </td>       
        <td>
          <?php print "<div id='status-$cnt'> $_comment </div>"; ?>
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


  </tbody> 
  <input type='hidden' id="total" value='<?php print $cnt?>'/>
</div>

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

  <script>
    const limit = document.querySelector("#total").value.trim();
    const option = document.querySelector("#option").value.trim();
        
    function proccess( )    
    {
      const _start = Number(document.querySelector("#start").value.trim());  
      roboto(_start); 
  
    }
    function roboto(idx)
    {
        jQuery("#div_btn_consulta").html("Processing... <i class='fa fa-spinner fa-spin'></i>");

        if (idx <= limit){

          var idno = document.querySelector("#idno-" + idx.toString()).value.trim();
          var code = document.querySelector("#code-" + idx.toString()).value.trim();
     
          var divWikicode = "#wikicode-" + idx.toString(); 
          var divStatus = "#status-" + idx.toString(); 
  
          jQuery(divStatus).html("Searching... <i class='fa fa-spinner fa-spin'></i>");

          if (option == "WIKI" )
          {
            if (code != ""){
              jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', 'QueryToWikiBirthday'); ?>', {idno, code}, function(data) { 
                jQuery(divStatus).html(data);  
              
                setTimeout(() => {roboto(idx + 1)}, 10000);              
              }); 
            }
            else{
              jQuery(divStatus).html("no wikicode...");  
              roboto(idx + 1); 
            }
          };

          if (option == "ULAN")
          {
            //consulta = consulta.replaceAll(" ", " And ");
            //alert(idno +" "+ code); 
            jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', 'QueryToUlanBirthday'); ?>', {idno, code}, function(data) {    
              jQuery(divStatus).html(data);  
            
              roboto(idx + 1); 
            }); 
          };

        }
        
        
    }
     
    
</script>
