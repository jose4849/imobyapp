<?php $this->load->view('backoffice/layouts/header'); ?><script type="text/javascript">    function customCheckbox(checkboxName){        var checkBox = $('input[name="'+ checkboxName +'"]');        $(checkBox).each(function(){            $(this).wrap( "<span class='custom-checkbox'></span>" );            if($(this).is(':checked')){                $(this).parent().addClass("selected");            }        });        $(checkBox).click(function(){            $(this).parent().toggleClass("selected");        });    }    $(document).ready(function (){        customCheckbox("emailcheck[]");        customCheckbox("car[]");        customCheckbox("confirm");    }) </script>

<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('backoffice/posts/layouts/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar"><a href="/crm/relaties" class="breadcrumb">Berichten</a> > <span class="lastBreadcrumbs">Postvak IN</span></div>
        <div class="grayColumn">
            <div class="titleBar3">Verwijderd</div>
            <div class="blue-bar">
                <ul>
                    <li>
                        <input id="checkbox65" class="css-checkbox med" type="checkbox" >
                        <label class="css-label med elegant" name="checkbox65_lbl" for="checkbox65"></label>
                    </li>                 
                    <li><a onclick="move_delete()" >Verwijderen</a></li>
                </ul>
            </div>
            <div class="contentBlock1">
                <div class="contant-white">
<form id="form" >
                        <table class="berichtenTable" cellpadding="0" cellspasing="0">
                            <?php foreach ($email as $mail) { ?> 

                                <tr>
                                    <td style="width:20px" >
                                        <label><input class="selectedId" type="checkbox" name="emailcheck[]" value="<?php echo $mail->email_id; ?>" /></label>
                                    </td>
                                    <td style="width:30%;">
                                        <span class="color1">
                                            <a style="text-decoration: none; font-weight: bold; color: rgb(0, 175, 216);" href="<?php echo base_url('backoffice/berichten/view'); ?>/<?php echo $mail->email_id; ?>">
                                                <?php echo word_limiter($mail->from, 5); ?>&nbsp;
                                            </a>
                                        </span>
                                    </td>
                                    <td>
                                        <a style="line-height: 19px;text-decoration: none; font-weight: bold;">
                                            <?php
                                            echo word_limiter($mail->subject, 7);
                                            if ($mail->body == '') {
                                               // echo 'No subject';
                                            }
                                            ?>
                                        </a>
                                    </td>
                                    <td style="width:17px;">
                                        <?php
                                        $isDir = (is_dir(FILEDIR . "/emailattachment/" . $mail->email_id));
                                        if ($isDir) {
                                            ?>
                                            <img src="<?php echo base_url(); ?>assets/icon-att.png" height="15" />
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td ><span style="line-height: 19px;" class="color3">06-07-1982 22:23<?php //echo $mail->recived_date; ?></span> </td>
                                    <td>
                                        <img height="22" src="<?php echo base_url(); ?>assets/cal.png" />
                                    </td>
                                </tr>


                        <?php } ?>
                        </table>
                    </form>




                    <div class="contant-white-bottom">
                        <div class="page-left-t">
                            <span><?php echo $count; ?> berichten</span>
                        </div>
                        <div class="page-nav">
                            <ul>
                                <li>Pagina 1</li>
                                <li><a class="prev" href="#">Prev</a></li>
                                <li><a class="next" href="#">Next</a></li>
                            </ul>
                        </div>
                    </div>
                </div>	
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#checkbox65').click(function () {
            $('.selectedId').prop('checked', this.checked);
        });

        $('.selectedId').change(function () {
            var check = ($('.selectedId').filter(":checked").length == $('.selectedId').length);
            $('#checkbox65').prop("checked", check);
        });
    });


    function move_delete() {
        var check_ids = ($('input[name="emailcheck"]:checked').serializeArray());
        //alert(check_ids);

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>backoffice/berichten/emaildelete",
            data: {check_ids: check_ids, box: 'debox'},
            success: function (msg) {
                alert("Successfully Deleted.");
                alert(msg);
                // location.reload();
            }
        });


    }
</script>
<?php $this->load->view('backoffice/layouts/footer'); ?>
