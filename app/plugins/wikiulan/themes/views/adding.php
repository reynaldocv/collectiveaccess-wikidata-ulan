
<?php
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
                $firstColumnData[] = $row;                
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
    <h1> Adding artists to collectiveaccess (type: ind) </h1>
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
                <button class="w3-tag w3-teal w3-round"  type="submit" name="upload">Listing all artists</button>
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
            <input  class="w3-text-teal" type="submit" value="Create entities" id="btn_consultar" onclick='roboto(0)'>                
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
                          <th>Idno</th>
                          <th>Name</th>                          
                          <th></th>
                        </tr>
                        
                      </thead>
                      <tbody>
                        <?php foreach ($firstColumnData as $index => $value): ?>
                          <tr>
                              <input type="hidden" id="idx-<?php echo $index ?>" value="<?php echo $index ?>">
                              <input type="hidden" id="name-<?php echo $index ?>" value="<?php echo $value[0] ?>">
                              <input type="hidden" id="idno-<?php echo $index ?>" value="<?php echo $value[1] ?>">
                              <td><?php echo htmlspecialchars($index); ?></td>
                              <td><?php echo htmlspecialchars($value[0]); ?></td>                                  
                              <td><?php echo htmlspecialchars($value[1]); ?></td>                                  
                              
                              <td><?php print "<div id='code-$index'>  </div>";  ?>  </td>                              
                              
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
  function roboto(idx)
  {
    var idno = document.querySelector("#idno-" + idx.toString()).value.trim();
    var name = document.querySelector("#name-" + idx.toString()).value.trim();

    var divCode = "#code-" + idx.toString();
    
    
    $(divCode).html("<i class='fa fa-spinner fa-spin'></i>");
    
    jQuery.getJSON('<?php print caNavUrl($this->request, '*', 'Adding', 'CreateArtist'); ?>', {idno, name}, function(data) {        
      $(divCode).html(data);         
      
      $("#output").html(idx);     
      roboto(idx + 1); 
    });  
  }  
</script>




<br>
<br>
<br>
<br>
<br>
<br>



<!-- HTML Section -->
