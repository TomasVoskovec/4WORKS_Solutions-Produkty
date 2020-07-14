<?php
session_start();

// PHP classes
include_once 'obj/Product.php';

// PHP files
include 'functions.php';
include 'db.php';

// Product variables
$productID = $_POST['productId'];
$productName = $_POST['productName'];
$productDescription = $_POST['productDescription'];
$productPrice = $_POST['productPrice'];

// Delete product
if(!empty($_POST['delete']))
{
  deleteProduct($productID, $db);
  header("Location: ../index.php");
}

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
  $product->ID = $productID;
  unset($_SESSION);
  $_SESSION['msg'] = "Nový produkt byl přidán";

  // Save product to DB
  updateProduct($product, $db);
}
else
{
  $_SESSION['error'] = $error;
}

header("Location: ../editProduct.php?id=". $product->ID);