<ul id="deshboard-menu">
                    <li  class="<?php echo ($activeTab == 'dashboard') ? 'active' : ''?>" >
                        <a href="<?= site_url('/backoffice/dashboard') ?>"><span class="icon-home"></span>Home</a>
                    </li>
                    <li class="<?php echo ($activeTab == 'offer') ? 'active' : ''?>" >
                        <a href="#"><span class="icon-offer"></span><font><font>Offer</font></font></a>
                    </li>
                    <li class="<?php echo ($activeTab == 'presentations') ? 'active' : ''?>" >
                        <a href="#"><span class="icon-presentation"></span><font><font>Presentations</font></font></a>
                    </li>
                    <li class="<?php echo ($activeTab == 'statistics') ? 'active' : ''?>" >
                        <a href="#"><span class="icon-statistics"></span><font><font>Statistics</font></font></a>
                    </li>
                    <li class="<?php echo ($activeTab == 'report') ? 'active' : ''?>" >
                        <a href="#"><span class="icon-post"></span><font><font>Report</font></font></a>
                    </li>
</ul>