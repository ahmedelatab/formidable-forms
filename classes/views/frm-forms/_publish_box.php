<div id="submitdiv" class="postbox frm-no-border">
<div class="inside">
<div class="submitbox" id="submitpost">

<?php /* TODO: Move these to settings page
    <div id="minor-publishing">
        <div id="misc-publishing-actions">
            <div class="misc-pub-section">

            <?php if ( ! $values['is_template'] ) { ?>
            	<span id="frm_shortcode"><span class="frm-buttons-icon wp-media-buttons-icon"></span> <?php _e( 'Form', 'formidable' ) ?> <strong><?php _e( 'Shortcodes', 'formidable' ) ?></strong></span>
                <a href="#edit_frm_shortcode" class="edit-frm_shortcode hide-if-no-js" tabindex='4'><?php _e( 'Show', 'formidable' ) ?></a>
                <div id="frm_shortcodediv" class="hide-if-js">
                    <p class="howto"><?php _e( 'Insert on a page, post, or text widget', 'formidable' ) ?>:</p>
					<p><input type="text" readonly="readonly" class="frm_select_box" value="[formidable id=<?php echo esc_attr( $id ); ?>]" />
						<input type="text" readonly="readonly" class="frm_select_box" value="[formidable id=<?php echo esc_attr( $id ); ?> title=true description=true]" />
                	</p>

                	<p class="howto"><?php _e( 'Insert in a template', 'formidable' ) ?>:</p>
					<p><input type="text" readonly="readonly" class="frm_select_box frm_insert_in_template" value="&lt;?php echo FrmFormsController::get_form_shortcode( array( 'id' => <?php echo absint( $id ) ?>, 'title' => false, 'description' => false ) ); ?&gt;" /></p>

                    <p><a href="#edit_frm_shortcode" class="cancel-frm_shortcode hide-if-no-js"><?php _e( 'Hide', 'formidable' ); ?></a></p>
                </div>
            <?php } ?>
            </div>


            <div class="misc-pub-section misc-pub-post-status"><label for="post_status"><?php _e( 'Status', 'formidable' ) ?>:</label>
                <span id="form-status-display"><?php echo FrmFormsHelper::status_nice_name($values['status']); ?></span>
				<?php if ( 'draft' != $values['status'] && ( ! isset( $_GET['frm_action'] ) || 'settings' != FrmAppHelper::simple_get( 'frm_action', 'sanitize_title' ) ) ) { ?>
                <a href="#post_status" class="edit-form-status hide-if-no-js" data-slidedown="form-status-select"><span aria-hidden="true"><?php _e( 'Edit') ?></span> <span class="screen-reader-text"><?php _e( 'Edit status') ?></span></a>

                <div id="form-status-select" class="frm_hidden">
                    <select name="frm_change_status" id="form_change_status">
                        <option value="published" <?php selected($values['status'], 'published') ?>><?php _e( 'Published' ) ?></option>
                        <option value="draft" <?php selected($values['status'], 'draft') ?>><?php _e( 'Draft' ) ?></option>
                    </select>
                    <a href="#post_status" class="save-form-status hide-if-no-js button"><?php _e( 'OK') ?></a>
                    <a href="#post_status" class="cancel-form-status hide-if-no-js button-cancel" data-slideup="form-status-select"><?php _e( 'Cancel') ?></a>
                </div>
                <?php } ?>
            </div><!-- .misc-pub-section -->

            <?php if ( has_action('frm_settings_buttons') ) { ?>
            <div class="misc-pub-section">
                <?php do_action('frm_settings_buttons', $values); ?>
                <div class="clear"></div>
            </div>
            <?php } ?>

        </div><!-- #misc-publishing-actions -->
        <div class="clear"></div>
    </div><!-- #minor-publishing -->
*/ ?>
    <div id="major-publishing-actions">
		<div class="alignleft">
			<?php FrmFormsHelper::actions_dropdown( $values ) ?>
		</div>

		<div id="publishing-action">
			<?php if ( 'draft' == $values['status'] ) { ?>
				<button class="frm_submit_form frm_submit_<?php echo ( isset( $values['ajax_load'] ) && $values['ajax_load'] ) ? '' : 'no_'; ?>ajax button-primary frm_button_submit" type="button" id="save-post" ><?php esc_html_e( 'Save Draft', 'formidable' ); ?></button>
			<?php } ?>
			<?php if ( 'settings' == FrmAppHelper::simple_get( 'frm_action', 'sanitize_title' ) ) { ?>
				<button class="frm_submit_form frm_submit_settings_btn button-primary frm_button_submit" type="button" id="frm_submit_side_top" >
					<?php esc_html_e( 'Update', 'formidable' ); ?>
				</button>
            <?php } else { ?>
				<button class="frm_submit_form frm_submit_<?php echo ( isset( $values['ajax_load'] ) && $values['ajax_load'] ) ? '' : 'no_'; ?>ajax button-primary frm_button_submit" type="button" id="frm_submit_side_top" >
					<?php echo isset( $button ) ? esc_attr( $button ) : __( 'Update', 'formidable' ); ?>
				</button>
    	    <?php } ?>
            <div id="preview-action">
				<?php if ( ! isset( $hide_preview ) || ! $hide_preview ) {

					if ( isset( $values['form_key'] ) ) {
						$frm_settings = FrmAppHelper::get_settings();
						if ( empty( $frm_settings->preview_page_id ) ) { ?>
							<a href="<?php echo esc_url( FrmFormsHelper::get_direct_link( $values['form_key'] ) ); ?>" class="preview button" target="wp-frm-preview-<?php echo esc_attr( $id ) ?>"><?php _e( 'Preview', 'formidable' ) ?></a>
				<?php } else { ?>
					<div class="preview dropdown">
						<a href="#" id="frm-previewDrop" class="frm-dropdown-toggle button" data-toggle="dropdown"><?php _e( 'Preview', 'formidable' ) ?> <b class="caret"></b></a>

						<ul class="frm-dropdown-menu pull-right" role="menu" aria-labelledby="frm-previewDrop">
							<li><a href="<?php echo esc_url( FrmFormsHelper::get_direct_link( $values['form_key'] ) ); ?>" target="_blank"><?php _e( 'On Blank Page', 'formidable' ) ?></a></li>
							<li><a href="<?php echo esc_url( add_query_arg('form', $values['form_key'], get_permalink( $frm_settings->preview_page_id ) ) ) ?>" target="_blank"><?php _e( 'In Theme', 'formidable' ) ?></a></li>
						</ul>
					</div>
				<?php   }
					}
				} ?>
			</div>
		</div>

		<div class="clear"></div>
	</div><!-- #major-publishing-actions -->

</div>
</div>
</div>
