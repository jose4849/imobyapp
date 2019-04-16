<?php

/*
 * Nick: Helper admin
 * Gebruikt om passwoord te generen en nieuwe gebruiker via mail op de hoogte te stellen.
 */

function maakpass($lengte, $cijfers = true, $hoofletters = true)
{
    //als hoofdletters true is, zetten we hoofdletters in de array, anders alleen kleine letters
    $karakters = ($hoofletters == true) ? array_merge(range('A','Z'), range('a', 'z')) : array_merge(range('a', 'z'));

    //als cijfers true is, zetten we cijfers bij de array (2x zodat er wat meer cijfers in komen), anders houden we de array zoals hij was
    $karakters = ($cijfers == true) ? array_merge($karakters, range(0, 9), range(0,9)) : $karakters;

    $pass = NULL; //maak een variabele aan voor de pass
    
    for($i = 0; $i < $lengte; $i++) //maak een loop die net zolang doorgaat tot het aantal karakters van de pass bereikt is
    {
        $pass .= $karakters[array_rand($karakters)]; //voeg een letter uit de array aan de pass toe
    }

    return $pass;
}

function inhoudEmailNieuw($voornaam, $achternaam, $bedrijfsnaam, $email, $pass, $siteCode){
    return
        'Geachte ' .  $voornaam . ' ' . $achternaam . ',<br/><br/>' .
        
        'Als gebruiker van VWE Advertentiemanager beschikt u automatisch over een eigen GRATIS mobiele website voor ' . $bedrijfsnaam . '. ' .
        'Deze mobiele website wordt technisch ondersteund door Imoby. Alle door u geadverteerde auto\'s worden automatisch doorgeplaatst naar deze omgeving
        en indien u wenst ook naar Facebook, Twitter en Youtube. <br/><br/>' .
        
        'Door het selecteren van de QR-code in Advertentiemanager wordt deze ook geplaatst bij al uw advertenties en komt er een breed scala van aanvullende advertentie mogelijkheden beschikbaar.<br/><br/>' .
        
        'Beheren van uw accountgegevens, advertenties, koppelingen maken met sociale media en volgen van statistieken verloopt via <a href=\"http://imoby.nl\">www.imoby.nl</a>. <br/><br/>' .
        
        'U kunt met de onderstaande gegevens inloggen: <br/>' .
        'Gebruikersnaam: ' .  $email . '<br/>' . 
        'Wachtwoord: ' . $pass . '<br/><br/>' .
        
        'Door <a href=\"http://app.imoby.nl/mobile/home/'.$siteCode.'\">hier</a> te klikken krijgt u alvast een preview van uw eigen mobiele website: '.        
        
        'Hebt u op dit moment zelf nog geen auto\'s geadverteerd? Bekijk dan de <a href=\"http://imoby.nl/2072723\">demopagina</a> van Imoby om een goede indruk te krijgen van de functionaliteiten!<br/><br>' .
        
        'De meest voorkomende vragen over het gebruik van de QR-codes en de mobiele website vindt u in de <a href=\"http://www.vwe.nl/upload/file/PDF/Handleidingen/imoby_handleiding-mobiele-website.pdf\">handleiding Imoby en QR-code van VWE</a>.<br/><br/>' .
        
        'Met vriendelijke groet, <br/><br/>' .
        
        'VWE & Imoby';
}

function mailNieuw($email, $pass)
{
    $subject = "Welkom bij Imoby";
    $message = "Hallo vanaf nu kunt u de diensten van imoby gaan gebruiken! \n U kunt inloggen via www.imoby.nl met gebruikersnaam: $email en wachtwoord: $pass \n Met vriendelijk groet Imoby BV";
    $from = "info@imoby.nl";
    $headers = "From:" . $from;
    mail($email,$subject,$message,$headers);
}

function inhoudEmailWeg($voornaam, $achternaam)
{   
    return
    'Geachte ' .  $voornaam . ' ' . $achternaam . ',<br/><br/>' .

    'Wij hebben vernomen dat u geen gebruikt meer maakt van VWE Advertentiemanager. Om deze reden komt ook automatisch de door Imoby voor u gerealiseerde mobiele website per direct te vervallen. <br/><br/>' .

    'Eventueel nog bij u in gebruik zijnde QR-codes op showroomkaarten, advertenties en dergelijke worden door Imoby per vandaag niet meer ondersteund en zullen ook geen toegang geven tot uw mobiele website of de desbetreffende advertentie. <br/><br/>' .

    'Wij hopen u in de toekomst weer als gebruiker te mogen verwelkomen. <br/><br/>' .

    'Met vriendelijke groet, <br/><br/>' .

    'VWE & Imoby';
}

