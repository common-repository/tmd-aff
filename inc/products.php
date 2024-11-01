<?php 
// add produt to content
//add_action( 'genesis_before_entry_content', 'TMD_product_info' );
function display_tmd_box( $content ) {
	
	$TMD_aff = get_post_meta( get_the_ID(), 'Aff_active', true );
	if ( $TMD_aff == 'enable' ) { 
		$custom_content = TMD_product_info();
		$custom_content .= $content;
		return $custom_content;
	}else {	
		return $content;				
	}
	
}
add_filter( 'the_content', 'display_tmd_box' );
function tmd_get_clas_css($number)
{
    $convert_to_int=intval($number);//Chuyển đổi sang số nguyên

    if($number>=$convert_to_int+0.1 && $number<=$convert_to_int+0.5)
    {
        $number=$convert_to_int+0.5;
    }
    else if($number>=$convert_to_int+0.5 && $number<=$convert_to_int+0.7){
        $number=$convert_to_int+1;
    }
    $css_class = (string)$number;
	$rs = str_replace('.','-',$css_class);
    return $rs;
}
function TMD_product_info() {
	if ( is_single() ) { 
	$active_OK = get_post_meta(get_the_ID(), 'Aff_active', true);  
	$Stars = get_post_meta(get_the_ID(), 'TMD-rating', true);  
	$ASIN = get_post_meta(get_the_ID(), 'TMD-asin', true);  
	$reviews = get_post_meta(get_the_ID(), 'TMD-reviews', true);  
	$Price = get_post_meta(get_the_ID(), 'TMD-price', true);  
	$IMG = get_post_meta(get_the_ID(), 'TMD-images', true);  
	$time = get_post_meta(get_the_ID(), 'TMD-time', true); 
	$tags_ID = get_option( 'TMD_Amazon_Associate_Tag' );
	$TMD_Button_Text = get_option( 'TMD_Button_Text' );
		if ($active_OK =="enable"){
			$rs = '<div id="TMD-aff-product">';
			$rs .='	<div class="tmd-box">';
			$rs .='		<img class="tmd-pt" src="'. $IMG .'" alt="'.get_the_title().'">';
			$rs .='		<div class="tmd-pt-info">';
			$rs .='			<div class="wr">';
			$rs .='				<div class="tmd-Rating">';
			$rs .='					<span>Rating</span>';
			$rs .='					<i class="star star-'.tmd_get_clas_css($Stars).'"></i>';
			$rs .='				</div>';
			$rs .='				<div class="tmd-price">'. $Price .'</div>	';	
			$rs .='				<div class="tmd-reviews">';
			$rs .='					<span>Customer reviews</span>';
			$rs .=					 $reviews . ' +';
			$rs .='				</div>';		
			$rs .='			</div>';		
			$rs .='		</div>';
			$rs .='	</div>';
			$rs .='	<div class="tmd-buy">';
			$rs .='		<span class="tmd-time">Prices are accurate as of '. $time .'</span>';
			$rs .='		<a href="http://www.amazon.com/dp/'. $ASIN .'/?tag='. $tags_ID.'" rel="nofollow" target="_blank" title="'.get_the_title().'">'. $TMD_Button_Text.'</a>';			
			$rs .='	</div>';
			$rs .='"</div>';
		}
		return $rs;
	}
}
?>