<?php 
include 'amazon_class.php';

function get_data_buy_asin($asin) {
	$amazon = new amazon_api;
	$public_key= get_option( 'TMD_Amazon_Access_Key' );
	$private_key = get_option( 'TMD_Amazon_Secret_Access_Key' );
	$amazon_id =  get_option( 'TMD_Amazon_Associate_Tag' );
	$ext = 'com';
	$amazon->setKey($public_key,$private_key ,$amazon_id,$ext);
	$url = $amazon->url_request($asin);
	$content = $amazon->grab_content($url);
	if ($content <> 'false')
	{
		$if_url = html_entity_decode($amazon->get_customerreviews($content));
		$blogtime = current_time( 'mysql' ); 
		$response = array( 
			'error' => false,
			'detailpage'		  => $amazon->get_detail_page_url($content), // string
			'smallimage' 		  => $amazon->get_smallimage($content), // string
			'mediumimage'		  => $amazon->get_mediumimage($content), // string
			'largeimage' 		  => $amazon->get_largeimage($content), // string
			'imagesets_swatch'    => $amazon->get_imagesets_swatchimage($content), // string with commas delimited
			'imagesets_small'     => $amazon->get_imagesets_smallimage($content), // string with commas delimited
			'imagesets_thumbnail' => $amazon->get_imagesets_thumbnailimage($content), // string with commas delimited
			'imagesets_tiny'	  => $amazon->get_imagesets_tinyimage($content), // string with commas delimited
			'imagesets_medium'	  => $amazon->get_imagesets_mediumimage($content), // string with commas delimited
			'imagesets_large'	  => $amazon->get_imagesets_largeimage($content),   // string with commas delimited
			'binding'			  => $amazon->get_binding($content), // string
			'brand' 			  => $amazon->get_brand($content), // string
			'color' 			  => $amazon->get_color($content), // string
			'feature' 			  => $amazon->get_feature($content), // string
			'label'				  => $amazon->get_label($content), // string
			'listprice' 		  => $amazon->get_listprice($content), // string
			'manufacture' 		  => $amazon->get_manufacture($content), // string
			'model' 			  => $amazon->get_model($content), // string
			'title' 			  => $amazon->get_title($content), // string
			'moreoffersurl'		  => $amazon->get_moreoffersurl($content), // string
			'price' 			  => $amazon->get_price($content), // string
			'amountsaved' 		  => $amazon->get_amountsaved($content), // string
			'percentagesaved' 	  => $amazon->get_percentagesaved($content), // string
			'customerreviews' 	  => $amazon->get_customerreviews($content), // string , frame url
			'editorialreviews'    => $amazon->get_editorialreviews($content), // string
			'dimensi'			  => $amazon->get_itemdimentions($content), // string
			'addwishlist' 		  => $amazon->get_addwishlist($content), // string
			'technicaldetails'	  => $amazon->get_technicaldetails($content), // string
			'allcustreview'		  => $amazon->get_allcustreview($content), // string
			'alloffer' 			  => $amazon->get_alloffer($content), // string
			'totalreviews'		  => darius_amazon_total_reviews($if_url),
			'ratting'             => darius_amazon_total_ratting($if_url),
			'time'				  => $blogtime,
		);	
	}
	return $response;
}
function sb_test_ajax_callback() { 
	$asin = $_POST['asin'];
	$rs = get_data_buy_asin($asin);
	wp_send_json( $rs);
}
add_action('wp_ajax_sb_test_ajax', 'sb_test_ajax_callback');
// curl reviews
function darius_amazon_total_reviews( $get ) {
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt( $ch, CURLOPT_URL, $get);
	$rawdata = curl_exec( $ch);
	curl_close( $ch);
	$error_msg = "There are no customer reviews for this item";
	if (strlen(strstr($rawdata,$error_msg)) == FALSE) {
		$raw_data = str_replace('<b>', "<splhere>", $rawdata);
        $raw_data = str_replace(' Reviews</b>', "<splhere>", $raw_data);
		$raw_data2 = explode("<splhere>", $raw_data);
		$rating = $raw_data2[1];
		$rating = strip_tags( $rating);
		$rating = trim( $rating);
		$total = $rating;
	} else {
		$total = "";
	}
	return $total;
}
// curl ratting
function darius_amazon_total_ratting( $get ) {
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt( $ch, CURLOPT_URL, $get);
	$rawdata = curl_exec( $ch);
	curl_close( $ch);
	$error_msg = "There are no customer reviews for this item";
	if( strlen( strstr($rawdata,$error_msg)) == FALSE) {
		$raw_data = str_replace("out of 5 stars","<splhere>", $rawdata);
		$raw_data = str_replace('" align="absbottom" title="','', $raw_data);
		$raw_data = str_replace("customer reviews</a>)","<splhere>", $raw_data);
		$raw_data2 = explode("<splhere>", $raw_data);
		$rating = $raw_data2[1];
		$rating = strip_tags( $rating);
		$rating = trim( $rating);
		$ratingstars = $rating;
	} else {
		$ratingstars = "";
	}
	return $ratingstars;
}
?>