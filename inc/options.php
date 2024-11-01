<?php 
// create custom plugin settings menu
add_action('admin_menu', 'baw_create_menu');

function baw_create_menu() {

	//create new top-level menu
	add_menu_page('TMD Plugin Settings', 'TMDUC AFF', 'administrator','TMD-AFF', 'tmd_settings_page','dashicons-admin-generic');

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'tmd-settings-group', 'TMD_Amazon_Access_Key' );
	register_setting( 'tmd-settings-group', 'TMD_Amazon_Secret_Access_Key' );
	register_setting( 'tmd-settings-group', 'TMD_Amazon_Associate_Tag' );
	register_setting( 'tmd-settings-group', 'TMD_Button_Text' );
	register_setting( 'tmd-settings-group', 'Tracking_ID' );
}



function tmd_settings_page() {


?>
<div class="wrap">
<h2>TMDUC AFF Setting</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'tmd-settings-group' ); ?>
    <?php do_settings_sections( 'tmd-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
			<th scope="row">Amazon Access Key</th>
			<td><input type="text" name="TMD_Amazon_Access_Key" id="TMD_Amazon_Access_Key" value="<?php echo esc_attr( get_option('TMD_Amazon_Access_Key') ); ?>" /></td>
		</tr>
		<tr valign="top">
			<th scope="row">Amazon Secret Access Key</th>
			<td><input type="text" name="TMD_Amazon_Secret_Access_Key" id="TMD_Amazon_Secret_Access_Key" value="<?php echo esc_attr( get_option('TMD_Amazon_Secret_Access_Key') ); ?>" /></td>
		</tr>
		<tr valign="top">		
			<th scope="row">Amazon Associate Tag</th>
			<td><input type="text" name="TMD_Amazon_Associate_Tag" id="TMD_Amazon_Associate_Tag" value="<?php echo esc_attr( get_option('TMD_Amazon_Associate_Tag') ); ?>" /></td>			
		</tr>
		<tr valign="top">			
			<th scope="row">Button Text</th>
			<td><input type="text" name="TMD_Button_Text" id="TMD_Button_Text" value="<?php echo esc_attr( get_option('TMD_Button_Text') ); ?>" /></td>					
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>

<?php } ?>