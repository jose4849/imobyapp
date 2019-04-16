<?php $this->load->view('backoffice/layouts/header'); ?>
<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('backoffice/settings/layouts/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar">
            <a href="#" class="breadcrumb">Instellingen</a> > <span class="lastBreadcrumbs">Huisstijl</span>
        </div>
        <div class="grayColumn">
            <div class="titleBar">Huisstijl</div>
            <div class="contentBlock1">
                <div class="contant-white">
                    <div class="desktop-img">
                        <div class="desktop-inner">
                            <img src="<?= base_url() ?>assets/crmAssets/images/desktop-inner.png" alt="#" />
                        </div>
                        <div class="mobile-img">
                            <img src="<?= base_url() ?>assets/crmAssets/images/mobile-inner.png" alt="#" />
                        </div>
                    </div>
                    <div class="color-picker">
                        <h3>Kleurkeuze huisstijl</h3>
                        <ul>
                            <li><a <?php if($colorschme=='red'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="red" id="id1" onclick="selectedcolor(1)" class="color1" ></a></li>
                            <li><a <?php if($colorschme=='selective-yellow'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="selective-yellow" id="id2" onclick="selectedcolor(2)" class="color2"></a></li>
                            <li><a <?php if($colorschme=='yellow'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="yellow" id="id3" onclick="selectedcolor(3)" class="color3"></a></li>
                            <li><a <?php if($colorschme=='mantis'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="mantis" id="id4" onclick="selectedcolor(4)" class="color4"></a></li>
                            <li><a <?php if($colorschme=='nocolor'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="nocolor" id="id5" onclick="selectedcolor(5)" class="color5"></a></li>
                            <li><a <?php if($colorschme=='san-mariono'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="san-mariono" id="id6" onclick="selectedcolor(6)" class="color6"></a></li>
                            <li><a <?php if($colorschme=='medium-purple'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="medium-purple" id="id7" onclick="selectedcolor(7)" class="color7"></a></li>
                            <li><a <?php if($colorschme=='hot-pink'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="hot-pink" id="id8" onclick="selectedcolor(8)" class="color8"></a></li>
                            <li><a <?php if($colorschme=='scorpion'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="scorpion" id="id9" onclick="selectedcolor(9)" class="color9"></a></li>
                            <li><a <?php if($colorschme=='maroon'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="maroon" id="id10" onclick="selectedcolor(10)" class="color10"></a></li>
                            <li><a <?php if($colorschme=='cinnamon'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="cinnamon" id="id11" onclick="selectedcolor(11)" class="color11"></a></li>
                            <li><a <?php if($colorschme=='olive'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="olive" id="id12" onclick="selectedcolor(12)" class="color12"></a></li>
                            <li><a <?php if($colorschme=='japanese-laurel'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="japanese-laurel" id="id13" onclick="selectedcolor(13)" class="color13"></a></li>
                            <li><a <?php if($colorschme=='orient'){ echo "style='border:5px solid black'"; } ?>  href="javascript:void(0)" data-id="orient" id="id14" onclick="selectedcolor(14)" class="color14"></a></li>
                            <li><a <?php if($colorschme=='resolutionblue'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="resolutionblue" id="id15" onclick="selectedcolor(15)" class="color15"></a></li>
                            <li><a <?php if($colorschme=='pigment-indigo'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="pigment-indigo" id="id16" onclick="selectedcolor(16)" class="color16"></a></li>
                            <li><a <?php if($colorschme=='fresh-eggplant'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="fresh-eggplant" id="id17" onclick="selectedcolor(17)" class="color17"></a></li>
                            <li><a <?php if($colorschme=='mine-shaft'){ echo "style='border:5px solid black'"; } ?> href="javascript:void(0)" data-id="mine-shaft" id="id18" onclick="selectedcolor(18)" class="color18"></a></li>                            
                        </ul>
                        <input type="hidden" id="color" value="" />
                    </div>
                    <div class="buttonholder right">
                        <a onclick="applicationcoloer()" class="button addRelatie1" href="javascript:void(0)">
                            <img  class="add" src="<?= base_url() ?>assets/crmAssets/images/vinkje.png">Opslaan
                        </a>
                    </div>
                </div>
            </div>	
        </div>
    </div>

</div>


<script>
    function selectedcolor(id){
        $('#color').val(id);
        var color = $('#color').val();
        $('#id'+id).css('border', '5px solid black'); 
        $('#id'+id).addClass('classselected');   
        $( "li > a" ).not('#id'+id).css( "border", "none" );   
    }    
    function applicationcoloer(){
        // alert("hello");
        var idname=$(".classselected").attr('id');
        var colorschrme = $("#"+idname).attr("data-id");

        var url = "<?php echo base_url('backoffice/instellingen/colorschrme'); ?>/";
        $.ajax({
            url: url,
            type: "post",
            data:{colorschrme:colorschrme,dealer_id:'<?php echo ($dealer[0]->dealer_id); ?>'},
            success: function(e) {
               alert(e);
               location.reload();
            }});
    }
</script>
<?php $this->load->view('backoffice/layouts/footer'); ?>
