
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
  "š"=>'s', 'ć' => 'i', 'č' => 'c', 'ě'=> 'e', 'Ś'=> 'S', 'ń' => 'n', '-' => ' ', 'é'  => ' ', 'A'  => 'A', 
);


$firstColumnData = [];
$error = "";

if (isset($_POST['upload'])) {
    $fileName = $_FILES['csv_file']['name'];
    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

    // Basic security check: only allow .csv files
    if ($fileExt === 'csv') {
        $path = $_FILES['csv_file']['tmp_name'];
        
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($row = fgetcsv($handle)) !== FALSE) {
                // Collect all first-column items into an array
                $firstColumnData[] = $row[0];
            }
            fclose($handle);
        }
    } else {
        $error = "Please upload a valid .csv file.";
    }
}
?>

<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">
    <h1> WIKIDATA </h1>
    <!-- Left Column -->
    

    <!-- Right Column -->
    <div class="w3-twothird">
    
      <div class="w3-container w3-card w3-white w3-margin-bottom">
        <h4 class="w3-text-grey w3-padding-16">
          <i class="fa fa-suitcase fa-fw w3-margin-right w3-xlarge w3-text-teal"></i>
          CSV file</h4>
        <div class="w3-container">          
            <form method="post" enctype="multipart/form-data">
                <label class="w3-text-teal" >Select CSV File:</label>
                <input type="file" name="csv_file" required>
                <button class="w3-tag w3-teal w3-round"  type="submit" name="upload">Create table</button>
            </form>
              <?php if ($error): ?>
                  <p class="w3-text-red"><?php echo $error; ?></p>
              <?php endif; ?>
          <hr>
        </div>
        
       
      </div>

      <div class="w3-container w3-card w3-white">
        <h4 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xlarge w3-text-teal"></i>
        Roboto</h4>
        <div class="control-box rounded">                                 
          <div id="div_btn_consulta">   
                          
          </div>
          <div id="output">  1
          </div>      
        </div>    
          
        <div class="w3-container"> 
          <?php if (!empty($firstColumnData)): ?>
              <table>
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Artist</th>
                      <th>ULAN code</th>
                      <th>Wikicode</th>
                      <th></th>
                    </tr>
                    
                  </thead>
                  <tbody>
                    <?php foreach ($firstColumnData as $index => $value): ?>
                      <tr>
                          <?php $name = strtr($value, $caracteres_sem_acento) ?>

                          <input type="hidden" id="idno-<?php echo $index ?>" value="<?php echo $index ?>">
                          <input type="hidden" id="value-<?php echo $index ?>" value="<?php echo $name ?>">
                          <td><?php echo htmlspecialchars($index); ?></td>
                          <td><?php echo htmlspecialchars($value); ?></td>                                  
                          <td><?php print "<div id='code-$index'>  </div>";  ?>  </td>
                          <td><?php print "<div id='url-$index'>  </div>";  ?>  </td>
                          <td><?php print "<div id='comment-$index'>  </div>";  ?>  </td>                              
                          <td><input  class="w3-text-teal" type="submit" value="?" id="btn_consultar" onclick='process(<?php echo $index ?>)'>  </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
              </table>
          <?php endif; ?>
        </div>
       
      </div>

    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
  <!-- End Page Container -->
</div>
<script text="javascript/text">  
  function process(idx){
    roboto(idx, idx + 10); 
  }
  function roboto(idx, limit)
  {
    if (idx < limit)
    {
      var idno = document.querySelector("#idno-" + idx.toString()).value.trim();
      var consulta = document.querySelector("#value-" + idx.toString()).value.trim();

      var divCode = "#code-" + idx.toString();
      var divUrl = "#url-" + idx.toString();
      var divComment = "#comment-" + idx.toString();
      var divStatus = "";
      
      $(divCode).html("<i class='fa fa-spinner fa-spin'></i>");
      
      jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', 'QueryToWikidata'); ?>', {consulta}, function(data) {        
        var total = data['search'].length;   

        if (total == 1)
        {
          const _code = data['search'][0]['id']; 
          const _url =  "https://www.wikidata.org/wiki/" + _code; 
          const _comment = data['search'][0]['label'] + ": "+ data['search'][0]['description']; 

          $(divCode).html(_code); 
          $(divUrl).html(_url); 
          $(divComment).html(_comment); 
        } 
        else
        {   
          if (total == 0)      
            $(divCode).html("-");         
          else
            $(divCode).html(total + " result(s)...");         
        } 
        
        
        roboto(idx + 1, limit); 
        
        
      });  
    }

  }  

</script>




<br>
<br>
<br>
<br>
<br>
<br>



<!-- HTML Section -->
