<?php
	require_once 'Database.php';

	class Stocks extends Database
	{
		protected static $table = "stocks";

		public function update_item($stock_id, $item_number, $product_id, $item_name, $item_description, $item_quantity, $cost_price, $selling_price, $supplier, $category, $size, $manufacturer, $item_expiration, $location, $taxed) {
			$query = "
				UPDATE ".static::$table." 
				SET    `item_number` = '$item_number', 
				       `product_id` = '$product_id', 
				       `item_name` = '$item_name', 
				       `item_description` = 'item_description', 
				       `item_quantity` = '$item_quantity', 
				       `cost_price` = '$cost_price', 
				       `selling_price` = '$selling_price', 
				       `supplier` = '$supplier', 
				       `category` = '$category', 
				       `size` = '$size', 
				       `manufacturer` = '$manufacturer', 
				       `item_expiration` = '$item_expiration', 
				       `location` = '$location', 
				       `taxed` = '$taxed' 
				WHERE  `stock_id` = '$stock_id' 
			";
			return parent::query($query);
		}

		public function add_item($item_number, $product_id, $name, $description, $quantity, $cost_price, $selling_price, $supplier, $category, $size, $manufacturer, $expiration, $location, $taxed) {
			$query = "
				INSERT INTO ".static::$table." 
				            ( ` item_number ` , 
				             ` product_id ` , 
				             ` item_name ` , 
				             ` item_description ` , 
				             ` item_quantity ` , 
				             ` cost_price ` , 
				             ` selling_price ` , 
				             ` supplier ` , 
				             ` category ` , 
				             ` size ` , 
				             ` manufacturer ` , 
				             ` item_expiration ` , 
				             ` location ` , 
				             ` taxed ` ) 
				VALUES      ('$item_number', 
				             '$product_id', 
				             '$name', 
				             '$description', 
				             '$quantity', 
				             '$cost_price', 
				             '$selling_price', 
				             '$supplier', 
				             '$category', 
				             '$size', 
				             '$manufacturer', 
				             '$expiration', 
				             '$location', 
				             '$taxed') 
			";
			return parent::query($query);
		}

		public function get_all_items() {
			$query = "
				SELECT *
				FROM  ".static::$table." 
				WHERE `is_deleted` = FALSE
			";
			return parent::select($query);
		}

		public function get_stock($stock_id) {
			$query = "
				SELECT *
				FROM  ".static::$table." 
				WHERE stock_id = '$stock_id'
			";
			$result = parent::select($query);
			if (count($result)===0) {
				return null;
			}
			return $result[0];
		}

		public function get_product($product_id) {
			$query = "
				SELECT *
				FROM ".static::$table."
				WHERE product_id = '$product_id'
			";
			return parent::select($query);
		}

		public function option_category() {
			$query = "
				SELECT *
				FROM `category`";
			return parent::select($query);
		}

		public function count_all_items() {
			// $query = "SELECT stock_id, COUNT(*) FROM `stocks` GROUP BY stock_id";
			$query = "SELECT COUNT(*) AS 'Total' FROM ".static::$table." WHERE is_deleted = FALSE";
			return parent::select($query);
		}

		public function remove_item($stock_id) {
			$query = "UPDATE ".static::$table." SET `is_deleted` = TRUE WHERE stock_id = '$stock_id'";
			return parent::query($query);
		}

		public function quantity_sum($product_id) {
			$query = "SELECT SUM(product_quantity) AS sum FROM ".static::$table." WHERE product_id = '$product_id'";
			$sum = (int)parent::select($query)[0]['sum'];
			$query = "SELECT SUM(quantity) AS qty FROM `sales_details` WHERE product_id = '$product_id'";
			$quantity_sold = (int)parent::select($query)[0]['qty'];
			$x = $sum - $quantity_sold;
			return $x;
		}
		public function count_stocks() {
			// $query = "SELECT stock_id, COUNT(*) FROM `stocks` GROUP BY stock_id";
			$query = "
				SELECT COUNT(*) AS Total
				FROM ".static::$table. " WHERE is_deleted = FALSE";
			return parent::select($query);
		}

		public function inventory_count_query() {
			$query = "
				SELECT *
				FROM ".static::$table." 
				WHERE `is_deleted` = FALSE
			";
			return parent::select($query);
		}

		public function inventory_count_display() {
			$query = "SELECT COUNT(*) AS total FROM `stocks` WHERE is_deleted = FALSE";
			return parent::select($query);
		}

		public function get_sales_details($sales_details_id) {
			$query = "SELECT * FROM `sales_details` WHERE sales_details_id = '$sales_details_id'";
			return parent::select($query)[0];			
		}

		public function stock_search_by_id($item_to_search) {
			$query = "
				SELECT stock_id                    AS stock_id, 
				       product.product_name        AS stock_name, 
				       product.product_description AS stock_description, 
				       location                    AS stock_location, 
				       cost_price                  AS stock_cost_price, 
				       product.selling_price       AS stock_selling_price, 
				       product_quantity            AS stock_quantity, 
				       product_expiration          AS stock_expire_date 
				FROM   ".static::$table." 
				       INNER JOIN product 
				               ON stocks.product_id = product.product_id 
				WHERE  stock_id LIKE '%$item_to_search%' 
				       AND stocks.is_deleted = false 
				ORDER  BY stock_id DESC 
			";
			return parent::select($query);
		}

		public function stock_search_by_name($item_to_search) {
			$query = "
				SELECT stock_id                    AS stock_id, 
				       product.product_name        AS stock_name, 
				       product.product_description AS stock_description, 
				       location                    AS stock_location, 
				       cost_price                  AS stock_cost_price, 
				       product.selling_price       AS stock_selling_price, 
				       product_quantity            AS stock_quantity, 
				       product_expiration          AS stock_expire_date 
				FROM   ".static::$table." 
				       INNER JOIN product 
				               ON stocks.product_id = product.product_id 
				WHERE  product.product_name LIKE '%$item_to_search%' 
				       AND stocks.is_deleted = false 
				ORDER  BY stock_id DESC 
			";
			return parent::select($query);
		}

		public function stock_search_by_description($item_to_search) {
			$query = "
				SELECT stock_id                    AS stock_id, 
				       product.product_name        AS stock_name, 
				       product.product_description AS stock_description, 
				       location                    AS stock_location, 
				       cost_price                  AS stock_cost_price, 
				       product.selling_price       AS stock_selling_price, 
				       product_quantity            AS stock_quantity, 
				       product_expiration          AS stock_expire_date 
				FROM   ".static::$table." 
				       INNER JOIN product 
				               ON stocks.product_id = product.product_id 
				WHERE  product.product_description LIKE '%$item_to_search%' 
				       AND stocks.is_deleted = false 
				ORDER  BY stock_id DESC 
			";
			return parent::select($query);
		}

		public function stock_search_by_location($item_to_search) {
			$query = "
				SELECT stock_id                    AS stock_id, 
				       product.product_name        AS stock_name, 
				       product.product_description AS stock_description, 
				       location                    AS stock_location, 
				       cost_price                  AS stock_cost_price, 
				       product.selling_price       AS stock_selling_price, 
				       product_quantity            AS stock_quantity, 
				       product_expiration          AS stock_expire_date 
				FROM   ".static::$table." 
				       INNER JOIN product 
				               ON stocks.product_id = product.product_id 
				WHERE  location LIKE '%$item_to_search%' 
				       AND stocks.is_deleted = false 
				ORDER  BY stock_id DESC 
			";
			return parent::select($query);
		}

		public function stock_search_by_cost_price($item_to_search) {
			$query = "
				SELECT stock_id                    AS stock_id, 
				       product.product_name        AS stock_name, 
				       product.product_description AS stock_description, 
				       location                    AS stock_location, 
				       cost_price                  AS stock_cost_price, 
				       product.selling_price       AS stock_selling_price, 
				       product_quantity            AS stock_quantity, 
				       product_expiration          AS stock_expire_date 
				FROM   ".static::$table." 
				       INNER JOIN product 
				               ON stocks.product_id = product.product_id 
				WHERE  cost_price LIKE '%$item_to_search%' 
				       AND stocks.is_deleted = false 
				ORDER  BY stock_id DESC 
			";
			return parent::select($query);
		}

		public function stock_search_by_selling_price($item_to_search) {
			$query = "
				SELECT stock_id                    AS stock_id, 
				       product.product_name        AS stock_name, 
				       product.product_description AS stock_description, 
				       location                    AS stock_location, 
				       cost_price                  AS stock_cost_price, 
				       product.selling_price       AS stock_selling_price, 
				       product_quantity            AS stock_quantity, 
				       product_expiration          AS stock_expire_date 
				FROM   ".static::$table." 
				       INNER JOIN product 
				               ON stocks.product_id = product.product_id 
				WHERE  product.selling_price LIKE '%$item_to_search%' 
				       AND stocks.is_deleted = false 
				ORDER  BY stock_id DESC 
			";
			return parent::select($query);
		}

		public function stock_search_by_quantity($item_to_search) {
			$query = "
				SELECT stock_id                    AS stock_id, 
				       product.product_name        AS stock_name, 
				       product.product_description AS stock_description, 
				       location                    AS stock_location, 
				       cost_price                  AS stock_cost_price, 
				       product.selling_price       AS stock_selling_price, 
				       product_quantity            AS stock_quantity, 
				       product_expiration          AS stock_expire_date 
				FROM   ".static::$table." 
				       INNER JOIN product 
				               ON stocks.product_id = product.product_id 
				WHERE  product_quantity LIKE '%$item_to_search%' 
				       AND stocks.is_deleted = false 
				ORDER  BY stock_id DESC 
			";
			return parent::select($query);
		}

		public function stock_search_by_expire_date($item_to_search) {
			$query = "
				SELECT stock_id                    AS stock_id, 
				       product.product_name        AS stock_name, 
				       product.product_description AS stock_description, 
				       location                    AS stock_location, 
				       cost_price                  AS stock_cost_price, 
				       product.selling_price       AS stock_selling_price, 
				       product_quantity            AS stock_quantity, 
				       product_expiration          AS stock_expire_date 
				FROM   ".static::$table." 
				       INNER JOIN product 
				               ON stocks.product_id = product.product_id 
				WHERE  product_expiration LIKE '%$item_to_search%' 
				       AND stocks.is_deleted = false 
				ORDER  BY stock_id DESC 
			";
			return parent::select($query);
		}

		public function order($qty) {
			$query = "
				SELECT stocks.stock_id             AS stock_id, 
				       product.product_name        AS product_name, 
				       stocks.product_quantity     AS quantity, 
				       product.product_description AS description, 
				       product.product_barcode     AS barcode 
				FROM   `stocks` 
				       INNER JOIN product 
				               ON stocks.product_id = product.product_id 
				WHERE  stocks.product_quantity <= '$qty' 
			";
			return parent::select($query);
		}

	}
?>