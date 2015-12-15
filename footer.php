<?php global $post;

if( !empty( $post ) ) {
	$template = get_post_meta( $post->ID, '_wp_page_template', true );
}
if( ( !empty( $post ) AND ( substr_count( $template, 'template-bshSearchPage.php' ) == 0 OR ( substr_count( $template, 'template-bshSearchPage.php' ) >  0 AND get_post_meta( $post->ID, '_est_full_page_search', true ) == 'no' ) ) AND ( substr_count( $template, 'template-bshMapPage.php' ) == 0 OR ( substr_count( $template, 'template-bshMapPage.php' ) >  0 AND get_post_meta( $post->ID, '_est_full_page_map', true ) == 'no' ) ) ) OR empty( $post )) : ?>
<?php if( get_theme_mod( 'show_footer' ) !== 'no' ) : ?>
	<div id='siteFooter'>
		<div class='row'>
				<?php
				$sidebars = wp_get_sidebars_widgets();
				if( isset( $sidebars['footerbar'] ) ) {
					$widgets = count( $sidebars['footerbar'] );
					ob_start();
					dynamic_sidebar( 'Footerbar' );
					$footerbar = ob_get_clean();
					$footerbar = str_replace("\n", '|||', $footerbar);
					preg_match_all('/<div class="widget-container">(.*?)<div class="end"><\/div><\/div>/m', $footerbar, $matches);

					$elements = $matches[0];

					$count = count($elements);

					$widgets = array();
					$columns = array(
						1 => '12',
						2 => '6',
						3 => '4',
						4 => '3',
						6 => '2',
					);

					foreach( $elements as $element ) {
						$element = str_replace("|||", "\n", $element);
						$widgets[] = '<div class="small-12 large-' . $columns[$count] . ' columns">' . $element . '</div></div>';
					}

					$footerbar = implode( $widgets );
					echo $footerbar;
				}

				?>
		</div>
	</div>
<?php endif ?>
<?php if( get_theme_mod( 'show_footer_bar' ) !== 'no' ) : ?>

	<div id='footerBar'>
		<div class='row'>
			<div class='small-12 large-12 columns'>
				<div id='footerMenu'>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer_menu',
					'fallback_cb'    => 'bs_nav_menu'
				));
				?>
				</div>
				<div id='footerText'>
					<?php echo get_theme_mod( 'footer_bar_text' ) ?>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>
<?php endif ?>
<?php wp_footer() ?>
</body>
</html>