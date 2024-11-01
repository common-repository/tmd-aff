<?php
/** Add custom meta box **/
add_action( 'add_meta_boxes', 'TMD_add_custom_box' );
/* Do something with the data entered */
add_action( 'save_post', 'TMD_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function TMD_add_custom_box() {
    $screens = array( 'post', 'page' );
    foreach ($screens as $screen) {
        add_meta_box(
            'TMD_sectionid',
            __( 'TMD Azon', 'TMD_textdomain' ),
            'TMD_inner_custom_box',
            $screen
        );
    }
}

/* Prints the box content */
function TMD_inner_custom_box( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'TMD_noncename' );

  // The actual fields for data entry
  // Use get_post_meta to retrieve an existing value from the database and use the value for the form
  $R_value = get_post_meta( $post->ID, 'Aff_active', true ); 
  $Stars = get_post_meta( $post->ID, 'TMD-rating', true );
  $ASIN = get_post_meta( $post->ID, 'TMD-asin', true );
  $reviews = get_post_meta( $post->ID, 'TMD-reviews', true );
  $Price = get_post_meta( $post->ID, 'TMD-price', true );
  $images = get_post_meta( $post->ID, 'TMD-images', true );
  $time = get_post_meta( $post->ID, 'TMD-time', true );
  echo "<style>#TMD_sectionid label {display: inline-block; width: 100px; }</style>";
    
  echo '<p><label for="Aff_active">';
       _e(" ", 'TMD_textdomain' );
  echo '</label> ';    
  ?><input type="radio" name="Aff_active" class="Aff_active" <?php checked( $R_value, 'enable' );?> value="enable"> enable <input type="radio" name="Aff_active" <?php checked( $R_value, 'disable' );?> value="disable"> disable </p>
  
  <?php

  echo '<p><label for="TMD-asin">';
       _e("Product ASIN", 'TMD_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="TMD-asin" name="TMD-asin" value="'.esc_attr($ASIN).'" size="10" /> <input type="button" id="check_asin" class="button" name="Preview" value="Preview" /> <img src="'.plugins_url('/images/loading.gif', dirname(__FILE__) ).'" class="tmd-loading" width="30" height="30" style="display:none;" ></p>';  
  
  
  echo '<p><label for="TMD-rating">';
       _e("Rating", 'TMD_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="TMD-rating" name="TMD-rating" value="'.esc_attr($Stars).'" size="10" /></p>';
  
  echo '<p><label for="TMD-reviews">';
       _e("Customer reviews  ", 'TMD_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="TMD-reviews" name="TMD-reviews" value="'.esc_attr($reviews).'" size="10" /></p>';
  
  echo '<p><label for="TMD-price">';
       _e("Price", 'TMD_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="TMD-price" name="TMD-price" value="'.esc_attr($Price).'" size="10" /></p>';
  
  echo '<p><label for="TMD-images">';
       _e("Image Url", 'TMD_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="TMD-images" name="TMD-images" value="'.esc_attr($images).'" size="50" /></p>';  

  echo '<p><label for="TMD-images">';
       _e("Image Url", 'TMD_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="TMD-time" name="TMD-time" value="'.esc_attr($time).'" size="10" /></p>'; 
}

/* When the post is saved, saves our custom data */
function TMD_save_postdata( $post_id ) {

  // First we need to check if the current user is authorised to do this action.
  if ( 'page' == $_POST['post_type'] ) {
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return;
  } else {
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return;
  }

  // Secondly we need to check if the user intended to change this value.
  if ( ! isset( $_POST['TMD_noncename'] ) || ! wp_verify_nonce( $_POST['TMD_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  // Thirdly we can save the value to the database

  //if saving in a custom table, get post_ID
  $post_ID = $_POST['post_ID'];
  //sanitize user input
  $Aff_active = sanitize_text_field( $_POST['Aff_active'] );
  $my_Stars = sanitize_text_field( $_POST['TMD-rating'] );
  $my_ASIN = sanitize_text_field( $_POST['TMD-asin'] );
  $my_reviews = sanitize_text_field( $_POST['TMD-reviews'] );
  $my_Price = sanitize_text_field( $_POST['TMD-price'] );
  $my_img = $_POST['TMD-images']   ;
  $my_time = sanitize_text_field( $_POST['TMD-time'] );
   // Do something with $mydata
   update_post_meta($post_ID, 'Aff_active', $Aff_active);
   update_post_meta($post_ID, 'TMD-rating', $my_Stars);
   update_post_meta($post_ID, 'TMD-asin', $my_ASIN);
   update_post_meta($post_ID, 'TMD-reviews', $my_reviews);
   update_post_meta($post_ID, 'TMD-price', $my_Price);
   update_post_meta($post_ID, 'TMD-images', $my_img);
   update_post_meta($post_ID, 'TMD-time', $my_time);
}
?>