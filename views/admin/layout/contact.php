<?php $this->load->view('admin/layout/header'); ?>
<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('admin/layout/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar">
            <a href="#" class="breadcrumb">Admin Panel</a> > <span class="lastBreadcrumbs">Contact</span>
        </div>
        <div class="grayColumn">
            <div class="titleBar">Contactgegevens</div>
            <div class="contentBlock">
                <div class="company1">
                    <div class="content-left">
                        <h2>Hoofdkantoor:</h2>
                        <p>Imoby BV<br>
                            Nieuwe Kade 16<br>
                            6827 AB Arnhem<br>
                        </p>
                        <p>Telefoon: 026-3020027<br>
                            </p>
                        <p>KvK: 54056152</p>
                    </div>
                    <div class="content-right">
                        <p>De klantenservice van Imoby is geopend op maandag t/m vrijdag van 8:30 to 17:00 uur.<br>Onze medewerkers staan u graag te woord.</p>
                    </div>
                </div>
                <div class="clearfix"></div>                            
                </form>
            </div>
        </div> 
    </div>
</div>
<?php $this->load->view('admin/layout/footer'); ?>