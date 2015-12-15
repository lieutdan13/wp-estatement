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

class bshAgentListPageOptions extends bshOptions {

	// 1.1 Constructor
	function __construct() {
		$args = array(
			'title'     => __( 'Agent List Options', THEMENAME ),
			'post_type' => 'page',
			'template'  => 'template-bshAgentListPage.php',
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
	        		<li><?php _e( 'Agent List Options', THEMENAME) ?></l1>
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
	        		<section>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Select if you want to show agents even if they don\'t have properties assigned to them.', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_show_agents_without_properties' class='sectionTitle'><?php _e( 'Show Agents Without Properties?', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Show' => 'show',
	        						'Hide' => 'hide',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_show_agents_without_properties', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'hide' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_show_agents_without_properties-<?php echo $i ?>' name='_est_show_agents_without_properties' value='<?php echo $value ?>'><label for='_est_show_agents_without_properties-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>



	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'By default a list of properties is shown next to each agent. Select "no" to disable this', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_show_properties' class='sectionTitle'><?php _e( 'Show Agents\' Properties', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Show' => 'show',
	        						'Hide' => 'hide',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_show_properties', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'show' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_show_properties-<?php echo $i ?>' name='_est_show_properties' value='<?php echo $value ?>'><label for='_est_show_properties-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'If you don\'t want users to be able to click through to the single agent page from the list, make sure to set this to yes', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_agent_links' class='sectionTitle'><?php _e( 'Link to Agent Pages', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Yes' => 'yes',
	        						'No' => 'no',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_agent_links', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'yes' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_agent_links-<?php echo $i ?>' name='_est_agent_links' value='<?php echo $value ?>'><label for='_est_agent_links-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Show or hide the agent\'s phone number', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_show_agent_phone' class='sectionTitle'><?php _e( 'Show agent phone', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Yes' => 'yes',
	        						'No' => 'no',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_show_agent_phone', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'yes' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_show_agent_phone-<?php echo $i ?>' name='_est_show_agent_phone' value='<?php echo $value ?>'><label for='_est_show_agent_phone-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Show or hide the agent\'s email address', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_show_agent_email' class='sectionTitle'><?php _e( 'Show agent email', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Yes' => 'yes',
	        						'No' => 'no',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_show_agent_email', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'yes' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_show_agent_email-<?php echo $i ?>' name='_est_show_agent_email' value='<?php echo $value ?>'><label for='_est_show_agent_email-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>



	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'You can make sure admins are not shown as agents by setting this option to hide', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_show_admins' class='sectionTitle'><?php _e( 'Show Admins', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Show' => 'show',
	        						'Hide' => 'hide',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_show_admins', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'show' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_show_admins-<?php echo $i ?>' name='_est_show_admins' value='<?php echo $value ?>'><label for='_est_show_admins-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>

						<?php $value = get_post_meta( $post->ID, '_est_include_users', true ) ?>
	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Using this text field you can specify the users you would like to show by adding their IDs separated with commas.', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_include_users' class='sectionTitle'><?php _e( 'Users To Show', THEMENAME ) ?></label>
		        				<input type='text' id='_est_include_users' name='_est_include_users' value='<?php echo $value ?>'>
	        			</div>




	        		</section>

	        		<section class='helpSection'>
	        			<?php
	        			_e('

							<p>The agent list template allows you to create a list of agents with their contact info and apartments shown. </p>
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
    add_action( 'load-post.php', 'call_bshAgentListPageOptions' );
    add_action( 'load-post-new.php', 'call_bshAgentListPageOptions' );
}
function call_bshAgentListPageOptions() {
	global $bshPostOptions;
	if( $bshPostOptions->get_page_template() == 'default' OR $bshPostOptions->get_page_template() == 'template-bshAgentListPage.php' ) {
    	return new bshAgentListPageOptions();
    }

}




?>