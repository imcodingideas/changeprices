<?php
/**
 * Renders the page /wp-admin/admin.php?page=custom_changeprices_list
 *
 * @return boolean
 */
function custom_changeprices_list()
{
    $validations = null;
    $message     = null;

    //if this is a post request, execute
    if (isset($_POST['change-price'])) {
        //https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data
        $term_id = isset($_POST['term-id']) ? intval($_POST['term-id']) : null;
        $price   = isset($_POST['price']) ? sanitize_text_field($_POST['price']) : null;
        $type    = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : null;

        //validate
        $v = new Valitron\Validator(
            array(
                'term_id' => $term_id,
                'price'   => $price,
                'type'    => $type,
            )
        );

        $v->rule('required', ['term_id']);
        $v->rule('numeric', ['price']);
        $v->rule('integer', ['term_id']);
        $v->rule('in', 'type', ['regular', 'sale']);

        if ($type == "regular") {
            $v->rule('required', 'price');
        }

        if ($v->validate()) {
            change_prices($term_id, $price, $type);
            $message = "Prices changed successfully";
        } else {
            $validations = $v->errors();
        }
    }

    //if we receive the term id
    $term     = null;
    $products = array();

    if (isset($_GET['term-id'])) {
        $term_id  = sanitize_text_field($_GET['term-id']);
        $term     = get_term($term_id);
        $products = get_products($term->slug);
    }

    $terms = get_terms(
        array(
            'taxonomy'   => 'pa_amperage',
            'hide_empty' => true,
        )
    );

    include 'templates/changeprices-list.php';
    return true;
}
