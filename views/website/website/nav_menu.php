<style>
 .aactive{background-color: #8c1b17 !important;}   
</style>
<ul>
    <li><a <?php if($active=='home'){ echo "class='aactive'"; } ?>  href="<?php echo base_url(); ?><?php echo $homePageId; ?>">Home</a></li>
    <li><a <?php if($active=='annbod'){ echo "class='aactive'"; } ?> href="<?php echo base_url(); ?>site/annbod/<?php echo $stockPageId; ?> ">Aanbod</a></li>
    <?php
    $x=0;
    foreach ($pages_title as $title) { ?>
        <li><a <?php if($active==$pages[$x]){ echo "class='aactive'"; } ?> href="<?php echo base_url(); ?>site/<?php echo $pages[$x]; ?>/<?php echo $homePageId; ?>"><?php echo $title;  ?></a></li>
    <?php $x++; } ?>
    <li><a <?php if($active=='contact'){ echo "class='aactive'"; } ?> href="<?php echo base_url(); ?>site/contact/<?php echo $homePageId; ?>">Contact</a></li>
</ul>