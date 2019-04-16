<style>
 .aactive{background-color: #8c1b17 !important;}   
</style>
<ul>
    <li><a <?php if($active=='voertuigen'){ echo "class='aactive'"; } ?>  href="<?php echo base_url('relatie/voertuigen'); ?>">Mijn Auto's</a></li>
    <li><a <?php if($active=='instellingen'){ echo "class='aactive'"; } ?> href="<?php echo base_url('relatie/instellingen'); ?>">Mijn Instellingen</a></li>
    <li><a <?php if($active=='afspraken'){ echo "class='aactive'"; } ?> href="<?php echo base_url('relatie/afspraken'); ?>">Mijn Afspraken</a></li>
</ul>