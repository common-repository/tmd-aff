<?php
//tmd notice
$TMD_Amazon_Access_Key = get_option( 'TMD_Amazon_Access_Key' );
$TMD_Amazon_Secret_Access_Key = get_option( 'TMD_Amazon_Secret_Access_Key' );
$TMD_Amazon_Associate_Tag = get_option( 'TMD_Amazon_Associate_Tag' );
$TMD_Button_Text = get_option( 'TMD_Button_Text' );
function tmd_error_notice() { 
	global $TMD_Amazon_Access_Key ;
	global $TMD_Amazon_Secret_Access_Key ;
	global $TMD_Amazon_Associate_Tag ;
	global $TMD_Button_Text ;
?>
    
    <div class="error notice">
		<h3>TMD Plugin Missing</h3>
		<ul style="list-style: initial; padding-left:30px;">
			<?php
			if ( empty($TMD_Amazon_Access_Key) ) { 
				echo '<li><b>Amazon Access Key</b></li>';
				
			} 
			else if ( empty($TMD_Amazon_Secret_Access_Key))  { 
				echo '<li><b>Amazon Secret Access Key</b></li>';
			} 
			else if ( empty($TMD_Amazon_Associate_Tag) ) { 
				echo '<li><b>Amazon Associate Tag</b></li>';
			}
			else if  ( empty($TMD_Button_Text) ) { 
				echo '<li><b>Button Text</b></li>';
			} 
			?>
		</ul>		
		<p>Go to <a href="<?php echo admin_url("admin.php?page=TMD-AFF");?>">TMD AFF Setting Page</a></p>
    </div>
    <?php
}
if (empty($TMD_Amazon_Access_Key) || empty($TMD_Amazon_Secret_Access_Key) || empty($TMD_Amazon_Associate_Tag) || empty($TMD_Button_Text)  ) {
	add_action( 'admin_notices', 'tmd_error_notice' );	
}
?>