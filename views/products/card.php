<div class="card">
    <a
        href="product/<?php echo $product['id']?>">
        <?php echo $product['name'];?>
    </a>
    <?php if ($product['is_new']):?>
    New
    <?php endif;?>
    <img src="/php-start/template/images/111.jpg" width="200" />
</div>