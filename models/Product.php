<?php

class Product
{
    const SHOW_BY_DEFAULT = 3;

    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT)
    {
        $count = intval($count);
        
        $db = Db::getConnection();

        $products = array();

        $result = $db->query('SELECT id,name,price,image,is_new FROM products
                WHERE status = "1"
                ORDER BY id DESC
                LIMIT '.$count);

        $i = 0;
        while ($row =$result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['image'] = $row['image'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $products;
    }

    public static function getProductsByCategory($categoryId = false, $page = 1)
    {
        if ($categoryId) {
            $page = intval($page);
            $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

            $db = Db::getConnection();

            $products = array();

            $result = $db->query("SELECT id,name,price,image,is_new FROM products
                WHERE status = '1' AND category_id = '$categoryId'
                ORDER BY id DESC
                LIMIT " . self::SHOW_BY_DEFAULT
                . " OFFSET ".$offset);

            $i = 0;
            while ($row =$result->fetch()) {
                $products[$i]['id'] = $row['id'];
                $products[$i]['name'] = $row['name'];
                $products[$i]['image'] = $row['image'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['is_new'] = $row['is_new'];
                $i++;
            }

            return $products;
        }
    }

    public static function getProductById($id)
    {
        $id = intval($id);

        if ($id) {
            $db = Db::getConnection();

            $result = $db->query('SELECT * FROM products WHERE id=' . $id);
            $result->setFetchMode(PDO::FETCH_ASSOC);

            $product = $result->fetch();

            return $product;
        }
    }
}
