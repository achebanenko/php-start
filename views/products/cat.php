<li>
    <a href="/php-start/category/<?php echo $category['id'];?>"
        class="<?php if ($categoryId == $category['id']) {
    echo 'active';
}?>">
        <?php echo $category['name'];?>
    </a>
</li>