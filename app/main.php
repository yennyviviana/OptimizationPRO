<?php

date_default_timezone_set("America/Bogota");
require_once('Views/dashboard.php');



$dato = isset($_GET['da']) ? $_GET['da'] : null;

     switch($dato){

        //case of Orders
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

                       
        
                        
                        
         //case of Suppliers
         case 1:
            require_once('Views/Suppliers/create.php');
            break;


            case 2:
                require_once('Views/Suppliers/insert.php');
                break;
    

                case 3:
                    require_once('Views/Suppliers/edit.php');
                    break;


                    case 4:
                        require_once('Views/Suppliers/delete.php');
                        break;

                       
                    
                        
  //case of Shopping
  case 1:
    require_once('Views/Shopping/create.php');
    break;


    case 2:
        require_once('Views/Shopping/insert.php');
        break;


        case 3:
            require_once('Views/Shopping/edit.php');
            break;


            case 4:
                require_once('Views/Shopping/delete.php');
                break;

               

                //case of Customers
  case 1:
    require_once('Views/Customers/create.php');
    break;


    case 2:
        require_once('Views/Customers/insert.php');
        break;


        case 3:
            require_once('Views/Customers/edit.php');
            break;


            case 4:
                require_once('Views/Customers/delete.php');
                break;

               

                
 //case of Empleados....
 case 1:
    require_once('Views/Employees/create.php');
    break;


    case 2:
        require_once('Views/Employees/insert.php');
        break;


        case 3:
            require_once('Views/Employees/edit.php');
            break;


            case 4:
                require_once('Views/Employees/delete.php');
                break;

               

                  
 //case of Products
 case 1:
    require_once('Views/Products/create.php');
    break;


    case 2:
        require_once('Views/Products/insert.php');
        break;


        case 3:
            require_once('Views/Products/edit.php');
            break;


            case 4:
                require_once('Views/Products/delete.php');
                break;

               

              


                //case of Financials
 case 1:
    require_once('Views/Financials/create.php');
    break;


    case 2:
        require_once('Views/Financials/insert.php');
        break;


        case 3:
            require_once('Views/Financials/edit.php');
            break;


            case 4:
                require_once('Views/Financials/delete.php');
                break;




                //case of Inventorys
                case 1:
                    require_once('Views/Inventorys/create.php');
                    break;
                
                
                    case 2:
                        require_once('Views/Inventorys/insert.php');
                        break;
                
                
                        case 3:
                            require_once('Views/Inventorys/edit.php');
                            break;
                
                
                            case 4:
                                require_once('Views/Inventorys/delete.php');
                                break;
                

 //case of Proyects
 case 1:
    require_once('Views/Proyects/create.php');
    break;


    case 2:
        require_once('Views/Proyects/insert.php');
        break;


        case 3:
            require_once('Views/Proyects/edit.php');
            break;


            case 4:
                require_once('Views/Proyects/delete.php');
                break;

            }

    