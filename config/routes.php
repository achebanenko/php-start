<?php

return array(
    'news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2',
    // 'news/([0-9]+)' => 'news/view/$1',
    'news' => 'news/index',

    'category/([0-9]+)/page-([0-9]+)' => 'products/category/$1/$2',
    'category/([0-9]+)' => 'products/category/$1',
    'product/([0-9]+)' => 'products/view/$1',
    'products' => 'products/index',
    '' => 'site/index',
);
