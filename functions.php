<?php

function getProducts($term_slug)
{
    $args = array(
        'post_type'   => 'product_variation',
        'post_status' => array('private', 'publish'),
        'numberposts' => -1,
        'orderby'     => 'menu_order',
        'order'       => 'asc',
        // 'post_parent'   => $post_id // get parent post-ID
        'meta_query'  => array(
            'amperage_clause' => array(
                'key'   => 'attribute_pa_amperage',
                'value' => $term_slug, //example: '240-amps-6-hairpin',
            ),
        ),
    );
    $variations = get_posts($args);

    $products = array();
    foreach ($variations as $variation) {
        $parent                = get_post($variation->post_parent);
        $sku                   = get_post_meta($variation->ID, '_sku', true);
        $price                 = get_post_meta($variation->ID, '_regular_price', true);
        $salePrice             = get_post_meta($variation->ID, '_sale_price', true);
        $parent_permalink      = get_permalink($variation->post_parent);
        $parent_edit_post_link = get_edit_post_link($variation->post_parent);
        array_push($products, array(
            'variation_id'          => $variation->ID,
            'variation_sku'         => $sku,
            'variation_price'       => $price,
            'variation_sale_price'  => $salePrice,
            'parent_id'             => $parent->ID,
            'parent_title'          => $parent->post_title,
            'parent_permalink'      => $parent_permalink,
            'parent_edit_post_link' => $parent_edit_post_link,
        ));
    }
    return $products;

}

function change_prices($termID, $price, $type)
{
    $term = get_term($termID);

    $products = getProducts($term->slug);
    foreach ($products as $product) {
        if ($type == "regular") {
            update_post_meta($product['variation_id'], '_regular_price', $price);
            update_post_meta($product['variation_id'], '_price', $price);
        } elseif ($type == "sale") {
            update_post_meta($product['variation_id'], '_sale_price', $price);
        }
    }
    return;
}
