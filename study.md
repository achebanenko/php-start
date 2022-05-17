# PHP Start | Практика
https://www.youtube.com/watch?v=ba3M3_Myrqg


## Урок 1. Реализация MVC #1

index.php
```
// Get errors on the page through development
ini_set('display_errors',1);
error_reporting(E_ALL);

// 
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/components/Router.php');
require_once(ROOT.'/components/Db.php');

$router = new Router;
$router->run();
```

config/routes.php
```
return array(
    'news' => 'news/index',
    'products' => 'products/list',
);
```

components/Router.php
```
class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }

    private function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim(str_replace('php-start', '', $_SERVER['REQUEST_URI']), '/');
        }
    }
    
    public function run()
    {
        $uri = $this->getUri();

        foreach ($this->routes as $uriPattern => $path) {
            // if (preg_match("/$uriPattern/", $uri)) {
            if (preg_match("~$uriPattern~", $uri)) {
                $segments = explode('/', $path);

                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action'.ucfirst(array_shift($segments));

                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                $controllerObject = new $controllerName;
                $result = $controllerObject->$actionName();
                if ($result != null) {
                    break;
                }
            }
        }
    }
}
```


## Урок 2. Реализация MVC #2

```
$string = '31-01-2020';
$pattern = '/([0-9]{2})-([0-9]{2})-([0-9]{4})/';
$replacement = 'Год $3, месяц $2, день $1';
echo preg_replace($pattern, $replacement, $string);
die;
```


```
function foobar($arg, $arg2) {
    echo __FUNCTION__, " got $arg and $arg2\n";
}
class foo {
    function bar($arg, $arg2) {
        echo __METHOD__, " got $arg and $arg2\n";
    }
}

// Вызываем функцию foobar() с 2 аргументами
call_user_func_array("foobar", array("one", "two"));

// Вызываем метод $foo->bar() с 2 аргументами
$foo = new foo;
call_user_func_array(array($foo, "bar"), array("three", "four"));

// Результат
// foobar got one and two
// foo::bar got three and four
```

.htaccess
```
AddDefaultCharset utf-8

RewriteEngine on
RewriteBase /php-start

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php
```

components/Db.php
```
class Db {
    public static function getConnection() {
        $paramsPath = ROOT.'/config/db_params.php';
        $params = include($paramsPath);

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);

        return $db;
    }
}
```

config/db_params.php
```
return array(
    'host' => 'localhost',
    'dbname' => 'php_start',
    'user' => 'root',
    'password' => '',
);
```

models/News.php
```
class News
{
    /**
     * Returns an array of news items
     */
    public static function getNewsList()
    {
        // $host = 'localhost';
        // $dbname = 'php_start';
        // $user = 'root';
        // $password = '';
        // $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

        $db = Db::getConnection();

        $newsList = array();
        
        $result = $db->query('SELECT id, title, date, short_content
                FROM news
                ORDER BY date DESC
                LIMIT 10');

        $i = 0;
        while ($row = $result->fetch()) {
            $newsList[$i]['id'] = $row['id'];
            $newsList[$i]['title'] = $row['title'];
            $newsList[$i]['date'] = $row['id'];
            $newsList[$i]['short_content'] = $row['short_content'];
            $i++;
        }

        return $newsList;
    }

    /**
     * Returns single news item with specified id
     * @param integer id
     */
    public static function getNewsItemById($id)
    {
        $id = intval($id);

        if ($id) {
            $db = Db::getConnection();

            $result = $db->query('SELECT * FROM news WHERE id=' . $id);
            // $result->setFetchMode(PDO::FETCH_NUM);
            $result->setFetchMode(PDO::FETCH_ASSOC);

            $newsItem = $result->fetch();
            
            return $newsItem;
        }
    }
}
```

config/routes.php
```
return array(
    'news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2',
    // 'news/([0-9]+)' => 'news/view',
    ...
);
```

components/Router.php
```
...
public function run()
{
    $uri = $this->getUri();

    foreach ($this->routes as $uriPattern => $path) {
        // if (preg_match("/$uriPattern/", $uri)) {
        if (preg_match("~$uriPattern~", $uri)) {
            $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

            $segments = explode('/', $internalRoute);

            $controllerName = array_shift($segments).'Controller';
            $controllerName = ucfirst($controllerName);

            $actionName = 'action'.ucfirst(array_shift($segments));
            $parameters = $segments;


            $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

            if (file_exists($controllerFile)) {
                include_once($controllerFile);
            }

            $controllerObject = new $controllerName;

            // $result = $controllerObject->$actionName($parameters);
            $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

            if ($result != null) {
                break;
            }
        }
    }
}
```

controllers/NewsController.php
```
include_once ROOT.'/models/News.php';

class NewsController
{
    public function actionIndex()
    {
        $newsList = array();
        $newsList = News::getNewsList();

        require_once(ROOT.'/views/news/index.php');

        return true;
    }

    // public function actionView($params)
    public function actionView($category, $id)
    {
        $newsItem = News::getNewsItemById($id);

        // echo '<pre>';
        // print_r($newsItem);

        return true;
    }
}
```

views/news/index.php
```
<!DOCTYPE html>
<html>

<head>
    <title>News Index</title>
    <link rel="stylesheet" href="template/css/style.css">
</head>

<body>
    <h1>News Index</h1>

    <?php foreach ($newsList as $newsItem):?>
    <h2>
        <?php echo $newsItem['title'];?>
    </h2>
    <p>
        <?php echo $newsItem['short_content'];?>
    </p>
    <a
        href="/news/<?php echo $newsItem['id'];?>">Read
        more</a>
    <?php endforeach;?>
</body>

</html>
```

