<?php
// PHP Classes
include_once "obj/Product.php";

// Insert product to DB
function insertProduct(Product $product, PDO $dbPDO)
{
  $table = "`4ws_products`";

  // Prepare categories to DB
  $categories = $product->Categories;
  if (!empty($categories))
  {
    $categories = implode(";", $product->Categories);
  }

  // SQL
	$sql = "INSERT INTO ". $table ." (name, description, price, categories_id) VALUES (:tempName, :tempDescription, :tempPrice, :tempCategories_id)";
	$sqlAction = $dbPDO->prepare($sql);
	$sqlAction->execute(
    array(
      ':tempName' => $product->Name,
      ':tempDescription' => $product->Description,
      ':tempPrice' => $product->Price,
      ':tempCategories_id' => $categories
    )
  );
}

// Update product in DB
function updateProduct(Product $product, PDO $dbPDO)
{
  $table = "`4ws_products`";

  // Prepare categories to DB
  $categories = $product->Categories;
  if (!empty($categories))
  {
    $categories = implode(";", $product->Categories);
  }

  // SQL
	$sql = "UPDATE ". $table ." SET name=:tempName, description=:tempDescription, price=:tempPrice, categories_id=:tempCategories_id WHERE id=:tempId";
	$sqlAction = $dbPDO->prepare($sql);
	$sqlAction->execute(
    array(
      ':tempName' => $product->Name,
      ':tempDescription' => $product->Description,
      ':tempPrice' => $product->Price,
      ':tempCategories_id' => $categories,
      ':tempId' => $product->ID
    )
  );
}

// Delete product from DB
function deleteProduct(int $productId, PDO $dbPDO)
{
  $table = "`4ws_products`";

  // SQL
	$sql = "DELETE FROM ". $table ." WHERE id=:tempId";
	$sqlAction = $dbPDO->prepare($sql);
	$sqlAction->execute(
    array(
      ':tempId' => $productId
    )
  );
}

// Returns categories
function getCategories(PDO $dbPDO)
{
  $table = "`4ws_categories`";

  // SQL
  $sql = "SELECT id, name FROM ". $table;
  $sqlAction = $dbPDO->prepare($sql);
  $sqlAction->execute();

  $result = $sqlAction->fetchAll();

  return $result;
}

// Returns array(Product)
function getProducts(PDO $dbPDO)
{
  $table = "`4ws_products`";

  // SQL
  $sql = "SELECT * FROM ". $table;
  $sqlAction = $dbPDO->prepare($sql);
  $sqlAction->execute();

  // SQL result to products array
  $result = $sqlAction->fetchAll();
  $products = array();
  foreach ($result as $key => $value)
  {
    $product = new Product(
      $value["name"],
      $value["description"],
      $value["price"],
      explode(";", $value["categories_id"]),
      $dbPDO
    );
    $product->ID = $value["id"];

    $products[] = $product;
  }

  return $products;
}

// Returns product by id
function getProduct(int $id, PDO $dbPDO)
{
  $table = "`4ws_products`";

  // SQL
  $sql = "SELECT * FROM ". $table ." WHERE id = :tempId";
  $sqlAction = $dbPDO->prepare($sql);
  $sqlAction->execute(array(':tempId' => $id));

  // SQL result to product
  $result = $sqlAction->fetchAll();
  foreach ($result as $key => $value)
  {
    $product = new Product(
      $value["name"],
      $value["description"],
      $value["price"],
      explode(";", $value["categories_id"]),
      $dbPDO
    );
    $product->ID = $value["id"];
  }

  return $product;
}

function renderProducts(PDO $dbPDO)
{
  $products = getProducts($dbPDO);
  $categories = getCategories($dbPDO);

  foreach ($products as $product)
  {
    // Product div
    echo '<div class="col-sm-3 product">';
    echo '<h2>'. $product->Name .'</h2>';
    echo '<p>Cena: <b>'. $product->Price .' Kč,-</b></p>';
    echo '<p class="productDescription">';
    echo    $product->Description;
    echo '</p>';
    echo '<a href="single.php?id='. $product->ID .'">detail</a>';
    echo '<div class="productCategories">';

    foreach ($categories as $category)
    {
      if(in_array($category['id'], $product->Categories))
      {
        echo '<p class="productCategoryTag">'. $category['name'] .'</p>';
      }
    }

    echo '</div>';
    echo '</div>';
  }
}

function renderSingleProduct(int $productId, PDO $dbPDO)
{
  $product = getProduct($productId, $dbPDO);
  $categories = getCategories($dbPDO);

  if(!empty($product))
  {
  // Product div
  echo '<div class="col-sm product">';
  echo '<h1>'. $product->Name .'</h1>';
  echo '<p>Cena: <b>'. $product->Price .' Kč,-</b></p>';
  echo '<p class="productDescription">';
  echo    $product->Description;
  echo '</p>';
  echo '<div class="productCategories">';
  foreach ($categories as $category)
  {
    if(in_array($category['id'], $product->Categories))
    {
      echo '<p class="productCategoryTag">'. $category['name'] .'</p>';
    }
  }
  echo '</div>';
  echo '</div>';
  }
  else 
  {
    echo '<h1>Produkt nenalezen</h1>';
  }
}

function categoryOptions(PDO $dbPDO)
{
  $categories = getCategories($dbPDO);

  foreach ($categories as $category)
  {
    echo '<option value="'. $category['id'] .'">'. $category['name'] .'</option>';
  }
}

function productsOptions(array $products)
{
  foreach ($products as $product)
  {
    echo '<option value="'. $product->ID .'">'. $product->Name .'</option>';
  }
}