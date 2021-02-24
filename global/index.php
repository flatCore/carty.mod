<?php

include 'modules/carty.mod/global/functions.php';
$carty_preferences = carty_get_preferences();

$carty_language = 'modules/carty.mod/lang/'.$page_contents['page_language'].'.php';

if(is_file($carty_language)) {
	include $carty_language;
} else {
	include 'modules/carty.mod/lang/en.php';
}


$this_url = '/'.$fct_slug.$mod_slug;
$cnt_carty_products = 0;
$carty_msg = '';
$form_msg = '';
$carty_sender_mail = '';


$prefs_mailer_adr = $fc_prefs['prefs_mailer_adr'];
$prefs_mailer_name = $fc_prefs['prefs_mailer_name'];
if($fc_prefs['prefs_mailer_type'] == 'smtp') {
	$prefs_mailer_type = 'smtp';
	require 'content/config_smtp.php';
}
	
/* send the form */
if(isset($_POST['send_carty_form'])) {
		
	$send_carty = true;
	$form_msg = '';
	
	$carty_tpl_mail_file = 'modules/carty.mod/styles/'.$carty_preferences['template'].'/mail.tpl';
	$carty_tpl_mail = file_get_contents($carty_tpl_mail_file);
	
	$recipient['name'] = $prefs_mailer_name;
	$recipient['mail'] = $prefs_mailer_adr;
	$subject = 'carty.mod Anfrage';
	
	foreach($_POST as $key => $val) {
		${"checked_$key"} = carty_check_inputs($val); 
	}
	
	$carty_tpl_mail = str_replace('{products}', $checked_sender_products, $carty_tpl_mail);
	$carty_tpl_mail = str_replace('{sender_mail}', $checked_carty_sender_mail, $carty_tpl_mail);
	$carty_tpl_mail = str_replace('{sender_name}', $checked_carty_sender_name, $carty_tpl_mail);
	$carty_tpl_mail = str_replace('{sender_firstname}', $checked_carty_sender_firstname, $carty_tpl_mail);
	$carty_tpl_mail = str_replace('{sender_street}', $checked_carty_sender_street, $carty_tpl_mail);
	$carty_tpl_mail = str_replace('{sender_street_nbr}', $checked_carty_sender_street_nbr, $carty_tpl_mail);
	
	$carty_tpl_mail = str_replace('{sender_zip}', $checked_carty_sender_zip, $carty_tpl_mail);
	$carty_tpl_mail = str_replace('{sender_city}', $checked_carty_sender_city, $carty_tpl_mail);
	$carty_tpl_mail = str_replace('{sender_message}', $checked_carty_sender_message, $carty_tpl_mail);
		
	if($_POST['carty_sender_mail'] == '') {
		$send_carty = false;
		$form_msg .= '<div class="alert alert-danger">'.$mod_lang['message_missing_mail'].'</div>';
	}
	
	if($_POST['carty_sender_name'] == '') {
		$send_carty = false;
		$form_msg .= '<div class="alert alert-danger">'.$mod_lang['message_missing_lastname'].'</div>';
	}
	
	if($_POST['carty_sender_firstname'] == '') {
		$send_carty = false;
		$form_msg .= '<div class="alert alert-danger">'.$mod_lang['message_missing_firstname'].'</div>';
	}
	
	if($checked_carty_sender_street == '' OR $checked_carty_sender_street_nbr == '' OR $checked_carty_sender_zip == '' OR $checked_carty_sender_city == '') {
		$send_carty = false;
		$form_msg .= '<div class="alert alert-danger">'.$mod_lang['message_missing_address'].'</div>';
	}
	
	if($_POST['privacy_check'] != 'agree') {
		$send_carty = false;
		$form_msg .= '<div class="alert alert-danger">'.$mod_lang['message_missing_privacy_check'].'</div>';
	}
	
	if($checked_sender_products == '') {
		$send_carty = false;
		$form_msg .= '<div class="alert alert-danger">'.$mod_lang['message_missing_products'].'</div>';
	}
	
	if($send_carty == true) {
		$carty_sendmail = fc_send_mail($recipient,$subject,$carty_tpl_mail);

		if($carty_sendmail == 1) {
			$form_msg = '<div class="alert alert-success">'.$mod_lang['message_form_send_success'].'</div>';
			unset($checked_carty_sender_mail,$checked_carty_sender_name,$checked_carty_sender_firstname);
			unset($checked_carty_sender_street,$checked_carty_sender_street_nbr,$checked_carty_sender_zip,$checked_carty_sender_city,$checked_carty_sender_message);
			unset($_SESSION['carty_products']);
		} else {
			$form_msg = '<div class="alert alert-danger">'.$mod_lang['message_form_send_error'].'</div>';
		}		
		
	}
	

	
}

/* remove items from carty */
if(isset($_POST['carty_remove'])) {

	$remove_this_id = (int) $_POST['carty_remove'];
	$stored_products = $_SESSION['carty_products'];

	unset($stored_products[$remove_this_id]);
	$stored_products = array_values($stored_products);
	
	$_SESSION['carty_products'] = $stored_products;
	$carty_msg = '<div class="alert alert-info">'.$mod_lang['message_product_removed'].'</div>';
}


/* add items to carty */
if(isset($_POST['add_to_carty'])) {
		
	/* we store the product information from th ID $_POST['add_to_carty'] */
	$get_post_id = (int) $_POST['add_to_carty'];
	$store_post_data = fc_get_post_data($get_post_id);
	$carty_msg = '<div class="alert alert-success">'.$mod_lang['message_product_added'].' <b>'.$store_post_data['post_title'].'</b></div>';
	
	$store_data['id'] = $store_post_data['post_id'];
	$store_data['title'] = $store_post_data['post_title'];
	$store_data['teaser'] = strip_tags(html_entity_decode($store_post_data['post_teaser']));
	$store_data['price'] = $store_post_data['post_product_price_net'];
	$store_data['tax'] = $store_post_data['post_product_tax'];
	$store_data['unit'] = $store_post_data['post_product_unit'];
	$store_data['amount'] = $store_post_data['post_product_amount'];
	$store_data['product_nbr'] = $store_post_data['post_product_number'];
	
	
	$add_product_data[] = json_encode($store_data);	
	$get_carty_products = $_SESSION['carty_products'];
	

	if(is_array($get_carty_products)) {
		$store_product_data = array_merge($add_product_data,$get_carty_products);
	} else {
		$store_product_data = $add_product_data;
	}
	
	
	$store_product_data = array_filter($store_product_data); // remove empty elements
	
	$_SESSION['carty_products'] = $store_product_data;

}

$carty_products = $_SESSION['carty_products'];
$cnt_carty_products = count($carty_products);

/* build the cart table */
$carty_tpl_table_file = 'modules/carty.mod/styles/'.$carty_preferences['template'].'/cart-table.tpl';
$carty_tpl_table_row_file = 'modules/carty.mod/styles/'.$carty_preferences['template'].'/cart-table-row.tpl';
$carty_tpl_table_row_end_file = 'modules/carty.mod/styles/'.$carty_preferences['template'].'/cart-table-end-row.tpl';
$carty_tpl_btn_remove_file = 'modules/carty.mod/styles/'.$carty_preferences['template'].'/cart-btn-remove.tpl';
$carty_tpl_table = file_get_contents($carty_tpl_table_file);
$carty_tpl_table_row = file_get_contents($carty_tpl_table_row_file);
$carty_tpl_table_end_row = file_get_contents($carty_tpl_table_row_end_file);
$carty_tpl_btn_remove = file_get_contents($carty_tpl_btn_remove_file);

$price_all_net = 0;
$price_all_gross = 0;

for($i=0;$i<$cnt_carty_products;$i++) {
	
	$this_row = $carty_tpl_table_row;
	
	$prod = json_decode($carty_products[$i]);
	$nbr = $i+1;
	
	$btn_remove = $carty_tpl_btn_remove;
	$btn_remove = str_replace('{form_action_remove}', $this_url, $btn_remove);
	$btn_remove = str_replace('{remove_id}', $i, $btn_remove);
	
	$teaser = $prod->{'teaser'};
	$teaser = substr($teaser,0,50).' <small>(...)</small>';
	
	$price = $prod->{'price'};
	$tax_id = $prod->{'tax'};
	
	if($tax_id == '1') {
		$tax = $fc_prefs['prefs_posts_products_default_tax'];
	}
	if($tax_id == '2') {
		$tax = $fc_prefs['prefs_posts_products_tax_alt1'];
	}
	if($tax_id == '3') {
		$tax = $fc_prefs['prefs_posts_products_tax_alt2'];
	}
	
	$post_price_net = str_replace('.', '', $price);
	$post_price_net = str_replace(',', '.', $post_price_net);
	
	$post_price_gross = $post_price_net*($tax+100)/100;
	
	$price_all_net = $price_all_net+round($post_price_net,2);
	$price_all_gross = $price_all_gross+round($post_price_gross,2);
	
	$post_price_gross = fc_post_print_currency($post_price_gross);
	$post_price_net = fc_post_print_currency($post_price_net);
	
	
		
	
	$this_row = str_replace('{nbr}', $nbr, $this_row);
	$this_row = str_replace('{product_nbr}', $prod->{'product_nbr'}, $this_row);
	$this_row = str_replace('{title}', $prod->{'title'}, $this_row);
	$this_row = str_replace('{teaser}', $teaser, $this_row);
	$this_row = str_replace('{price}', $post_price_net, $this_row);
	$this_row = str_replace('{price_gross}', $post_price_gross, $this_row);
	$this_row = str_replace('{tax}', $tax, $this_row);
	$this_row = str_replace('{btn_remove}', $btn_remove, $this_row);
	
	$message_product_str .= '<p>'.$prod->{'product_nbr'}.' '.$prod->{'title'}.' '.$teaser.'</p>';
	
	$rows .= $this_row;
	
}

$included_tax = $price_all_gross-$price_all_net;

$price_all_net = fc_post_print_currency($price_all_net);
$price_all_gross = fc_post_print_currency($price_all_gross);

$end_row = $carty_tpl_table_end_row;
$end_row = str_replace('{price}', $price_all_net, $end_row);
$end_row = str_replace('{price_gross}', $price_all_gross, $end_row);
$end_row = str_replace('{tax}', $included_tax, $end_row);

$rows .= $end_row;


$carty_cart_table = str_replace('{table_rows}', $rows, $carty_tpl_table);

if($cnt_carty_products < 1) {
	$carty_cart_table = '<div class="alert alert-info">'.$mod_lang['no_products_on_list'].'</div>';
}


/* styles */
$carty_styles_file = 'modules/carty.mod/styles/'.$carty_preferences['template'].'/styles.css';
$get_carty_styles = file_get_contents($carty_styles_file);
$carty_styles = '<style type="text/css">'.$get_carty_styles.'</style>';

/* javascript */
$carty_js_file = 'modules/carty.mod/styles/'.$carty_preferences['template'].'/script.js';
$cart_js_sript = file_get_contents($carty_js_file);
$carty_js = '<script>'.$cart_js_sript.'</script>';

/* form template */
$carty_tpl_form = 'modules/carty.mod/styles/'.$carty_preferences['template'].'/form.tpl';
$carty_form = file_get_contents($carty_tpl_form);

/* cart template */
$carty_tpl_file = 'modules/carty.mod/styles/'.$carty_preferences['template'].'/cart.tpl';
$carty_tpl = file_get_contents($carty_tpl_file);
$carty_tpl = str_replace('{cart_list}', $carty_cart_table, $carty_tpl);
$carty_tpl = str_replace('{cart_list_cnt}', $cnt_carty_products, $carty_tpl);


$carty_tpl = str_replace('{carty_message}', $carty_msg, $carty_tpl);

$carty_tpl = str_replace('{form}', $carty_form, $carty_tpl);
$carty_tpl = str_replace('{form_action}', $this_url, $carty_tpl);
$carty_tpl = str_replace('{form_message}', $form_msg, $carty_tpl);
$carty_tpl = str_replace('{carty_sender_mail}', $checked_carty_sender_mail, $carty_tpl);
$carty_tpl = str_replace('{carty_sender_name}', $checked_carty_sender_name, $carty_tpl);
$carty_tpl = str_replace('{carty_sender_firstname}', $checked_carty_sender_firstname, $carty_tpl);
$carty_tpl = str_replace('{carty_sender_street}', $checked_carty_sender_street, $carty_tpl);
$carty_tpl = str_replace('{carty_sender_street_nbr}', $checked_carty_sender_street_nbr, $carty_tpl);
$carty_tpl = str_replace('{carty_sender_zip}', $checked_carty_sender_zip, $carty_tpl);
$carty_tpl = str_replace('{carty_sender_city}', $checked_carty_sender_city, $carty_tpl);
$carty_tpl = str_replace('{carty_sender_message}', $checked_carty_sender_message, $carty_tpl);
$carty_tpl = str_replace('{carty_form_hidden_product_str}', $message_product_str, $carty_tpl);

/* language */
$carty_tpl = str_replace('{label_mail}', $mod_lang['form_label_mail'], $carty_tpl);
$carty_tpl = str_replace('{label_firstname}', $mod_lang['form_label_firstname'], $carty_tpl);
$carty_tpl = str_replace('{label_lastname}', $mod_lang['form_label_lastname'], $carty_tpl);
$carty_tpl = str_replace('{label_street}', $mod_lang['form_label_street'], $carty_tpl);
$carty_tpl = str_replace('{label_street_nbr}', $mod_lang['form_label_street_nbr'], $carty_tpl);
$carty_tpl = str_replace('{label_zip}', $mod_lang['form_label_zip'], $carty_tpl);
$carty_tpl = str_replace('{label_city}', $mod_lang['form_label_city'], $carty_tpl);
$carty_tpl = str_replace('{label_message}', $mod_lang['form_label_message'], $carty_tpl);
$carty_tpl = str_replace('{message_privacy_check}', $mod_lang['message_privacy_check'], $carty_tpl);
$carty_tpl = str_replace('{label_mandatory_input}', $mod_lang['form_label_mandatory_input'], $carty_tpl);
$carty_tpl = str_replace('{btn_send_carty}', $mod_lang['form_btn_send'], $carty_tpl);
$carty_tpl = str_replace('{label_price_results}', $mod_lang['label_price_results'], $carty_tpl);
$carty_tpl = str_replace('{label_price_net}', $mod_lang['label_price_net'], $carty_tpl);
$carty_tpl = str_replace('{label_price_gross}', $mod_lang['label_price_gross'], $carty_tpl);
$carty_tpl = str_replace('{label_tax}', $mod_lang['label_price_tax'], $carty_tpl);

$carty_tpl = str_replace('{product_id}', $this_url, $carty_tpl);
$carty_tpl = str_replace('{save_url}', $this_url, $carty_tpl);
$carty_tpl = str_replace('{save_title}', $page_contents['page_title'], $carty_tpl);


/* fire to smarty */
$append_head_code .= $carty_styles;
$append_body_code .= $carty_tpl.$carty_js;


?>