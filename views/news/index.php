<!DOCTYPE html>
<html>

<head>
    <title>News</title>
    <?php include ROOT.'/views/layout/head.php';?>
</head>

<body>
    <?php include ROOT.'/views/layout/header.php';?>

    <div id="content">

        <h1>News</h1>

        <?php foreach ($newsList as $newsItem):?>
        <h2>
            <?php echo $newsItem['title'];?>
        </h2>
        <p>
            <?php echo $newsItem['short_content'];?>
        </p>
        <a
            href="/php-start/news/<?php echo $newsItem['id'];?>">Read
            more</a>
        <?php endforeach;?>

    </div>

    <?php include ROOT.'/views/layout/footer.php';?>
</body>

</html>