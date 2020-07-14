<?php

class Product
{
  // Public class vars
  public $ID;
  public $Name;
  public $Description;
  public $Price;
  public $Categories;

  // Constructor
  function __construct(string $name, string $description, float $price, array $categories, PDO $dbPDO)
  {
    // Delete HTML tags from constructor vars
    strip_tags($name);
    strip_tags($description);
    
    if (!empty($categories))
    {
      // Get categories ID from DB
      $table = "`4ws_categories`";

      $sql = "SELECT id FROM ". $table;
      $sqlAction = $dbPDO->prepare($sql);
      $sqlAction->execute();

      $result = $sqlAction->fetchAll();
      $categories_id = array();

      foreach ($result as $key => $value)
      {
        $categories_id[] = $value["id"];
      }

      // Categories control
      foreach ($categories as $category)
      {
        if(!in_array($category, $categories_id))
        {
          throw new Exception('Kategorie nebyla nalezena');
        }
      }
      $this->Categories = $categories;
    }

    // Name input control
    if (!empty($name))
    {
      if (strlen($name) <= 100)
      {
        $this->Name = $name;
      }
      else 
      {
        throw new Exception('Název produktu je příliš dlouhý');
      }
    }
    else 
    {
      throw new Exception('Název produktu není vyplněn');
    }

    // Descrition input control
    if (!empty($description))
    {
      if (strlen($description) <= 5000) 
      {
        $this->Description = $description;
      }
      else 
      {
        throw new Exception('Název produktu je příliš dlouhý');
      }
    }
    else 
    {
      throw new Exception('Popis produktu není vyplněn');
    }

    // Price input control
    if (!empty($price))
    {
      if (strlen($price) <= 11) 
      {
        if ($price > 0)
        {
          $this->Price = $price;
        }
        else
        {
          throw new Exception('Cena produktu je příliš malá');
        }
      }
      else
      {
        throw new Exception('Cena produktu je příliš velká');
      }
    }
    else 
    {
      throw new Exception('Cena produktu není vyplněna');
    }
  }
}