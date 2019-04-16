<!DOCTYPE html>
<html>
    <head>
        <title>Imoby</title>
        <meta name="viewport" content="width=device-width">        
        <!--<link rel="stylesheet" href="https://bengal-grid.googlecode.com/git/bengal-grid-v2.css" type="text/css" media="print, projection, screen" />-->
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/bengal-grid-v3.css" type="text/css" media="print, projection, screen" />
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/style.css" type="text/css" media="print, projection, screen" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/kstyle.css" type="text/css" media="print, projection, screen" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/icofont/style.css" type="text/css" media="print, projection, screen" /> 
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/scheme/blue.css" type="text/css" media="print, projection, screen" />        
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" charset="utf-8">
            function goBack() {
                window.history.back()
            }
        </script>		
    </head>
    <style type="text/css">
        body{ font-family: Verdana; background: #f6f4f4; }
        h2{font-family: "Klavika Regular"; color: #00afd8; font-size: 9vw; text-align: center; font-weight: normal;}
        .slide-div{  padding: 1.5rem 0 0; text-align: center;}
        .about-imoby p{ font-size: 3.5vw; line-height: 5.5vw;}
        .head-office{ text-align: center; padding: 1vw 0;}
        .head-office label{ font-weight: bold; cursor: default; margin-bottom: 0.5rem;}
        .head-office span{ display: block;  margin-bottom: 0.5rem;}
        .phone{ text-align: center; padding: 1vw 0;}
        .phone label{font-weight: bold; cursor: default; }
        .phone span{ display: block; margin-bottom: 0.5rem;}
        .e-mail{ text-align: center; padding: 1vw 0;}
        .e-mail label{font-weight: bold; cursor: default; }
        .e-mail span{ display: block; margin-bottom: 0.5rem;}
        .kvk{ text-align: center; padding: 1vw 0 2vw;}
        .kvk label{font-weight: bold; cursor: default; }
        .kvk span{ display: block; margin-bottom: 0.5rem;}
        .contributor1{}
        .contributor1 .container1{ margin-bottom: 0;}
        .ari-blog{ text-align: center;}
        .ari-blog .row{ padding-bottom: 2rem;}
        .ari-blog label{ text-align: center; display: block; cursor: default;}
        .ari-blog label img{}
        .ari-blog span{ font-weight: bold; text-align: center; float: left; text-align: center; padding: 2vw 0; width: 100%; font-size: 3.5vw;}
        .ari-blog p{ text-align: center; line-height: 5.5vw; font-size: 3.5vw;}
        .contact-form{ background: #f6f4f4; border-top: 1px solid #d0cccc;  padding: 2rem 0;}
        .contact-form .container1{ margin-bottom: 0;}
        .contact-form form{}
        .contact-form form h2{ font-size: 8vw;}
        .info-form form p{ font-size: 3.5vw; line-height: 5.5vw; text-align: center;}
        .contact-form form p label{ text-align: center; font-weight: 400; cursor: default;}
        .contact-form form p .submit-bnt{ border: none; background: #00aed7; color: #fff; font-weight: bold; text-transform: uppercase; width: 80%; margin: 0 auto; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; }

        .footer-bottom{ background: #212121; color: #fff; margin: 0; padding: 2rem 0;        }
        .footer-bottom h2{padding: 0.3em 0; line-height: 0;}
        .footer-bottom p{ text-align: center; font-size: 3.5vw; line-height: 5.5vw; }
        .footer-bottom ul{}
        .footer-bottom ul li{text-align: center;}
        .footer-bottom ul li a{
            text-align: center; font-size: 3.5vw; line-height: 5.5vw; text-decoration: underline; color: #fff; }
        .footer-bottom .container1{ margin-bottom: 0;}    
        section.ur-package{
            background: #f6f4f4;  padding: 2rem 0; 
        }
        .ur-package .conttainer1{
            background: #f6f4f4; margin-bottom: 0;
        }
        ul.package-ul{ text-align: center;}
        ul.package-ul li{ list-style: none; display: inline; text-align: center; vertical-align: bottom; }
        section.wit{ padding: 2rem 0; border-top: 1px solid #d0cccc;  border-bottom: 1px solid #d0cccc;}
        section.wit .container1{margin-bottom: 0;}
        ul.soical-icon{ text-align: center; }
        ul.soical-icon li{  text-align: center; list-style: none; display: inline; }
        .imoby-finance{ background: #f6f4f4; border-top: 1px solid #d5d4d5; padding: 2rem 0;}
        .imoby-finance .container1{ margin-bottom: 0;}
        .imoby-finance h2{ text-align: left; font-size: 8vw; text-align: center;}
        .imoby-finance p{ font-size: 4vw; line-height: 6vw;}
        .imoby-finance .video-img{ text-align: center;  }
        .our-service{ padding-top: 2rem;}
        .our-service .container1{ margin-bottom: 0;}
        ul.service-ul{}
        ul.service-ul li:first-child{ border-top: 1px solid #b6b6b6}
        ul.service-ul li{ border-bottom: 1px solid #b6b6b6; padding-left: 20px; }            
        ul.service-ul li a{  color: #000; padding: 0 8vw; line-height: 10vw; font-size: 3.5vw; font-weight: bold; background: url("<?= base_url() ?>assets/mobile/images/right-arow.png") left top no-repeat; }            
        section.img-gallery{ padding: 2rem 0; border-top: 1px solid #d0cccc;}
        section.img-gallery img{display: block;}

        .main:before {
            width:100%;     height:100%;
            position:absolute;
            top:0px; left:0px; z-index:-1;
            content:''; }
        .mobile-marketing, .mobile-marketing * {
            -webkit-box-sizing:border-box; 
            -moz-box-sizing:border-box; 
            box-sizing:border-box;
        }

        .mobile-marketing{
            overflow:hidden;
            box-shadow:0px 1px 3px rgba(0,0,0,0.25);
            border-radius:3px;
            background:#f7f7f7;
        }

        /*----- Section Titles -----*/
        .accordion-section-title {
            width:100%;
            display:inline-block;
            border-bottom:1px solid #1a1a1a;
            color: #000;
            background: url("<?= base_url() ?>assets/mobile/images/right-arow.png") 15px 13px no-repeat; #ffffff;
            transition:all linear 0.15s;
            padding: 0 11vw; line-height: 11.5vw; font-size: 3.5vw; font-weight: bold;

        }
        .accordion-section-title.active{
            border-bottom: 1px solid #ccc;
            background: url("<?= base_url() ?>assets/mobile/images/bottom-arow.png") 15px 13px no-repeat; #ffffff;
        } 
        .accordion-section-title:hover {
            /* Type */
            text-decoration:none;
        }
        .accordion-section:last-child .accordion-section-title {
            border-bottom:none;
        }
        .accordion-section-content {
            padding:15px;
            display:none;
            border-bottom: 1px solid #ccc; background: #fff;
        }
    </style>
    <body>
        <header class="top">
            <div class="row nav-view">
                <div class="container1">
                    <div class="l-1 nopad">
                        <a href="#"><i class="fa fa-reorder"></i></a>
                    </div>
                    <div class="l-10">
                        <span class="single-page-title">imoby</span>
                    </div>                
                    <div class="l-1 nopad-r"><a class="noeffect right"><i class="fa fa-search"></i></a></div>                
                </div>
            </div>
        </header>
        <section class="slide-div bg-white">
            <img src="<?= base_url() ?>assets/mobile/images/slide-img4.jpg" alt="slide img" />
        </section> 
        <section class="imoby-finance">
            <div class="container1">
                <div class="row">
                    <div class="l-12">
                        <h2>Meer dan een mobiele website alleen</h2>
                        <p>Tevreden klanten behoren tot de belangrijkste kapitaalgoederen van een onderneming. Steeds meer organisaties onderkennen dat en zien de noodzaak om de relatie met bestaande klanten goed te onderhouden. Relatiebeheer vormt een belangrijk hulpmiddel want daarmee maak u van uw klanten loyale relaties.</p>
                        <p>Imoby Relatiebeheer is cloud software voor online relatiebeheer en facturaties. Het maakt het beheren van klantgegevens en -interacties bijzonder eenvoudig. Het doorspitten van geprinte documenten, facturen, spreadsheets, e-mails en databases behoort vanaf nu tot het verleden: alles wat u nodig heeft wordt centraal opgeslagen en is toegankelijk vanaf elke locatie.</p>
                        <p>Naast relatiebeheer voorziet Imoby ook in functionaliteiten voor marketing, sales en klantenservice. Imoby Relatiebeheer draag zorg voor het op regelmatige basis versturen van geautomatiseerde mailings naar uw contacten. Daarnaast kunt u met de facturatiemodule zelf en eenvoudig uw verkoopfacturen opstellen.</p>
                        <div class="video-img">
                            <img src="<?= base_url() ?>assets/mobile/images/video-img2.jpg" alt="slide img" />
                        </div>                        
                    </div>
                </div>                
            </div>
        </section>
        <section class="img-gallery bg-white">
            <div class="row">
                <img src="<?= base_url() ?>assets/mobile/images/banner1.jpg" alt="slide img" />
                <img src="<?= base_url() ?>assets/mobile/images/banner2.jpg" alt="slide img" />
                <img src="<?= base_url() ?>assets/mobile/images/banner3.jpg" alt="slide img" />
            </div>
        </section>
        <section class="wit">
            <div class="container1">
                <div class="row">
                    <ul class="soical-icon">
                        <li class="l-3"><a href="#"><img src="<?= base_url() ?>assets/mobile/images/fa1.png" alt="#" /></a></li>
                        <li class="l-3"><a href="#"><img src="<?= base_url() ?>assets/mobile/images/twi1.png" alt="#" /></a></li>
                        <li class="l-3"><a href="#"><img src="<?= base_url() ?>assets/mobile/images/you1.png" alt="#" /></a></li>
                        <li class="l-3"><a href="#"><img src="<?= base_url() ?>assets/mobile/images/googl1.png" alt="#" /></a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="our-service bg-white">
            <div class="container1">
                <div class="row">
                    <div class="l-12">
                        <h2>Verhoog uw productiviteit met effectief relatiebeheer en marketing. Meer omzet in minder tijd!</h2>
                    </div>
                </div>               
            </div>
            <script type=text/javascript>
                jQuery(document).ready(function () {
                    function close_accordion_section() {
                        jQuery('.mobile-marketing .accordion-section-title').removeClass('active');
                        jQuery('.mobile-marketing .accordion-section-content').slideUp(300).removeClass('open');
                    }

                    jQuery('.accordion-section-title').click(function (e) {
                        // Grab current anchor value
                        var currentAttrValue = jQuery(this).attr('href');

                        if (jQuery(e.target).is('.active')) {
                            close_accordion_section();
                        } else {
                            close_accordion_section();

                            // Add active class to section title
                            jQuery(this).addClass('active');
                            // Open up the hidden content panel
                            jQuery('.mobile-marketing ' + currentAttrValue).slideDown(300).addClass('open');
                        }

                        e.preventDefault();
                    });
                });
            </script>
            <div class="main">
                <div class="mobile-marketing">
                    <div class="accordion-section">
                        <a class="accordion-section-title" href="#contact">RELATIEBEHEER</a>
                        <div id="contact" class="accordion-section-content">
                            <p>Imoby Relatiebeheer zorgt voor gestroomlijnde communicatie met uw relaties die u volledig kunt afstemmen op uw eigen manier van werken. Deals worden sneller gesloten doordat er één centrale plek is voor het opslaan en bijwerken van gegevens, het vastleggen van interacties en het volgen van de voortgang van leads.</p>
                            <p>Relatiebeheer is niet alleen bevorderlijk voor uw klanten maar ook voor uw werknemers en het eindresultaat van uw bedrijf. Met Imoby Relatiebeheer kunt u uitstekende dienstverlening bieden, hetzij telefonisch of via e-mail of website.</p>
                            <p>Daarnaast biedt u met Imoby Relatiebeheer al uw relaties een persoonlijke klantenpagina. Op deze persoonlijke relatiepagina kunnen uw klanten op een vertrouwde manier met u in contact komen, persoonlijke gegevens beheren, mailingopties aan en uit zetten en nuttige en praktische informatie vinden over hun eigen voertuig. </p>
                        </div>
                    </div>
                    <div class="accordion-section">
                        <a class="accordion-section-title" href="#billing">FACTURATIE</a>
                        <div id="billing" class="accordion-section-content">
                            <p>Facturen maken is een onvermijdelijk tijdrovend onderdeel van het ondernemen. Om dit probleem op te lossen bestaat Imoby Facturatie, speciaal ontwikkeld voor de autobranche. Bedrijven ervaren de overgang van Excel en/of Word naar een gespecialiseerd systeem als een flinke boost in hun professionaliteit.</p>
                            <p>Imoby Facturatie laat zich door zijn eenvoud naadloos integreert in uw bedrijfsvoering. ?Met de facturatiemodule kunt u via een eenvoudig invoerscherm facturen opstellen op basis van uw relatiebestand en bedrijfsvoorraad.</p>
                            <p>De lay-out van de factuur kan eenvoudig vormgegeven worden naar uw eigen huisstijl. Met Imoby Facturatie heeft u altijd de juiste voertuiggegevens en factuurnummer bij de hand. Daarnaast wordt altijd het juiste BTW-bedrag berekend en staat de boeking automatisch in uw boekhouding. Dus geen dubbel werk en altijd up-to-date.</p>
                        </div>
                    </div>
                    <div class="accordion-section">
                        <a class="accordion-section-title" href="#marketing">MARKETING</a>
                        <div id="marketing" class="accordion-section-content">
                            <p>Imoby Relatiebeheer is dé oplossing voor het automatisch creëren, verzenden en analyseren van e-mailmarketingcampagnes. Wilt u makkelijk en snel een nieuwsbrief maken, een APK-reminder versturen of een persoonlijke aanbodmail verzenden naar enkele relaties? Met Imoby Relatiebeheer wordt iedere klant op het juiste moment en op de meest effectieve manier persoonlijk benaderd.</p>
                            <p>Met de Mailing Wizard kunt u er ook voor kiezen om zelf gebruiksvriendelijke mailings te creëren. Alle leads, of ze nu via de website, e-mail of telefonisch zijn binnengekomen, kunnen worden vastgelegd in Imoby Relatiebeheer.</p>
                            <p> U kunt eenvoudig zien welke campagnes het meeste opleveren zodat duidelijk wordt welke marketingmiddelen het beste effect hebben en dus een volgende keer opnieuw ingezet kunnen worden.</p>
                        </div>
                    </div>
                    <div class="accordion-section">
                        <a class="accordion-section-title" href="#stock">BEDRIJFSVOORRAAD</a>
                        <div id="stock" class="accordion-section-content">   
                            <p>U wilt voldoen aan de vraag van uw klanten. Daarom is het van belang dat u realtime inzicht heeft in uw bedrijfsvoorraad en dat u uw verkochte voertuigen koppelt aan een relatie. Binnen Imoby Relatiebeheer bewaart u alle informatie op één centrale plek. Zo heeft niet alleen u, maar hebben ook uw collega's actueel inzicht in de huidige bedrijfsvoorraad en verkochte voertuigen.</p>
                            <p>Imoby houdt rekening met uw verkopen. Van ieder voertuig dat u heeft verkocht en dat niet gekoppeld is aan een relatie ontvangt u een melding via de mail. Hierdoor is uw administratie altijd up-to-date. U heeft geen last van tijdsverlies en de verkoop draait gewoon door.</p>
                            <p>U behaalt een hoge efficiency door integratie met andere Imoby-oplossingen: Imoby Web Apps, Imoby Facturatie, Imoby Persoonlijke Klantenpagina, Imoby Administratie en Imoby Relatiebeheer. En dat met maar één druk op de knop!</p>
                        </div>
                    </div>              
                </div>
            </div>            
        </section>
        <section class="contact-form">
            <div class="container1">
                <div class="row">
                    <div class="l-12">
                        <form>
                            <h2>Ervaar het zelf en neem contact met ons op</h2>
                            <p>Wilt u ook weten hoe u uw productiviteit kunt verhogen? Neem contact met ons op voor een vrijblijvende demonstratie.</p>
                            <p><input type="submit" name="contact" class="submit-bnt" value="neem contact op" /></p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer-bottom">
            <div class="container1">
                <h2><img src="<?= base_url() ?>assets/mobile/images/footer-logo2.png" alt="Footer Logo" /></h2>
                <div class="row">
                    <div class="l-12">
                        <p>
                            Copyright 2015. All rights reserved.<br />
                            Imoby B.V. Nieuwe Kade 16, 6827 AB Arnhem,<br /> 
                            Nederland. KvK: 54056152.
                        </p>
                    </div> 
                    <div class="rwo">
                        <ul>
                            <li class="l-4"><a href="#">DISCLAIMER</a></li>
                            <li class="l-4"><a href="#">PRIVACY</a></li>
                            <li class="l-4"><a href="#">VOORWAARDEN</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
