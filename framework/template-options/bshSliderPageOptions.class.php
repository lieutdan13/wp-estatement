<?php
/***********************************************/
/*               About This File               */
/***********************************************/
/*
	This file generates the options needed for
	the default page template.
*/

/***********************************************/
/*              Table of Contents              */
/***********************************************/
/*

	1. Default Page Options Class
		1.1 Constructor
		1.2 Options Box Content

	2. Instantiating The Options

*/

/***********************************************/
/*       1. Default Page Options Class         */
/***********************************************/

class bshSliderPageOptions extends bshOptions {

	// 1.1 Constructor
	function __construct() {
		$args = array(
			'title'     => __( 'Page Options', THEMENAME ),
			'post_type' => 'page',
			'template'  => 'template-bshSliderPage.php',
			'context'   => 'normal',
			'priority'  => 'high'
		);
        parent::__construct( $args );
        $this->setup_options();
	}

	// 1.2 Options Box Content
    public function options_box_content( $post ) {
        ?>
        	<div id='bshLogo'></div>
        	<div id='optionsContainer'>
        		<div id='menuBackground'></div>

	        	<ul id='bshMenu'>
	        		<li class='active'><?php _e( 'Structure', THEMENAME ) ?></li>
	        		<li><?php _e( 'Help', THEMENAME) ?></l1>
	        		<li><?php _e( 'Shortcode Guide', THEMENAME) ?></l1>
	        		<li><?php _e( 'Get Support', THEMENAME) ?></l1>
	        	</ul>
	        	<div id='bshOptions'>
		        	<input id='bshSaveTop' name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="Update">

	        		<section class='active'>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Use a slider shortcode to output a slider at the top of the page'  ) ?>
        						</div>
        					</div>

	        				<label for='_est_slider' class='sectionTitle'><?php _e( 'Slider Shortcode', THEMENAME ) ?></label>
							<?php $value = get_post_meta( $post->ID, '_est_slider', true ) ?>
							<textarea class='widefat' rows='8' name='_est_slider' id='_est_slider'><?php echo $value ?></textarea>

	        			</div>



	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php echo sprintf( __( 'By default the layout of this page is inherited from the default layout which can be changed in the <a href="%s">Theme Customizer</a>. If you need a different layout on this page, you can override the default setting.', THEMENAME ), esc_url( admin_url( 'customize.php' ) ) ) ?>
        						</div>
        					</div>

	        				<label for='_est_layout' class='sectionTitle'><?php _e( 'Layout', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Global Setting' => 'default',
	        						'2 Columns - Sidebar on the Right' => '2col_right',
	        						'2 Columns - Sidebar on the Left'  => '2col_left',
	        						'1 Column' => '1col'
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID,  '_est_layout', true );

		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'default' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_layout-<?php echo $i ?>' name='_est_layout' value='<?php echo $value ?>'><label for='_est_layout-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'By default the title of this page is shown under the header. If you would like to hide this title, check the radio button next to  "Hide"', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_title' class='sectionTitle'><?php _e( 'Page Title', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Show' => 'show',
	        						'Hide' => 'hide',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_title', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'show' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_title-<?php echo $i ?>' name='_est_title' value='<?php echo $value ?>'><label for='_est_title-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php echo sprintf( __( 'If you are using a layout with a sidebar the default sidebar will be shown. You can set the default sidebar in the <a href="%s">Theme Customizer</a>. If you would like to use a different sidebar on this page, choose one here.', THEMENAME ), esc_url( admin_url( 'customize.php' ) ) ) ?>
        						</div>
        					</div>

	        				<label for='_est_sidebar' class='sectionTitle'><?php _e( 'Sidebar', THEMENAME ) ?></label>

	        				<?php
		        				$current = get_post_meta( $post->ID,  '_est_sidebar', true );
								$choices = explode(',', get_theme_mod( 'sidebars' ) );
								$sidebars['default'] = 'Default';
								$sidebars['Sidebar'] = 'Sidebar';
								foreach( $choices as $choice ) {
									$choice = trim( $choice );
									if( !empty( $choice ) ) {
										$sidebars[$choice] = $choice;
									}
								}
	        					$current = get_post_meta( $post->ID, '_est_sidebar', true );
	        				?>
	        				<select id='_est_sidebar' name='_est_sidebar'>
		        				<?php
		        					foreach( $sidebars as $value => $name ) :
		        					$selected = ( $current == $value OR ( empty( $current ) AND $value == 'default' ) ) ? 'selected="selected"' : '';
		        				?>
		        				<option value='<?php echo $value ?>' <?php echo $selected ?>>
		        				<?php echo $name ?>
		        				</option>
		        				<?php endforeach ?>
	        				</select>
	        			</div>

	        		</section>
	        		<section class='helpSection'>
	        			<?php
	        			_e('
	        				<p>Pages are a way to add static content to your website. They are perfect for about pages, staff pages and so on. Apart from the numerous shortcodes we offer for customizing the content in a post there are also some settings for this page specifically: </p>

							<ul>
							<li>Structure
							<ul>
							<li><span style="line-height: 13px;"><strong>Layout</strong>: Determines the type of layout you would like for this specific page</span></li>
							<li><strong>Page Title</strong>: Allows you to show or hide the page title</li>
							<li><strong>Sidebar</strong>: Allows you to show a specific sidebar for this page</li>
							</ul>
							</li>
	        			</ul>

	        			', THEMENAME );
	        			?>
	        		</section>
	        		<section class='helpSection'>
	        			<?php echo bsh_docs_shortcodes() ?>
		        	</section>
		        	<section class='helpSection'>
			        	<?php echo bsh_docs_get_support() ?>
			   		</section>

	        	</div>
	        	<div class='clear'></div>
	        </div>

        <?php
    }


}


/***********************************************/
/*       2. Instantiating The Options          */
/***********************************************/

if ( is_admin() ) {
    add_action( 'load-post.php', 'call_bshSliderPageOptions' );
    add_action( 'load-post-new.php', 'call_bshSliderPageOptions' );
}
function call_bshSliderPageOptions() {
	global $bshPostOptions;
	if( $bshPostOptions->get_page_template() == 'template-bshSliderPage.php' ) {
    	return new bshSliderPageOptions();
    }

}




?>