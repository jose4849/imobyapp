<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Imoby.nl</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="author" content="Imoby.nl" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/login.css" type="text/css" media="print, projection, screen" />
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.10.2.js"></script>
    </head>
    <body>
        <script type="text/javascript">
            // <![CDATA[

            $(document).ready(function() {
                $("input#user").val("E-mail");
                $("input#pass").val("Password");

                $("input#user").focus(function() {
                    if ($(this).val() == "E-mail") {
                        $(this).val("");
                    }
                });

                $("input#pass").focus(function() {
                    if ($(this).val() == "Password") {
                        $(this).val("");
                    }
                });

                $("input#user").focusout(function() {
                    if ($(this).val() == "") {
                        $(this).val("E-mail");
                    }
                });

                $("input#pass").focusout(function() {
                    if ($(this).val() == "") {
                        $(this).val("Password");
                    }
                });

                // als de velden niet zijn ingevult niet posten
                $("input#login").click(function(event) {
                    if ($("input#user").val() == "E-mail" || $("input#pass").val() == "Password") {
                        event.preventDefault();
                        return false;
                    }
                });

            });

            // ]]>
        </script>