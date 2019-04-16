<ul>
            <li><a href="<?= site_url('/backoffice/instellingen/profiel') ?>" class="<?php echo ($activeTab == 'profile') ? 'leftMenuActive' : 'leftMenuItem'?>">Profiel</a></li>
            <li><a href="<?= site_url('/backoffice/instellingen/huisstijl') ?>" class="<?php echo ($activeTab == 'identity') ? 'leftMenuActive' : 'leftMenuItem'?>" >Huisstijl</a></li>
            <li><a href="<?= site_url('/backoffice/instellingen/socialmedia') ?>" class="<?php echo ($activeTab == 'socialmedia') ? 'leftMenuActive' : 'leftMenuItem'?>" >Social Media</a></li>
            <li><a href="<?= site_url('/backoffice/relatiebeheer/settings') ?>" class="<?php echo ($activeTab == 'relatiebeheer') ? 'leftMenuActive' : 'leftMenuItem'?>" >Relatiebeheer</a></li>
</ul>