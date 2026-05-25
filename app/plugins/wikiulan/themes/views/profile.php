<?php
    $option = $this->getVar('option'); 
     
    $item = $this->getVar('item');

    $icon = "<i class='fa fa-user' style='font-size: 15px;'></i>";

    //print "<h2>Profile: (".$item->get("idno").") ".$item->get("preferred_labels")."</h2>";
    //print "<h2>Country: ".$item->get("ca_entities.nationality")."</h2>";   
    
    $labels = $item->get("preferred_labels");     
    
    $caracteres_sem_acento = array(
        'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Â'=>'Z', 'Â'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
        'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
        'Ï'=>'I', 'Ñ'=>'N', 'Å'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
        'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
        'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
        'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'Å'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
        'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
        'Ä'=>'a', 'î'=>'i', 'â'=>'a', 'È'=>'s', 'È'=>'t', 'Ä'=>'A', 'Î'=>'I', 'Â'=>'A', 'È'=>'S', 'È'=>'T',
    );

    $labels = strtr($labels, $caracteres_sem_acento);
    
    //var_dump($item);

    //$r = new ReflectionObject($item);

    /*echo $r->getName() .' {' . implode(', ', array_map(
     function($p) use ($v) {
         $p->setAccessible(true);
         return $p->getName() .': '. $p->getValue($v);
     }, $r->getProperties())) .'}';

    foreach(array_keys($item) as $key)
      echo $key."<br>";
    */

    //print "<h2> Country: ".$item->get("ca_entities.nationality")."</h2>";   
    //print "<h2> Profession -> : ".$item->get("ca_entities.dados_complementares.profissao_entidade")."</h2>";
    //print "<h2> Sex: -> ".$item->get("ca_entities.sex")."</h2>";    
    
    //print "<h2>Outros Nomes: ".$item->get("ca_entities.type_id")."</h2>";    

    //print "<h2>Datas importantes: ".$item->get("type_id")["display_text"]."</h2>";  
    //print $item->get("ca_entities.DadosBiograficos.LocalNascimento")." - ".$item->get("ca_entities.DadosBiograficos.AnoNascimento");
    //print $item->get("ca_entities.DadosBiograficos.LocalMorte")." - ".$item->get("ca_entities.DadosBiograficos.AnoMorte");

    //print "<h2>Dados complementarios: ".$item->get("type_id")["display_text"]."</h2>";    

    //print "<b>Description: </b><br>".$item->get("ca_entities.internal_notes")."<br>";   

    if ($option == "WIKI")
    {    
      $_title = "WIKIDATA"; 

      $_code = $item->get("ca_entities.wikidata.wikicode"); 
      $_url = $item->get("ca_entities.wikidata.wikiurl");
      $_comment= $item->get("ca_entities.wikidata.wikicomment");    
    }

    if ($option == "ULAN")
    {

      $_title = "ULAN"; 
      $_code = $item->get("ca_entities.ulan.ulancode"); 
      $_url = $item->get("ca_entities.ulan.ulanurl");
      $_comment= $item->get("ca_entities.ulan.ulancomment");   
    }

    print "<h3> $icon Profile: (".$item->get("idno").") ".$item->get("preferred_labels")." <div class='control-box-right-content' id='linkcode'> <a href='$_url'><h3>$_code</h3></a> </div> </h3> ";
    print "";

?>
    
    <input type='hidden' id='idno' value='<?php print $item->get("rank") ?>'>
    <input type='hidden' id='option' value='<?php print $option ?>'>

    <div class="control-box rounded">
    <table>
      <tr>
        <td> <?php print " $_title code:" ?>
        </td>       
        <td> 
        <td> 
          <input id='_code' type='text' style="text-align:center" style='font-size:14px' size='20' value='<?php print $_code ?>' readonly> 
          <input id='_comment' type='hidden' style="text-align:center" style='font-size:14px' size='20' value='<?php print $_comment ?>' readonly> 
          <input id='_url' type='hidden' style="text-align:center" style='font-size:14px' size='20' value='<?php print $_url ?>' readonly> 
        </td>       
        <td>
          <div style="cursor:pointer">
            <i onclick="saveData('<?php print $option ?>')" class='fa fa-save' style='color:green'> Save</i></div>
        </td>
      </tr>
    </table>
    </div> 

    <div style="color:red" id="status">    
    </div>    
    
    <br>
    <div id="container">
        <div class="contenedor">
            <form action="#" id="formulario">
              <div class="control-box rounded">
                <div class="control-box-left-content">
                  <div class="simple-search-box"> <?php print "Consulta: " ?> 
                    <input type="text" id="_querySeacrh" value="<?php print $labels ?>" size="50">
                  </div>
                  &emsp;
                  <div id="div_btn_query" class="control-box-right-content">                    
                    <input type="submit" value="Consultar" id="btn_query">
                  </div>
                </div> 
                <div id="_queryResult">
                </div>             
              </div>                  
            </form>
          
        </div>  
      </div>

  
  <br><br><br><br>
  <?php 
    include("leftmenu.php"); 
  ?>

  <script>   
    
    const formulario = document.querySelector("#formulario")
    var container = document.querySelector("#container");
    const option = document.querySelector("#option").value.trim();
    const whitespaceRegExp = / /g;

    formulario.addEventListener("submit", evento => {
      evento.preventDefault();

      const consulta = document.querySelector("#_querySeacrh").value.trim();
      const botonConsultar = document.querySelector("#btn_query");

      //alert("jaja");
      jQuery("#div_btn_query").html("Searching... <i class='fa fa-spinner fa-spin'></i>");
      
      if (option == "WIKI")
      {
        jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', 'QueryToWikidata'); ?>', {consulta}, function(data) {
          const total = data['search'].length; 
			
          var prev = "<div class='control-box rounded' style='color:red'> Busca realizada ( " + total +" resultado(s) )</div>";
          var html = "<br>";

          for(var i=0; i < data['search'].length; i++) {
            const wikicode = data['search'][i]['id']; 
            const label = data['search'][i]['label']; 
            const description = data['search'][i]['description']; 
            const aliases = data['search'][i]['aliases']; 
            const link = "https://www.wikidata.org/wiki/" + wikicode; 
            const comment = label + ": " + description; 
            
            var icomment = comment.replaceAll(" ", "#");
            
            html += "<tr class='odd'>";
            html += "<td><a href='" + link + "'>" + wikicode + "</a></td>";
            
            html += "<td>" + label + "</td>";
            html += "<td>" + description + "</td>";
            html += "<td>" + aliases + "</td>";
            
            //html += "<td style='cursor:pointer'><div syt><i onclick=myfunction('" + wikicode + "') class='fa fa-search' style='font-size:18px;color:green'></i></td>";            html += "";
            html += "<td style='cursor:pointer'><i onclick=modifyTextBox('" + wikicode + "','" + link +"','" + icomment + "') class='fa fa-copy' style='font-size:16px;color:blue'></i></td>";
            //html += "<td style='cursor:pointer'><i onclick=modifyTextBox('link','Wikidata','" + link + "') class='fa fa-link' style='font-size:16px;color:gray'></i></td>";            
            html += "</tr><tr><td></td>";
            
            html += "<td colspan='6'>";
            html += "<div class='wikilinks' id='wikilink" + wikicode +"'> </div>";
            html += "</td>";
            html += "</tr>";
          }

          html = "<br> <div class='container'>"+ prev +"<table class='listtable'>" + html + "</table><br><div>";
          
          jQuery("#_queryResult").html(html);   
          jQuery("#div_btn_query").html("<input type='submit' value='Consultar' id='btn_query'>");     
      
        }); 
      }
      if (option == "ULAN"){
        jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', 'QueryToULAN'); ?>', {consulta}, function(data) {
          const total = data.length; 
          var prev = "Busca realizada: " + total + " resultado(s) ";

          var html = "<br>";        

          for (var i = 0; i < data.length; i++) {
            const label = data[i]['Term']['value'];

            const link = data[i]['Subject']["value"]; 
            const ulancode = link.replace("http://vocab.getty.edu/ulan/", "");
            
            const url = "http://vocab.getty.edu/page/ulan/" + ulancode; 
            const parents = data[i]['Parents']["value"];
            const bio = data[i]['bio']["value"];

            const comment = label + ": " + bio; 

            var icomment = comment.replaceAll(" ", "#");
            
            html += "<tr class='odd'>";
            html += "<td width='8%'><a href='" + url + "' target='_blank'>" + ulancode + "</a></td>";
            
            html += "<td width='15%'>" + label + "</td>";
            html += "<td width='15%'>" + parents + "</td>";
            html += "<td width='50%'>" + bio + "</td>";
            
            //html += "<td style='cursor:pointer'><i onclick=myfunction('" + ulancode + "') class='fa fa-search' style='font-size:18px;color:green'></i><td>";
            html += "";
            html += "<td style='cursor:pointer'><i onclick=modifyTextBox('"+ ulancode +"','" + url + "','" + icomment + "') class='fa fa-copy' style='font-size:16px;color:blue'></i></td>";
            //html += "<td style='cursor:pointer'><i onclick=modifyTextBox('"+ ulancode +"','','') class='fa fa-link' style='font-size:16px;color:gray'></i></td>";
            html += "</tr><tr><td></td>";
            
            html += "<td colspan='5'>";
            html += "<div class='wikilinks' id='wikilink" + ulancode +"'> </div>";
            html += "</td>";
            html += "</tr>";
          }
          
          html = "<div class='container'><table class='listtable'>" + html + "</table><br><br>";
          html += "</div>";

          jQuery("#_queryResult").html(html);   
          jQuery("#div_btn_query").html("<input type='submit' value='Consultar' id='btn_query'>");
        }); 
        
      }      
    });

  </script>
  <script>
    function modifyTextBox(icode, iurl, icomment){ 
      var tb_code = document.getElementById("_code");  
      var tb_url = document.getElementById("_url");  
      var tb_comment = document.getElementById("_comment");  
      
      var iicomment = icomment.replaceAll("#", " ")
      
      tb_code.value = icode;
      tb_url.value = iurl;
      tb_comment.value = iicomment 
    }    

    function saveData(type){ 
      var tb_code = document.getElementById("_code");  
      var tb_url = document.getElementById("_url");  
      var tb_comment = document.getElementById("_comment"); 

      const idno = document.getElementById("idno").value; 
      const option = type; 
      const _code = tb_code.value; 
      const _url = tb_url.value; 
      const _comment = tb_comment.value; 
      
      jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', 'SaveCodes'); ?>', {option, idno, _code, _url, _comment}, function(data) {    

        var html = data["results"];    
            
        jQuery("#linkcode").html(html);
        jQuery("#status").html(data["msg"]);

      });
    }
  </script>
    