<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
            <meta http-equiv="Content-Language" content="NL" />
            <title><?= $pagetitle; ?> | Imoby.nl</title>

            <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.dataTables.css" type="text/css" media="print, projection, screen" />
            <link rel="stylesheet" href="<?= base_url() ?>assets/css/crm.css" type="text/css" media="print, projection, screen" />
            <link rel="stylesheet" href="<?= base_url() ?>assets/css/klanten.css" type="text/css" media="print, projection, screen" />

            <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-1.10.2.js"></script>
            <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-ui-1.10.3.js"></script>
            <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-ui-timepicker.js"></script>
            <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.ui.datepicker-nl.js"></script>
            <script type="text/javascript" src="<?= base_url() ?>assets/js/crm.js"></script>
            <script type="text/javascript" src="<?= base_url() ?>assets/js/klanten.js"></script>
            
            <script type="text/javascript">
                $(function() {
                    $("#tabs").tabs();
                });
            </script>

            <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css" type="text/css" media="print, projection, screen" />
    </head>
    <body>
        <div id="header">
            <div id="headerWrapper">
                <div id="headerMenu">
                    <ul>
                        <li class="hassub">
                            <a href="#"><img class="username" src="<?= base_url() ?>assets/images/menuUsername.png" /><?= $user->first_name . ' ' . $user->last_name; ?></a>
                        </li>
                        <li>
                            <a href="<?= site_url('logout'); ?>"><img class="uitloggen" src="<?= base_url() ?>assets/images/menuUitloggen.png" />Uitloggen</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="bottomHeader">
            <div id="bottomHeaderWrapper">
                <h1 class="top-menu-logo"><img src="<?= base_url() ?>assets/images/logo.png" alt="Imoby.nl - CRM" title="Imoby.nl - CRM" id="topMenuLogo"/></h1>
                <h2>Admin Panel</h2>
                <div id="bottomHeaderMenu">
                    <ul>
                        <li>
                            <a href="#">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>