<div class="wrap">
<h1>Change Prices by Amperage</h1>

<br>

<form method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

    <input type="hidden" name="page" value="<?php echo esc_html($_GET['page']); ?>">

    <select name="term-id" style="min-width: 200px;">
<?php foreach ($terms as $t) : ?>
        <option 
        value="<?php echo $t->term_id; ?>" 
        <?php if (isset($_GET['term-id']) && $_GET['term-id'] == $t->term_id) : ?>
            selected
        <?php endif; ?>        
        >
            <?php echo esc_html($t->name); ?>
        </option>
<?php endforeach;?>
    </select>

    <input type="submit" class="button" value="View Products">

</form>

<br>

<?php if (count($products)) : ?>
    <h3>Total: <?php echo count($products); ?> product variations for <?php echo esc_html($term->name); ?></h3>

    <h3>Change price: </h3>

    <?php if ($message) : ?>
        <div class="alert-success">
            <?php echo esc_html($message); ?>
        </div>
    <?php endif;?>

    <?php if ($validations) : ?>
        <div class="alert-error">
        Error:
        <ul>
        <?php foreach ($validations as $validation) : ?>
            <?php foreach ($validation as $v) : ?>
            <li><?php echo esc_html($v); ?></li>
            <?php endforeach;?>
        <?php endforeach;?>
        </ul>
        </div>
    <?php endif;?>

    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

        <input type="hidden" name="term-id" value="<?php echo $term->term_id ?>">

        <input type="text" style="min-width: 200px;"  name="price" placeholder="New Price">

        <span class="btn-group" data-toggle="buttons" style="margin: 0 10px;">
            <label class="btn btn-primary active">
                <input type="radio" name="type" id="regular" value="regular"
                <?php if (isset($_POST['type']) && $_POST['type'] == 'regular') : ?>
                    checked
                <?php endif;?>
                <?php if (!isset($_POST['type'])) : ?>
                    checked
                <?php endif;?>
                > Regular price
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="type" id="sale" value="sale"
                <?php if (isset($_POST['type']) && $_POST['type'] == 'sale') : ?>
                    checked
                <?php endif;?>
                > Sale Price
            </label>
        </span>

        <input type="submit" name="change-price" id="change-price" class="button" value="Change Price">

    </form>


    <table class="widefat striped">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product</th>
                <th>Variation ID</th>
                <th>SKU</th>
                <th>Price</th>
                <th>Sale Price</th>
                <th></th>

            </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product) : ?>
        <tr>
            <td><?php echo esc_html($product['parent_id']); ?></td>
            <td>
                <a href="<?php echo esc_html($product['parent_permalink']); ?>" target="_blank">
                    <?php echo esc_html($product['parent_title']); ?>
                </a>
            </td>
            <td><?php echo esc_html($product['variation_id']); ?></td>
            <td><?php echo esc_html($product['variation_sku']); ?></td>
            <td>
                <?php if ($product['variation_price']) : ?>
                    $<?php echo esc_html($product['variation_price']); ?>
                <?php endif;?>
            </td>
            <td>
                <?php if ($product['variation_sale_price']) : ?>
                    $<?php echo esc_html($product['variation_sale_price']); ?>
                <?php endif;?>
            </td>
            <td>
                <a href="<?php echo esc_html($product['parent_edit_post_link']); ?>" target="_blank">
                    Edit
                </a>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
<?php endif;?>

</div>