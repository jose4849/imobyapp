<?php $this->load->view('common/layout/login-header'); ?>
<div id="forgotwrapper" class="wrapper">
    <div id="forgotscreen" class="screen">
        <div class="forgotmessage">
            <?php echo $this->session->flashdata('message'); ?>
        </div>
        <?php echo validation_errors(); ?>
        <?php echo form_open("wachtwoordvergeten"); ?>
        <?php echo form_input($email); ?>
        <?php echo form_submit($submit, "verstuur"); ?>
        <?php echo form_close(); ?>
    </div>
</div>
<?php $this->load->view('common/layout/login-footer'); ?>