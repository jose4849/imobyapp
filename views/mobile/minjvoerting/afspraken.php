<?php echo $header; ?>
<style type="text/css">
    table{ width: 100%;}
    table thead{ background: #d6d6d6;}
    table thead tr{}
    table thead tr th{ text-align: left; padding: 2.4vw 2vw;}
    table thead tr th:last-child{ width: 65%;}
    table tbody{}
    table tbody tr td{}
    table tbody tr td{ padding: 1vw 2vw; font-size: 3.5vw;}
</style>
<header class="top">
    <div class="row nav-view">
        <div class="container1">
            <div class="l-1 nopad">
                <a href="<?= base_url(); ?>mobile/home/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-reply"></i></a>
            </div>
            <div class="l-10">
                <span class="single-page-title">Mijn Afspraken</span>
            </div>                
            <div class="l-1 nopad">
                <a href="<?= base_url(); ?>mobile/home/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-home"></i></a>
            </div>                
        </div>
    </div>
</header>		
<section>
    <div class="container1 commonpage">
        <table>
            <thead>
                <tr>
                    <th>Datum</th>
                    <th>Omschrijving</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Merk:</td><td>Volkswagen</td></tr>
                <tr><td>Type:</td><td>Golf GTI</td></tr>
                <tr><td>Transmissie:</td><td>Automaat</td></tr>
                <tr><td>Brandstof:</td><td>Benzine</td></tr>
                <tr><td>KM stand:</td><td>23.456</td></tr>
            </tbody>
            <tfoot></tfoot>
        </table>
        <?php include('layout/footer2.php') ?>
    </div>
</section>            
<?php echo $footer; ?>