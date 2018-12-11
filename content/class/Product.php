<?php
	require_once 'Database.php';

	class Product extends Database
	{
		protected static $table = "product";

		public function save_product($product_barcode, $product_name, $product_description, $manufacturer_id, $category_id)	{
			$query = "INSERT INTO ".static::$table." (`product_name`, `product_description`, `product_barcode`, `manufacturer_id`, `category_id`) VALUES ('$product_name', '$product_description', '$product_barcode', '$manufacturer_id', '$category_id')";
			return parent::query($query);			
		}	

		public function count_all_product() {
			// $query = "SELECT stock_id, COUNT(*) FROM `stocks` GROUP BY stock_id";
			$query = "SELECT COUNT(*) AS 'Total' FROM ".static::$table." WHERE is_deleted = FALSE";
			return parent::select($query);
		}

		public function get_all_product() {
			$query = "SELECT * FROM ".static::$table." WHERE is_deleted = FALSE";
			return parent::select($query);
		}

		public function get_product($product_id) {
			$query = "SELECT * FROM ".static::$table." WHERE product_id = '$product_id'";
			$result = parent::select($query);
			if(count($result)===0){
				return NULL;
			}
			return $result[0];
		}

		public function get_product_by_barcode($product_barcode) {
			// $query = "SELECT * FROM ".static::$table." WHERE product_barcode = '{$product_barcode}' AND is_deleted = FALSE";
			$query = "SELECT * FROM product INNER JOIN stocks ON product.product_id = stocks.product_id WHERE product.product_barcode = '{$product_barcode}' AND product.is_deleted = FALSE"; 
			$result = parent::select($query);
			if(count($result)===0){
				return NULL;
			}
			return $result[0];
		}

		public function barcode_exist($product_barcode) {
			$query = "SELECT * FROM ".static::$table." WHERE product_barcode = '{$product_barcode}' AND is_deleted = FALSE";
			return parent::select($query)[0];
		}

		public function get_barcode($product_barcode) {
			$query = "
				SELECT *, 
				       stocks.product_quantity, 
				       stocks.location, 
				       stocks.cost_price, 
				       supplier.supplier_name, 
				       stocks.product_expiration 
				FROM   product 
				       INNER JOIN stocks 
				               ON stocks.product_id = product.product_id 
				       INNER JOIN supplier 
				               ON stocks.supplier_id = supplier.supplier_id 
				WHERE  product.product_barcode = '{$product_barcode}'
				       AND stocks.is_deleted = false 
			";
			$result = parent::select($query);
			if(count($result)===0){
				return NULL;
			}
			return $result[0];			
		}

		public function remove_product($product_id) {
			$query = "UPDATE ".static::$table." SET `is_deleted` = TRUE WHERE product_id = '$product_id'";
			return parent::query($query);
		}

		public function product_search_by_product_id($item_to_search) {
			$query = "
				SELECT product_id                     AS id, 
				       product_name                   AS name, 
				       product_description            AS description, 
				       product_barcode                AS barcode, 
				       manufacturer.manufacturer_name AS manufacturer_full_name, 
				       category.category_name         AS category_full_name, 
				       selling_price                  AS sell_price 
				FROM   ".static::$table." 
				       INNER JOIN `manufacturer` 
				               ON product.manufacturer_id = manufacturer.manufacturer_id 
				       INNER JOIN `category` 
				               ON product.category_id = category.category_id 
				WHERE  `product_id` LIKE '%$item_to_search%' 
				       AND product.`is_deleted` = false 
				ORDER  BY product.product_id DESC 
			";
			return parent::select($query);
		}

		public function product_search_by_barcode($item_to_search) {
			$query = "
				SELECT product_id                     AS id, 
				       product_name                   AS name, 
				       product_description            AS description, 
				       product_barcode                AS barcode, 
				       manufacturer.manufacturer_name AS manufacturer_full_name, 
				       category.category_name         AS category_full_name, 
				       selling_price                  AS sell_price 
				FROM   ".static::$table." 
				       INNER JOIN `manufacturer` 
				               ON product.manufacturer_id = manufacturer.manufacturer_id 
				       INNER JOIN `category` 
				               ON product.category_id = category.category_id 
				WHERE  `product_barcode` LIKE '%$item_to_search%' 
				       AND product.is_deleted = false 
				ORDER  BY product_id DESC 
			";
			return parent::select($query);
		}

		public function product_search_by_name($item_to_search) {
			$query = "
				SELECT product_id                     AS id, 
				       product_name                   AS name, 
				       product_description            AS description, 
				       product_barcode                AS barcode, 
				       manufacturer.manufacturer_name AS manufacturer_full_name, 
				       category.category_name         AS category_full_name, 
				       selling_price                  AS sell_price 
				FROM   ".static::$table." 
				       INNER JOIN `manufacturer` 
				               ON product.manufacturer_id = manufacturer.manufacturer_id 
				       INNER JOIN `category` 
				               ON product.category_id = category.category_id 
				WHERE  `product_name` LIKE '%$item_to_search%' 
				       AND ".static::$table.".is_deleted = false 
				ORDER  BY product_name DESC 
			";
			return parent::select($query);
		}

		public function product_search_by_description($item_to_search) {
			$query = "
				SELECT product_id                     AS id, 
				       product_name                   AS name, 
				       product_description            AS description, 
				       product_barcode                AS barcode, 
				       manufacturer.manufacturer_name AS manufacturer_full_name, 
				       category.category_name         AS category_full_name, 
				       selling_price                  AS sell_price 
				FROM   ".static::$table." 
				       INNER JOIN `manufacturer` 
				               ON product.manufacturer_id = manufacturer.manufacturer_id 
				       INNER JOIN `category` 
				               ON product.category_id = category.category_id 
				WHERE  `product_description` LIKE '%$item_to_search%' 
				       AND ".static::$table.".is_deleted = false 
				ORDER  BY product.product_id DESC 
			";
			return parent::select($query);
		}

		public function product_search_by_manufacturer($item_to_search) {
			$query = "
				SELECT product_id                     AS id, 
				       product_name                   AS name, 
				       product_description            AS description, 
				       product_barcode                AS barcode, 
				       manufacturer.manufacturer_name AS manufacturer_full_name, 
				       category.category_name         AS category_full_name, 
				       selling_price                  AS sell_price 
				FROM   ".static::$table." 
				       INNER JOIN `manufacturer` 
				               ON product.manufacturer_id = manufacturer.manufacturer_id 
				       INNER JOIN `category` 
				               ON product.category_id = category.category_id 
				WHERE  manufacturer.`manufacturer_name` LIKE '%$item_to_search%' 
				       AND ".static::$table.".is_deleted = false 
				ORDER  BY manufacturer.manufacturer_name DESC 
			";
			return parent::select($query);
		}

		public function product_search_by_category($item_to_search) {
			$query = "
				SELECT product_id                     AS id, 
				       product_name                   AS name, 
				       product_description            AS description, 
				       product_barcode                AS barcode, 
				       manufacturer.manufacturer_name AS manufacturer_full_name, 
				       category.category_name         AS category_full_name, 
				       selling_price                  AS sell_price 
				FROM   ".static::$table." 
				       INNER JOIN `manufacturer` 
				               ON product.manufacturer_id = manufacturer.manufacturer_id 
				       INNER JOIN `category` 
				               ON product.category_id = category.category_id 
				WHERE  category.`category_name` LIKE '%$item_to_search%' 
				       AND ".static::$table.".is_deleted = false 
				ORDER  BY category.category_id DESC 
			";
			return parent::select($query);
		}

		public function product_search_by_selling_price($item_to_search) {
			$query = "
				SELECT product_id                     AS id, 
				       product_name                   AS name, 
				       product_description            AS description, 
				       product_barcode                AS barcode, 
				       manufacturer.manufacturer_name AS manufacturer_full_name, 
				       category.category_name         AS category_full_name, 
				       selling_price                  AS sell_price 
				FROM   ".static::$table." 
				       INNER JOIN `manufacturer` 
				               ON product.manufacturer_id = manufacturer.manufacturer_id 
				       INNER JOIN `category` 
				               ON product.category_id = category.category_id 
				WHERE  `selling_price` LIKE '%$item_to_search%' 
				       AND ".static::$table.".is_deleted = false 
				ORDER  BY selling_price DESC 
			";
			return parent::select($query);
		}

	}
?>