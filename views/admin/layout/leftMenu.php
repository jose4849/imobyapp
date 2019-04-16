<ul>
            <li><a href="<?= site_url('/admin/gebruikers') ?>" class="<?php echo ($activeTab == 'user') ? 'leftMenuActive' : 'leftMenuItem'?>">Gebruikers</a></li>
            <li><a href="<?= site_url('/admin/beheerders') ?>" class="<?php echo ($activeTab == 'administrator') ? 'leftMenuActive' : 'leftMenuItem'?>">Beheerders</a></li>
            <li><a href="#" class="leftMenuItem">Rapportages</a></li>
            <li><a href="#" class="leftMenuItem">Importeren gebruikers</a></li>
            <li><a href="#" class="leftMenuItem">Statistieken</a></li>
            <li><a href="#" class="leftMenuItem">Marketing</a></li>
            
            <li><a href="<?= site_url('/admin/beheerders') ?>/instellingen/<?php echo $user->user_id; ?>" class="<?php echo ($activeTab == 'instellingen') ? 'leftMenuActive' : 'leftMenuItem'?>">Instellingen</a></li>
</ul>