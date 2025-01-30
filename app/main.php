<?php

date_default_timezone_set("America/Bogota");
require_once('Views/dashboard.php');

$dato = isset($_GET['da']) ? $_GET['da'] : null;

switch ($dato) {
    // Case of Orders......
    case 'Orders-1':
        require_once('Views/Orders/create.php');
        break;
    case 'Orders-2':
        require_once('Views/Orders/insert.php');
        break;
    case 'Orders-3':
        require_once('Views/Orders/edit.php');
        break;
    case 'Orders-4':
        require_once('Views/Orders/delete.php');
        break;
    case 'Orders-5':
        require_once('Views/Orders/search.php');
        break;


    // Case of Products......
    case 'Products-1':
        require_once('Views/Products/create.php');
        break;
    case 'Products-2':
        require_once('Views/Products/insert.php');
        break;
    case 'Products-3':
        require_once('Views/Products/edit.php');
        break;
    case 'Products-4':
        require_once('Views/Products/delete.php');
        break;
    case 'Products-5':
        require_once('Views/Products/search.php');
        break;



    // Case of Suppliers
    case 'Suppliers-1':
        require_once('Views/Suppliers/create.php');
        break;
    case 'Suppliers-2':
        require_once('Views/Suppliers/insert.php');
        break;
    case 'Suppliers-3':
        require_once('Views/Suppliers/edit.php');
        break;
    case 'Suppliers-4':
        require_once('Views/Suppliers/delete.php');
        break;

    // Case of Shopping
    case 'Shopping-1':
        require_once('Views/Shopping/create.php');
        break;
    case 'Shopping-2':
        require_once('Views/Shopping/insert.php');
        break;
    case 'Shopping-3':
        require_once('Views/Shopping/edit.php');
        break;
    case 'Shopping-4':
        require_once('Views/Shopping/delete.php');
        break;

    // Case of Customers
    case 'Customers-1':
        require_once('Views/Customers/create.php');
        break;
    case 'Customers-2':
        require_once('Views/Customers/insert.php');
        break;
    case 'Customers-3':
        require_once('Views/Customers/edit.php');
        break;
    case 'Customers-4':
        require_once('Views/Customers/delete.php');
        break;

    // Repeat for other categories...
    // Case of Employees
    case 'Employees-1':
        require_once('Views/Employees/create.php');
        break;
    case 'Employees-2':
        require_once('Views/Employees/insert.php');
        break;
    case 'Employees-3':
        require_once('Views/Employees/edit.php');
        break;
    case 'Employees-4':
        require_once('Views/Employees/delete.php');
        break;


        // Repeat for other categories...
    // Case of  Financials
    case 'Financials-1':
        require_once('Views/Financials/create.php');
        break;
    case 'Financials-2':
        require_once('Views/Financials/insert.php');
        break;
    case 'Financials-3':
        require_once('Views/Financials/edit.php');
        break;
    case 'Financials-4':
        require_once('Views/Financials/delete.php');
        break;

        // case of Inventorys
        case 'Inventorys-1':
            require_once('Views/Inventorys/create.php');
            break;
        case 'Inventorys-2':
            require_once('Views/Inventorys/insert.php');
            break;
        case 'Inventorys-3':
            require_once('Views/Inventorys/edit.php');
            break;
        case 'Inventorys-4':
            require_once('Views/Inventorys/delete.php');
            break;


             // case of Proyects
        case 'Proyects-1':
            require_once('Views/Proyects/create.php');
            break;
        case 'Proyects-2':
            require_once('Views/Proyects/insert.php');
            break;
        case 'Proyects-3':
            require_once('Views/Proyects/edit.php');
            break;
        case 'Proyects-4':
            require_once('Views/Proyects/delete.php');
            break;

            
}

?>
