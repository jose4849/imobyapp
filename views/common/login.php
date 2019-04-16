<?php $this->load->view('common/layout/login-header'); ?>
<div id="loginwrapper" class="wrapper">
    <div id="loginscreen" class="screen">
        
        <div class="loginmessage">
            <?php echo $this->session->flashdata('message'); ?>
        </div>
        <?php echo validation_errors(); ?>
        <?php echo form_open("login"); ?>
        <?php echo form_input($username); ?>
        <?php echo form_input($password); ?>
        <?php echo form_submit($submit, lang('login_submit_btn')); ?>
        <?php echo form_close(); ?>
        <!-- <a href="<?php echo site_url('wachtwoordvergeten'); ?>"><?php echo lang('login_forgot_link') ?>?</a>-->
        <a href="<?php echo site_url('wachtwoordvergeten'); ?>">vergeet wachtwoord ?</a>
    
    </div>
</div>
<?php $this->load->view('common/layout/login-footer'); ?>