<?php
function custom_changeprices_list()
{
    $validations = null;
    $message     = null;

    //if this is a post request, execute
    if (isset($_POST['change-price'])) {

        $termID = isset($_POST['term-id']) ? $_POST['term-id'] : null;
        $price  = isset($_POST['price']) ? $_POST['price'] : null;
        $type   = isset($_POST['type']) ? $_POST['type'] : null;

        //validate
        $v = new Valitron\Validator(
            array(
                'termID' => $termID,
                'price'  => $price,
                'type'   => $type,
            )
        );
        if ($type == "regular") {
            $v->rule('required', ['termID', 'price']);
            $v->rule('integer', ['termID']);
            $v->rule('numeric', ['price']);
        } else if ($type == "sale") {
            $v->rule('required', ['termID']);
            $v->rule('integer', ['termID']);
            $v->rule('numeric', ['price']);
        } else {
            die("invalid input");
        }

        if ($v->validate()) {
            change_prices($termID, $price, $type);
            $message = "Prices changed successfully";
        } else {
            $validations = $v->errors();
        }
    }

    //if we receive the term id
    $term     = null;
    $products = array();

    if (isset($_GET['term-id'])) {
        $term     = get_term($_GET['term-id']);
        $products = getProducts($term->slug);
    }

    $terms = get_terms(array(
        'taxonomy'   => 'pa_amperage',
        'hide_empty' => true,
    ));

    include 'templates/changeprices-list.php';

}
