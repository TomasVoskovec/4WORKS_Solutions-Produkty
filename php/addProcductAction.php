<?php
session_start();

// PHP classes
include_once 'obj/Product.php';

// PHP files
include 'functions.php';
include 'db.php';

// Product variables
$productName = $_POST['productName'];
$productDescription = $_POST['productDescription'];
$productPrice = $_POST['productPrice'];

// settype bug fixed ("" = 1)
if (!empty($productPrice))
{
  settype($productPrice, "float");
}
else
{
  $productPrice = 0.0;
}

// Set null if categories are emty
if(isset($_POST['productCategory']))
{
  $productCategory = $_POST['productCategory'];
}
else
{
  $productCategory = null;
}

// Validate product data
try
{
  new Product($productName, $productDescription, $productPrice, $productCategory, $db);
}
catch (Exception $e)
{
  $error = $e->getMessage();
}
catch (TypeError $te)
{
  $error = "Hodnoty vstupů nejsou validní";
}

// Create new product object or create error session
if (!isset($error))
{
  $product = new Product($productName, $productDescription, $productPrice, $productCategory, $db);
  unset($_SESSION);
  $_SESSION['msg'] = "Nový produkt byl přidán";

  // Save product to DB
  insertProduct($product, $db);
}
else
{
  $_SESSION['error'] = $error;

  $_SESSION['productName'] = $productName;
  $_SESSION['productDescription'] = $productDescription;
  $_SESSION['productPrice'] = $productPrice;
}

header("Location: ../addProduct.php");