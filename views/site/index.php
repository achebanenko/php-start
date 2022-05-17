<!DOCTYPE html>
<html>

<head>
    <title>Index</title>
    <?php include ROOT.'/views/layout/head.php';?>
</head>

<body>
    <?php include ROOT.'/views/layout/header.php';?>

    <div id="content">
        <div id="cols">
            <div id="left">
                <ul>
                    <?php foreach ($categories as $category):?>
                    <li>
                        <a
                            href="category/<?php echo $category['id'];?>">
                            <?php echo $category['name'];?>
                        </a>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>

            <div id="right">
                <h2>Products</h2>

                <div class="listing">
                    <?php foreach ($products as $product):?>
                    <?php include ROOT.'/views/products/card.php';?>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
    <?php include ROOT.'/views/layout/footer.php';?>
</body>

</html>