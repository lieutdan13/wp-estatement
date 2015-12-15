<div class="wrap nosubsub">
<div id='est_header'>
<div id="est_custom_fields_page_icon" class="icon32 icon32-posts-property"><br></div><h2><?php _e( 'Manage Custom Data', THEMENAME ) ?></h2>
</div>

<?php
    //Create an instance of our package class...
    $testListTable = new EST_Customtaxonomy_Table();
    //Fetch, prepare, sort, and filter our data...
    $testListTable->prepare_items();

    ?>

        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="movies-filter" method="get">

	        <?php if( !empty( $_GET['action'] ) AND $_GET['action'] == 'delete' ) : ?>
	        	<div class='est_success full'>
	        		<?php _e( 'The selected taxonomies have been deleted successfully', THEMENAME ) ?>
	        	</div>
	        <?php endif ?>

	        <?php if( !empty( $_GET['est_success'] ) AND $_GET['est_success'] == 'delete' ) : ?>
	        	<div class='est_success full'>
	        		<?php _e( 'The selected taxonomy has been deleted successfully', THEMENAME ) ?>
	        	</div>
	        <?php endif ?>


            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $testListTable->display() ?>
        </form>

    </div>



</div>
