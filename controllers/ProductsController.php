<?php

include_once ROOT.'/models/Category.php';
include_once ROOT.'/models/Product.php';

class ProductsController
{
    public function actionIndex()
    {
        $categories = array();
        $categories = Category::getCategoriesList();

        $products = array();
        $products = Product::getLatestProducts(9);

        require_once(ROOT.'/views/products/index.php');

        return true;
    }

    public function actionView($id)
    {
        $categories = array();
        $categories = Category::getCategoriesList();

        $product = Product::getProductById($id);

        require_once(ROOT.'/views/products/view.php');
        
        return true;
    }

    public function actionCategory($categoryId, $page = 1)
    {
        $categories = array();
        $categories = Category::getCategoriesList();
        
        $products = array();
        $products = Product::getProductsByCategory($categoryId, $page);

        require_once(ROOT.'/views/products/category.php');
        
        return true;
    }
}
