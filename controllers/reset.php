<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reset extends CI_Controller {
    function index(){
        echo "Hello world";
    }
    function admin(){
        
        $this->db->trans_start();
        /* user insert start */
        $password='$2y$08$HhUI9wF7uOwsiPc8sPq./OajPV7294rT5xIkuc3YRBuqApmdd9.Ma';
        $query="
        INSERT INTO `users` (`id`, `ip_address`, `email`, `password`, `salt`, `salutation`, `firstName`, `middleName`, `lastName`, `organization`, `function`, `phoneNumber1`, `phoneNumber2`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `username`, `imobycode`, `klantnummer`) VALUES
        (null, '127.0.0.1', 'admin@example.com', '".$password."', NULL, 'De Heer', 'MD.', 'Shamim', 'Hassan', 'Bengal Solution Ltd', 'Software Engineer', '0132456798', '0123132132', NULL, 'gC8eKE9F-zO0jw2Oyknlx.520f269eec66fb2526', 1404642745, 'uEP/.QZtR46wJGE0hCVgwe', '0000-00-00 00:00:00', 1432028111, 1,'admin@example.com','1234567', '1234567');   
        ";
        $this->db->query($query); 
        $user_id=$this->db->insert_id();
        /* user insert end */
        /* address insert start */
        $query="INSERT INTO `addresses` (`id`, `type`, `street`, `house_num`, `house_num_addition`, `postal_code`, `city`, `country`) VALUES
                (null, 'visit', 'Road# 30, House# 430, Mahakhali DOHS', '430', 'A', '1206', 'Dhaka', 'Bangladesh');";
        $this->db->query($query); 
        $address_id=$this->db->insert_id();
        /* address insert end */
        /* user2address */
        $query="INSERT INTO `users2addresses` (`user`, `address`) VALUES ('".$user_id."', '".$address_id."');";
        $this->db->query($query);
        /* user2address */  
        /* user2group start need dubble access level*/
        $group = 1; /* superadmin = 1, admin= 2, dealer = 3, user =4 */ 
        $this->db->query("INSERT INTO `users2groups` (`user`, `group`) VALUES ($user_id, $group);");
        $group = 2; /* superadmin = 1, admin= 2, dealer = 3, user =4 */ 
        $this->db->query("INSERT INTO `users2groups` (`user`, `group`) VALUES ($user_id, $group);");
        /* user2group end */
         $this->db->trans_complete();
               
    }

    function dealer(){
        
        $this->db->trans_start();
        /* user insert start */
        $password='$2y$08$HhUI9wF7uOwsiPc8sPq./OajPV7294rT5xIkuc3YRBuqApmdd9.Ma';
        $query="
        INSERT INTO `users` (`id`, `ip_address`, `email`, `password`, `salt`, `salutation`, `firstName`, `middleName`, `lastName`, `organization`, `function`, `phoneNumber1`, `phoneNumber2`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `username`, `imobycode`, `klantnummer`) VALUES
        (null, '127.0.0.1', 'dealer@example.com', '".$password."', NULL, 'De Heer', 'MD.', 'Dealer', 'Hassan', 'Dealer Solution Ltd', 'Dealer Engineer', '0132456798', '0123132132', NULL, 'gC8eKE9F-zO0jw2Oyknlx.520f269eec66fb2526', 1404642745, 'uEP/.QZtR46wJGE0hCVgwe', '0000-00-00 00:00:00', 1432028111, 1,'dealer@example.com','1234567', '1234567');   
        ";
        $this->db->query($query); 
        $user_id=$this->db->insert_id();
        /* user insert end */
        /* address insert start */
        $query="INSERT INTO `addresses` (`id`, `type`, `street`, `house_num`, `house_num_addition`, `postal_code`, `city`, `country`) VALUES
                (null, 'visit', 'Road# 30, House# 430, Mahakhali DOHS', '430', 'A', '1206', 'Dhaka', 'Bangladesh');";
        $this->db->query($query); 
        $address_id=$this->db->insert_id();
        /* address insert end */
        /* user2address */
        $query="INSERT INTO `users2addresses` (`user`, `address`) VALUES ('".$user_id."', '".$address_id."');";
        $this->db->query($query);
        /* user2address */  
        /* user2group start */
        $group = 3; /* superadmin = 1, admin= 2, dealer = 3, user =4 */ 
        $this->db->query("INSERT INTO `users2groups` (`user`, `group`) VALUES ($user_id, $group);");
       
        /* user2group end */
         $this->db->trans_complete();
               
    }    
    
    
    
    
    function group(){
        $query="
        INSERT INTO `groups` (`id`, `name`, `description`) VALUES
        (1, 'superadmin', 'Super Administrator'),
        (2, 'admin', 'Administrator'),
        (3, 'dealer', 'Dealer'),
        (4, 'user', 'User');
        ";
        $this->db->query($query);
    }

    
    function dealerfunction(){
        $query="
        INSERT INTO `dealerfunctions` (`id`, `name`, `description`, `price`) VALUES
        (1, 'mobile', 'Mobile application', '2995'),
        (2, 'relationship', 'Relationship management', '8995'),
        (3, 'invoicing', 'Invoicing', '995'),
        (4, 'dms', 'DMS Link', '1995');
        ";
        $this->db->query($query);
    }
    
    function cartableemplty(){
      /*      
    $this->db->query("

TRUNCATE `cars_licenseinfo`;
TRUNCATE `car_ads`;
TRUNCATE `car_docs`;
TRUNCATE `car_info`;
TRUNCATE `car_maintenance`;

TRUNCATE `car_media`;
TRUNCATE `car_notes`;

TRUNCATE `cars2specsdefault`;
TRUNCATE `cars2specsfabric`;
TRUNCATE `cars`;

    ");  */
        
        echo $this->db->truncate('cars_licenseinfo');
        echo $this->db->truncate('car_ads');
        echo $this->db->truncate('car_docs');
        echo $this->db->truncate('car_info');
        echo $this->db->truncate('car_maintenance');
        echo $this->db->truncate('car_media');
        echo $this->db->truncate('cars2specsdefault');
        echo $this->db->truncate('cars2specsfabric');
       //echo $this->db->truncate('cars');
        $this->db->empty_table('cars');
        
    }
    function dummy(){
        $this->cartableemplty();
        $this->singlecar(1);
        $this->singlecar(2);
        $this->singlecar(3);
        $this->singlecar(4);
    }
    
    function emptycar(){
        $this->db->empty_table('cars');
        $this->db->empty_table('car_ads');
        $this->db->empty_table('cars_licenseinfo');
        $this->db->empty_table('cars2specsdefault');
        $this->db->empty_table('car_info');
        $this->db->empty_table('cars2specsfabric');
        $this->db->empty_table('car_media');
    }
    
    function singlecar($id){
        
        
       // $this->cartableemplty();
        //$car_id=1;
        $car_id=$id;
      
        
        $this->db->query("INSERT INTO `cars`
        (`id`, `source`, `sourceId`, `user`, `dealer`) VALUES 
        ('$car_id', 'vwe', '200001', '6', '100')
         ");
        
        $this->db->query("
            INSERT INTO `car_ads` (`car`, `adNumber`, `dateStart`, `dateEnd`, `active`) 
            VALUES ($car_id, '123$car_id', '2015-07-01', '2015-07-23', '1');
        ");
       
        $this->db->query("INSERT INTO `cars_licenseinfo` (`car`, `licenseNumber`, `brand`, `model`, `type`, `buildYear`, `APKdate`, `KMvalue`, `marge`, `lastUpdate`) VALUES
        ($car_id , '79HXVB', '$car_id.Renault', 'BNR', '1.6-16V Expression Sport', 2002, '2015-08-19 00:00:00', 241202, 1, '2015-06-29 12:23:18')    
        ");
        
        $this->db->query("
        INSERT INTO `car_info` (`car`, `type`, `attribute`, `valueText`, `valueFloat`, `valueDateTime`) VALUES
        ($car_id, 'technische-info', 'kleur', 'zwart', NULL, NULL),
        ($car_id, 'technische-info', 'vrije_tekst', 'vrije tekst will be here', NULL, NULL),
        ($car_id, 'technische-info', 'showroompris', '102', NULL, NULL),
        ($car_id, 'technische-info', 'koetswerk', 'Hatchback', NULL, NULL),
        ($car_id, 'technische-info', 'versnelling', '1000KM/H', NULL, NULL),
        ($car_id, 'technische-info', 'kleur', 'Blue', NULL, NULL),
        ($car_id, 'technische-info', 'massa-ledig-gewicht', '500', NULL, NULL),
        ($car_id, 'technische-info', 'brandstof', 'Euro 95', NULL, NULL)
        ");
        
        $this->db->query("INSERT INTO `cars2specsdefault` (`car`, `specDefault`) VALUES ($car_id, 1) ");
        
        $this->db->query("
        INSERT INTO `cars2specsfabric` (`car2spece_id`, `car`, `specFabric`) VALUES
        (null, $car_id , 1084),      
        (null, $car_id , 1085)      
        ");
        $img="'http://imobyupdate.projectflick.com//fileserver/bofiles/crm_files/100/autos/95.jpg'";
        $this->db->query("
        INSERT INTO `car_media` ( `car`, `order`, `toDelete`, `remoteFile`, `localFile`) VALUES
        ($car_id, 1, NULL,$img,$img),
        ($car_id, 1, NULL,$img,$img),
        ($car_id, 1, NULL,$img,$img),
        ($car_id, 1, NULL,$img,$img),
        ($car_id, 1, NULL,$img,$img)
        ");
        
        
        
       
    }
    

    /* function work start here */

    function wk_in(){
        $resutlSet=$this->db->query("select * from todo where id = 1");
        $result=$resutlSet->result();
        echo $result[0]->data;
        
    }
    function wk_out(){
     
        
        $data1=$_POST['data']; 
        $data1=json_decode($data1);
       
        
      $query = "update todo set data = '".$data1."' where id = 1";

      //$this->db->where('id',1);
      $this->db->query($query); 
      echo 'Task add successfully in task list'; 
         
    }


    /* function work end here */
    
    
    
}
