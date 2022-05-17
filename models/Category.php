<?php

class Category
{
    public static function getCategoriesList()
    {
        $db = Db::getConnection();

        $categoriesList = array();

        $result = $db->query('SELECT id,name FROM categories
                ORDER BY sort_order');

        $i = 0;
        while ($row =$result->fetch()) {
            $categoriesList[$i]['id'] = $row['id'];
            $categoriesList[$i]['name'] = $row['name'];
            $i++;
        }

        return $categoriesList;
    }
}
