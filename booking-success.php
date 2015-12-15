<div class='row mt44'>
	<div class='large-9 small-12 columns centered small-centered'>

		<div class='box mt22'>
			<header class='thank-you'>
				<div class='counter'><?php echo get_post_meta( get_the_ID(), '_est_thankyou_flag', true) ?></div>
				<h1><?php echo get_post_meta( get_the_ID(), '_est_thankyou_title', true) ?></h1>
			</header>
			<article>
				<div class='row'>
					<div class='small-12 large-12 columns'>
						<?php echo wpautop( get_post_meta( get_the_ID(), '_est_thankyou_text', true ) ) ?>
					</div>
				</div>

			</article>
		</div>

	</div>
</div>
