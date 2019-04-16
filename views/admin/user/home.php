<?php $this->load->view('admin/layout/header'); ?>
<style>
     /* .page-nav ul li{ float:right !important; } */
</style>
<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('admin/layout/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar">
            <a href="#" class="breadcrumb">Admin Panel</a> > <span class="lastBreadcrumbs">Gebruikers</span>
        </div>
        <div class="grayColumn">
            <div class="titleBar">Gebruikers</div>
            <div class="contentBlock user-list">
                <a href="<?= site_url('admin/gebruikers/nieuwegebruiker') ?>" class="button addRelatie"><img src="<?= base_url() ?>assets/images/add.png" class="add" />Nieuwe gebruiker</a><br>
                <form class="gebruikersform" action="#" method="POST" id="klanten-filter">
                    <?php
                    if(isset($_POST['crm'])){ $crm='checked="1"'; } else{ $crm=''; }
                    if(isset($_POST['mob'])){ $mob='checked="1"'; } else{ $mob=''; }
                    ?>
                    <table id="autos-tabel-overview">
                        <thead>
                            <tr>
                                <th class="p10"><span class="tableHeaderLabel">Imoby ID</span><br><input type="text" value="" size="4" maxlength="7" name="userid" class="userId"></th>
                                <th class="p30"><span class="tableHeaderLabel">Naam garage</span><br><input type="text" value="" size="4"  name="dealerName" class="naamGarage"></th>
                                <th class="p35"><span class="tableHeaderLabel">Adresgegevens</span><br><input type="text" value="" size="4"  name="dealerAddress" class="adresgegevens"></th>
                                <th class="p15"><span class="tableHeaderLabel">Contactpersoon</span><br><input type="text" value="" size="4"  name="contact" class="contactpersoon"></th>
                                <th class="p5"><span class="tableHeaderLabel">RBH</span><br><input type="checkbox" <?php echo $crm; ?> value="1"  name="crm" class="userId"></th>
                                <th class="p5"><span class="tableHeaderLabel">WEB</span><br><input type="checkbox" <?php echo $mob; ?> value="1"  name="mob" class="userId"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($dealers)) {
                                foreach ($dealers as $key => $value){
                                    ?>                            
                                <tr>
                                    <td><?php echo $value->homePageId; ?></td>
                                    <td><a href="<?= site_url('admin/gebruikers/details') ?>/<?php echo $value->user; ?>"><?php echo $value->name; ?></a></td>
                                    <td>
                                        <?php echo $value->street; ?> <?php echo $value->house_num; ?> <?php echo $value->house_num_addition; ?><br>
                                        <?php echo $value->postal_code; ?> <?php echo $value->city; ?>
                                        </td>
                                    <td><a href="<?= site_url('admin/gebruikers/details') ?>/<?php echo $value->user; ?>"><?php echo $value->firstName . ' ' . $value->middleName . ' ' . $value->lastName; ?></a></td>
                                    <?php 
                                    $functions = explode(",", $value->dealerFunctions);
                                   // print_r($functions);
                                    ?>
                                    <td><?php $true=(in_array("2", $functions)); if($true==1){  echo 'Ja'; }else{ echo "Nee"; } ?></td>
                                    <td><?php $true=(in_array("1", $functions)); if($true==1){ echo 'Ja'; }else{ echo "Nee"; } ?></td>
                                </tr>
                                <?php
                            }
                            }
                            ?>
                        </tbody>
                    </table>                            
                </form>
<!--                <div class="page-nav">
                    <div style="border: 0px solid red; width: 50px; float: left;">Pagina <?php echo ($this->uri->segment(4)) ? $this->uri->segment(4) + 1 : 1 ?></div>
                    <div style="border: 0px solid red; width: 100px; float: left;">
                        <?php

                    if (isset($pagination)) {
                        echo $pagination;
                    }
                    ?>
                    </div>
                </div>-->
                
                <div class="page-nav" style="width:99px;float:right;">
                    
                   <!-- Pagina <?php // echo ($this->uri->segment(4)) ? $this->uri->segment(4) + 1 : 1 ?> -->
                    <?php

                    if (isset($pagination)) {
                        echo $pagination;
                    }
                    ?>
                 </div>
               
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/layout/footer'); ?>