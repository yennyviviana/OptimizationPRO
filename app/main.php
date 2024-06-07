<?php

date_default_timezone_set("America/Bogota");
require_once('Views/dashboard.php');



$dato = isset($_GET['da']) ? $_GET['da'] : null;

     switch($dato){

        //case of ERP
        case 1:
            require_once('Views/Orders/create.php');
            break;


            case 2:
                require_once('Views/Orders/insert.php');
                break;
    

                case 3:
                    require_once('Views/Orders/edit.php');
                    break;


                    case 4:
                        require_once('Views/Orders/delete.php');
                        break;

                       
        
                        }
                    
                            
    ?>