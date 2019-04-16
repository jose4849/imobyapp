<div id="wrapper">
    <div id="leftMenu">
        <ul>
            <?php 
            if(is_array($menuItems)){
                foreach($menuItems as $menuTitle => $itemDetails){
                    $class = ($itemDetails['active']) ? 'leftMenuActive' : 'leftMenuItem';
                    echo '<li><a href="'.$itemDetails['link'].'" class="'.$class.'">'.$menuTitle.'</a></li>'."\n";
                }
            }
            ?>
        </ul>        
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar"><?php echo $breadcrumbs; ?></div>