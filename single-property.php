<?php
	get_header();
	while( have_posts() ) : the_post();
?>

<div class='row mt44'>
	<div class='large-12 small-12 columns'>
		<div id='siteContent'>

			<div class='row'>

				<?php if( bsh_show_title() ) : ?>
					<div class='columns large-12 small-12 mb22'>
                                        <?php if ( property_has_taxonomy_type( 0, 'type', array( 'apartment-building', 'apartment-floorplan', 'apartment-complex' ) ) ) {
                                                show_breadcrumb();
                                        } else { ?>
						<div class="page-title">
							<?php echo do_shortcode( '[title icon="none"]' . the_title( '', '', false ) . '[/title]' ); ?>
						</div>
                                        <?php } ?>
					</div>
				<?php endif ?>

				<?php
					$show_print = get_theme_mod( 'show_print' );
					if( !empty( $show_print ) AND $show_print == 'yes' ) :
				?>
				<div id='propertyPrintButton'>
				<?php
				$print_button = get_theme_mod( 'print_icon' );
				$print_button = ( empty( $print_button ) ) ? 'http://cdn.printfriendly.com/button-print-gry20.png' : $print_button;
				?>
				<script>var pfHeaderImgUrl = '';var pfHeaderTagline = '';var pfdisableClickToDel = 0;var pfHideImages = 0;var pfImageDisplayStyle = 'block';var pfDisablePDF = 0;var pfDisableEmail = 0;var pfDisablePrint = 0;var pfCustomCSS = '';var pfBtVersion='1';(function(){var js, pf;pf = document.createElement('script');pf.type = 'text/javascript';if('https:' == document.location.protocol){js='https://pf-cdn.printfriendly.com/ssl/main.js'}else{js='http://cdn.printfriendly.com/printfriendly.js'}pf.src=js;document.getElementsByTagName('head')[0].appendChild(pf)})();</script><a href="http://www.printfriendly.com" style="color:#6D9F00;text-decoration:none;" class="printfriendly" onclick="window.print();return false;" title="Printer Friendly and PDF"><img style="border:none;" src="<?php echo $print_button ?>" alt="Print Friendly and PDF"/></a>
				</div>
				<?php endif ?>



				<div id='siteMain' class='<?php echo bsh_content_classes() ?> columns'>
					<?php get_template_part( 'layout-property' ) ?>
				</div>

				<div id='siteSidebar' class='small-12 large-4 columns <?php echo bsh_sidebar_classes() ?>'>
					<?php dynamic_sidebar( bsh_get_sidebar() ) ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php endwhile;	 ?>

<?php get_footer() ?>