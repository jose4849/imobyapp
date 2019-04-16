<a href="<?php echo site_url('login'); ?>">Login</a>

<?php
    echo "<pre>";
    print_r($this->session->userdata('identity'));
?>