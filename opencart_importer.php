<?php
/*
Plugin Name: OpenCart Product Display
Plugin URI: http://anushreeitconsultancy.com/opencart-importer-plugin/
Description: Plugin for displaying products from an OpenCart shopping cart database
Author: Ajinkya N
Version: 1.0
Author URI: http://in.linkedin.com/pub/ajinkya-nahar/8/404/77b
*/

/**
 * @param int $product_cnt
 */
function opcimp_getproducts($product_cnt=1) {

    //Connect to the OpenCart database

    $opencartdb = new wpdb(get_option('opcimp_dbuser'),get_option('opcimp_dbpwd'), get_option('opcimp_dbname'), get_option('opcimp_dbhost'));

    $retval = '';

    $product_id_list = array(0);
    for ($i=0; $i<$product_cnt; $i++) {
        //Get a random product
        $product_id = 0;
        while(in_array($product_id,$product_id_list)){
          $product_id = $opencartdb->get_var("SELECT product_id FROM product WHERE  status=1 ORDER BY RAND() LIMIT 1");
        }
        $product_id_list[]=$product_id;
        
		//Get product image, name and URL
        $product_row = $opencartdb->get_row("SELECT * FROM product WHERE product_id=$product_id",ARRAY_A);
        $product_image = $product_row['image'];
        $product_price = round($product_row['price'],2);

        $product_name = $opencartdb->get_var("SELECT name FROM product_description WHERE product_id=$product_id");



        $store_url = get_option('opcimp_store_url');
        $seo_enabled = get_option('opcimp_seo_enabled');
        $image_folder = get_option('opcimp_prod_img_folder');
        $display_price =  get_option('opcimp_display_price');

        if($seo_enabled=='Yes'){

            $seo_keyword = $opencartdb->get_var("SELECT keyword FROM url_alias WHERE query='product_id=".$product_id."'");
            //Build the HTML code
            $retval .= '<div class="opcimp_product">';
            $retval .= '<a href="'. $store_url . $seo_keyword. '"><img width=50 height=50 src="' . $image_folder . $product_image . '" /></a><br />';

             $retval .= '<a href="'. $store_url . $seo_keyword . '">' . $product_name . '</a><br/>';
                        if ($display_price == 'Yes')
                                $retval .= 'Price: $' . $product_price . '';

            $retval .= '</div>';
        }
        else {
            //Build the HTML code
            $retval .= '<div class="opcimp_product">';
            $retval .= '<a href="'. $store_url . 'index.php?route=product/product&product_id=' . $product_id . '"><img width=50 height=50 src="' . $image_folder . $product_image . '" /></a><br />';
            $retval .= '<a href="'. $store_url . 'index.php?route=product/product&product_id=' . $product_id . '">' . $product_name . '</a><br/>';
                        if ($display_price == 'Yes')
                                $retval .= 'Price: $' . $product_price . '';

            $retval .= '</div>';

        }
    }
    return $retval;
}


/* Display user specified content around generated HTML. */
function widget_opencart_product_display($args) {
    extract($args);

    $options = get_option("widget_opencart_product_display");
    if (!is_array($options)) {
        $options = array(
            'title' => 'In Store',
            'num_products' => 3
        );
    }

    echo $before_widget;
    echo $before_title;
    echo $options['title'];
    echo $after_title;
    echo opcimp_getproducts($options['num_products']);
    echo $after_widget;
}

/* User controls for widget. */
function opencart_product_display_control() {
    $options = get_option('widget_opencart_product_display');

    if (!is_array($options)) {
        $options = array(
            'title' => 'In Store',
            'num_products' => 3
        );
    }

    if ($_POST['opencart_product_display_submit']) {
        $options['title'] = htmlspecialchars($_POST['opencart_product_display_title']);
        $options['num_products'] = htmlspecialchars($_POST['opencart_num_products']);
        update_option('widget_opencart_product_display', $options);
    }

    echo '<p>';
    echo '<label for="opencart_product_display_title">Title: </label><br />';
    echo '<input type="text" id="opencart_product_display_title" name="opencart_product_display_title" value="'.$options['title'].'" /><br /><br />';
    echo '<label for="opencart_num_products">Number Of Products To Show: </label><br />';
    echo '<input type="text" id="opencart_num_products" name="opencart_num_products" value="'.$options['num_products'].'" />';
    echo '<input type="hidden" id="opencart_product_display_submit" name="opencart_product_display_submit" value="1" />';
}

/* Initialise the product generator */
function opencart_product_generator_init() {
    register_sidebar_widget(__('OpenCart Product Display'), 'widget_opencart_product_display');
    register_widget_control(  ('OpenCart Product Display'), 'opencart_product_display_control', 300, 300);
}



/**
 *
 */
function opcimp_admin()
{
    /**
     *
     */
    require('opencart_import_admin.php');
    exit;
}

/**
 *
 */
function opcimp_admin_actions()
{
    /**
     *
     */
    add_options_page("OpenCart Product Display", "OpenCart Product Display", 1, "OpenCartProductDisplay", "opcimp_admin");
}

add_action('admin_menu', 'opcimp_admin_actions');
add_action('plugins_loaded', 'opencart_product_generator_init');

?>