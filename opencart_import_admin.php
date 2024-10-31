<?php
/*

This file is the Admin backend options form.
Author: Ajinkya N
Version: 1.0
*/
if($_POST['opcimp_hidden'] == 'Y') {

    //Form data sent
    $dbhost = $_POST['opcimp_dbhost'];
    update_option('opcimp_dbhost', $dbhost);

    $dbname = $_POST['opcimp_dbname'];
    update_option('opcimp_dbname', $dbname);

    $dbuser = $_POST['opcimp_dbuser'];
    update_option('opcimp_dbuser', $dbuser);

    $dbpwd = $_POST['opcimp_dbpwd'];
    update_option('opcimp_dbpwd', $dbpwd);

    $prod_img_folder = $_POST['opcimp_prod_img_folder'];
    update_option('opcimp_prod_img_folder', $prod_img_folder);

    $store_url = $_POST['opcimp_store_url'];
    update_option('opcimp_store_url', $store_url);

    $opcimp_seo_enabled= $_POST['opcimp_seo_enabled'];
    update_option('opcimp_seo_enabled', $opcimp_seo_enabled);

    $opcimp_display_price= $_POST['opcimp_display_price'];
    update_option('opcimp_display_price', $opcimp_display_price);

    ?>
    <div class="updated" xmlns="http://www.w3.org/1999/html"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
<?php
} else {

    //Normal page display
    $dbhost = get_option('opcimp_dbhost');
    $dbname = get_option('opcimp_dbname');
    $dbuser = get_option('opcimp_dbuser');
    $dbpwd = get_option('opcimp_dbpwd');
    $prod_img_folder = get_option('opcimp_prod_img_folder');
    $store_url = get_option('opcimp_store_url');
    $opcimp_seo_enabled = get_option('opcimp_seo_enabled');
    $opcimp_display_price = get_option('opcimp_display_price');

}
?>

<div class="wrap">
			<?php    echo "<h2>" . __( 'OpenCart Product Display Options', 'opcimp_trdom' ) . "</h2>"; ?>

<form name="opcimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="opcimp_hidden" value="Y">
    <?php    echo "<h4>" . __( 'OpenCart Database Settings', 'opcimp_trdom' ) . "</h4>"; ?>
    <p><?php _e("Database host: " ); ?><input type="text" name="opcimp_dbhost" value="<?php echo $dbhost; ?>" size="20"><?php _e(" ex: localhost" ); ?></p>
    <p><?php _e("Database name: " ); ?><input type="text" name="opcimp_dbname" value="<?php echo $dbname; ?>" size="20"><?php _e(" ex: opencart_shop" ); ?></p>
    <p><?php _e("Database user: " ); ?><input type="text" name="opcimp_dbuser" value="<?php echo $dbuser; ?>" size="20"><?php _e(" ex: root" ); ?></p>
    <p><?php _e("Database password: " ); ?><input type="text" name="opcimp_dbpwd" value="<?php echo $dbpwd; ?>" size="20"><?php _e(" ex: secretpassword" ); ?></p>
    <hr />
    <?php    echo "<h4>" . __( 'OpenCart Store Settings', 'opcimp_trdom' ) . "</h4>"; ?>
    <p><?php _e("Store URL: " ); ?><input type="text" name="opcimp_store_url" value="<?php echo $store_url; ?>" size="20"><?php _e(" ex: http://www.yourstore.com/" ); ?></p>
    <p><?php _e("Product image folder: " ); ?><input type="text" name="opcimp_prod_img_folder" value="<?php echo $prod_img_folder; ?>" size="20"><?php _e(" ex: http://www.yourstore.com/images/" ); ?></p>
    <p><?php _e("SEO URLs Enabled: " ); ?><input type=radio name="opcimp_seo_enabled" value="Yes" <?php if($opcimp_seo_enabled=='Yes')echo "checked=checked";?>> Yes &nbsp;&nbsp;&nbsp;<input type=radio name="opcimp_seo_enabled" value="No" <?php if($opcimp_seo_enabled=='No')echo "checked=checked";?>> No    </p>
    <p><?php _e("Display Price: " ); ?><input type=radio name="opcimp_display_price" value="Yes" <?php if($opcimp_display_price=='Yes')echo "checked=checked";?>> Yes &nbsp;&nbsp;&nbsp;<input type=radio name="opcimp_display_price" value="No" <?php if($opcimp_display_price=='No')echo "checked=checked";?>> No    </p>
    <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Update Options', 'opcimp_trdom' ) ?>" />
    </p>
</form>
</div>
