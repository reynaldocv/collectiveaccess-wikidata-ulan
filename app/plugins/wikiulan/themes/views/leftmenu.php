
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
<script>
      var menu = "<?php print $menu ?>";

      jQuery("#leftNavSidebar").html(menu);

  </script>


