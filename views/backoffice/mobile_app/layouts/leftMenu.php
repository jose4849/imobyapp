<?php //echo $activeTab; ?>
<ul>
    <li><a class=" <?php echo ($activeTab == 'mobileapp') ? 'leftMenuActive' : 'leftMenuItem'?>" href="<?= site_url('/backoffice/webmobiel/homepagina') ?>" >Homepagina</a></li>
    <li><a class=" <?php echo ($activeTab == 'aanbodpagin') ? 'leftMenuActive' : 'leftMenuItem'?>" href="<?= site_url('/backoffice/webmobiel/aanbodpagina') ?>" >Aanbodpagina</a></li>
    <li><a class=" <?php echo ($activeTab == 'website') ? 'leftMenuActive' : 'leftMenuItem'?>" href="<?= site_url('/backoffice/webmobiel/website') ?>" >Website</a></li>
    <li><a class=" <?php echo ($activeTab == 'presentaties') ? 'leftMenuActive' : 'leftMenuItem'?>" href="<?= site_url('/backoffice/webmobiel/presentaties') ?>" >Presentaties</a></li>
    <li><a class=" <?php echo ($activeTab == 'statistieken') ? 'leftMenuActive' : 'leftMenuItem'?>" href="<?= site_url('/backoffice/webmobiel/statistieken') ?>" >Statistieken</a></li>
</ul>