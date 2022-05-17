<?php

include_once ROOT.'/models/Category.php';
include_once ROOT.'/models/Product.php';

class SiteController
{
    public function actionIndex()
    {
        $categories = array();
        $categories = Category::getCategoriesList();

        $products = array();
        $products = Product::getLatestProducts(9);

        require_once(ROOT.'/views/site/index.php');

        return true;
    }
}
