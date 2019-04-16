<?php $this->load->view('admin/layout/header'); ?>
<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('admin/layout/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar">
            <a href="#" class="breadcrumb">Admin Panel</a> > <a href="#" class="breadcrumb">Gebruikers</a> > <span class="lastBreadcrumbs">Garagebedrijf X</span>
        </div>
        <div class="grayColumn">
            <div class="titleBar"><?= $pagetitle; ?></div>

        </div>
    </div>
</div>
<?php $this->load->view('admin/layout/footer'); ?>