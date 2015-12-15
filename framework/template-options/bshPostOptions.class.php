<?php
/***********************************************/
/*               About This File               */
/***********************************************/
/*
	This file generates the options needed for
	the post template.
*/

/***********************************************/
/*              Table of Contents              */
/***********************************************/
/*

	1. Post Options Class
		1.1 Constructor
		1.2 Options Box Content

	2. Instantiating The Options

*/

/***********************************************/
/*       1. Post Options Class         */
/***********************************************/

class bshPostOptions extends bshOptions {

	// 1.1 Constructor
	function __construct() {
		$args = array(
			'title'     => __( 'Post Options', THEMENAME ),
			'post_type' => 'post',
			'template'  => 'post',
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
        						<?php echo sprintf( __( 'By default the layout of this post is inherited from the default layout which can be changed in the <a href="%s">Theme Customizer</a>. If you need a different layout for this post, you can override the default setting.', THEMENAME ), esc_url( admin_url( 'customize.php' ) ) ) ?>
        						</div>
        					</div>

	        				<label for='bsh_layout' class='sectionTitle'><?php _e( 'Layout', THEMENAME ) ?></label>
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
        						<?php _e( 'By default the metadata (post date, comment count, etc.) is shown on posts. If you don\'t need it, you can turn it off for this post here.', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_metadata' class='sectionTitle'><?php _e( 'Post Metadata', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Show' => 'show',
	        						'Hide' => 'hide',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_metadata', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'show' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_metadata-<?php echo $i ?>' name='_est_metadata' value='<?php echo $value ?>'><label for='_est_metadata-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php echo sprintf( __( 'If you are using a layout with a sidebar the default sidebar will be shown. You can set the default sidebar in the <a href="%s">Theme Customizer</a>. If you would like to use a different sidebar on this post, choose one here.', THEMENAME ), esc_url( admin_url( 'customize.php' ) ) ) ?>
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

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the slider (if any) to use on the page', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$slider = get_post_meta( $post->ID, '_est_slider', true );
        						$slider_shortcode = get_post_meta( $post->ID, '_est_slider_shortcode', true );

        						$checked_default = ( empty( $slider ) OR $slider == 'default' ) ? 'checked="checked"' : '';
        						$checked_specify = ( !empty( $slider ) AND $slider == 'specify' ) ? 'checked="checked"' : '';

        					?>
	        				<label for='_est_slider' class='sectionTitle'><?php _e( 'Slider To Use', THEMENAME ) ?></label>

	        				<p>
	        				<input id='_est_slider_0' <?php echo $checked_default ?> type='radio' name='_est_slider' value='default'> <label for='_est_slider_0'><?php _e( 'Use Default Slider', THEMENAME ) ?></label><br>
	        				<input id='_est_slider_1' <?php echo $checked_specify ?> type='radio' name='_est_slider' value='specify'> <label for='_est_slider_1'><?php _e( 'Specify Slider:', THEMENAME ) ?></label><br>
	        				</p>
		        			<input type='text' class='widefat' id='_est_slider_shortcode' name='_est_slider_shortcode' value='<?php echo $slider_shortcode ?>'></p>
	        			</div>

	        		</section>
	        		<section class='helpSection'>
	        			<?php
	        			_e('
	        				<p>
	        					Posts allow you to create simple blog-like content. They are shown on the main page by default and can be categorized and tagged for better organization. Musico offers a few special options for posts in addition to the numerous shortcodes which will help you format your content.
	        				</p>

							<ul>
								<li>
								Structure
							<ul>
								<li><strong>Layout</strong>: By default the layout of this post is inherited from the default layout which can be changed in the Theme Customizer. If you need a different layout for this post, you can override the default setting.
								</li>
								<li><strong>Post Metadata</strong>: By default posts show meta information like author, tag, categories and so on. If you would not like to show this information for this post, you can enable it with this setting.</li>
								<li><strong>Sidebar</strong>: If you are using a layout with a sidebar the default sidebar will be shown. You can set the default sidebar in the Theme Customizer. If you would like to use a different sidebar on this post, choose one here.
								</li>

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
    add_action( 'load-post.php', 'call_bshPostOptions' );
    add_action( 'load-post-new.php', 'call_bshPostOptions' );
}
function call_bshPostOptions() {
	global $bshPostOptions;
	if( $bshPostOptions->get_page_template() == 'post' ) {
    	return new bshPostOptions();
    }

}




?>