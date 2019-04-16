<?php $this->load->view('admin/layout/header'); ?>
<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('admin/layout/leftMenu', $activeTab); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar"><a class="breadcrumb" href="/crm/relaties"><font class="">Admin Panel</a><font class=""> &gt; <span class="lastBreadcrumbs"><font class="">Beheerders</span></div><div class="grayColumn">
            <div class="titleBar">Beheerders</div>
            <div class="contentBlock user-list">
                <?php if($superadmin==1){ ?>
                <a href="<?= site_url('admin/beheerders/add') ?>" class="button addRelatie"><img src="<?= base_url() ?>assets/images/add.png" class="add" />Nieuwe beheerder</a><br>
                <?php } ?>
                <form class="beheerdersform" action="<?= base_url() ?>admin/beheerders" method="POST" id="klanten-filter">
                    <table id="autos-tabel-overview">
                        <thead>
                            <tr>
                                <th class="p10"><span class="tableHeaderLabel">User ID</span><br><input type="text" value="<?php echo isset($_POST['userid']) ? $_POST['userid'] : ''; ?>"  name="userid"></th>
                                <th class="p20"><span class="tableHeaderLabel">Naam</span><br><input type="text" value="<?php echo isset($_POST['Naam']) ? $_POST['Naam'] : ''; ?>"  name="Naam"></th>
                                <th class="p20"><span class="tableHeaderLabel">Organisatie</span><br><input type="text" value="<?php echo isset($_POST['organization']) ? $_POST['organization'] : ''; ?>"  name="organization"></th>
                                <th class="p25"><span class="tableHeaderLabel">Telefoonnummer</span><br><input type="text" value="<?php echo isset($_POST['Telefoonnummer']) ? $_POST['Telefoonnummer'] : ''; ?>"   name="Telefoonnummer"></th>
                                <th class="p25"><span class="tableHeaderLabel">E-mail</span><br><input type="text" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" name="email"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($administrators)) {
                                foreach ($administrators as $key => $value) {
                                    
                                   
                                    
                                    ?>
                                    <tr>
                                        <td><?php echo $value->new_id; ?></td>
                                        <td><a href="<?= site_url('/admin/beheerders/edit/'.$value->new_id) ?>"><?php echo $value->firstName . ' ' . $value->middleName . ' ' . $value->lastName; ?></a></td>
                                        <td><a href=""><?php echo $value->organization; ?></a></td>
                                        <td><a href=""><?php echo $value->phoneNumber1; ?></a></td>
                                        <td><a href=""><?php echo $value->email; ?></a></td>
                                    </tr>

                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
                <div class="page-nav" style="width:99px;float:right;" >
<!--                    <ul>
                        <li>Pagina <?php echo ($this->uri->segment(4)) ? $this->uri->segment(4) + 1 : 1 ?></li>
                    </ul>-->
                    <?php
                    if (isset($pagination)) {
                        echo $pagination;
                    }
                    ?>
                    <!-- <ul>
                        <li>Page 1</li>
                        <li><a class="prev" href="#">Prev</a></li>
                        <li><a class="next" href="#">Next</a></li>
                    </ul> -->
                </div>
                <div class="clearfix"></div>
            </div>
        </div>        
    </div>
</div>
<?php $this->load->view('admin/layout/footer'); ?>