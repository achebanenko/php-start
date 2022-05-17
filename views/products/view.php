<!DOCTYPE html>
<html>

<head>
    <title>Product</title>
    <?php include ROOT.'/views/layout/head.php';?>
</head>

<body>
    <?php include ROOT.'/views/layout/header.php';?>

    <div id="content">
        <h1>
            <?php echo $product['name'];?>
        </h1>

        <img src="" />

        <p>
            <?php echo $product['description'];?>
        </p>
    </div>
    <?php include ROOT.'/views/layout/footer.php';?>
</body>

</html>