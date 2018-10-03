<?php

/**
 * @group ajax
 */
class FrmAjaxUnitTest extends WP_Ajax_UnitTestCase {

	protected $field_id = 0;
	protected $user_id = 0;
	protected $is_pro_active = false;
	protected $contact_form_key = 'contact-with-email';

	public static function setUpBeforeClass() {
		FrmHooksController::trigger_load_hook( 'load_admin_hooks' );
		FrmHooksController::trigger_load_hook( 'load_ajax_hooks' );
		FrmHooksController::trigger_load_hook( 'load_form_hooks' );

		parent::setUpBeforeClass();
		FrmAppController::install();
		self::import_xml();
	}

	public function setUp() {
		parent::setUp();
		$this->factory->form = new Form_Factory( $this );
		$this->factory->field = new Field_Factory( $this );
		$this->factory->entry = new Entry_Factory( $this );
	}

	public static function import_xml() {
		// install test data in older format
		add_filter( 'frm_default_templates_files', 'FrmUnitTest::install_data' );
		FrmXMLController::add_default_templates();

		$form = FrmForm::getOne( 'contact-db12' );
		self::assertEquals( $form->form_key, 'contact-db12' );

		$entry = FrmEntry::getOne( 'utah_entry' );
		self::assertNotEmpty( $entry );
		self::assertEquals( $entry->item_key, 'utah_entry' );
	}

    function set_as_user_role( $role ) {
        // create user
        $user_id = $this->factory->user->create( array( 'role' => $role ) );
		$user = new WP_User($user_id);
		$this->assertTrue( $user->exists(), 'Problem getting user ' . $user_id );

        // log in as user
        wp_set_current_user($user_id);
        $this->$user_id = $user_id;
		$this->assertTrue( current_user_can( $role ) );
    }

	function trigger_action( $action ) {
		$response = '';
		try {
			$this->_handleAjax( $action );
		} catch ( WPAjaxDieStopException $e ) {
			$response = $e->getMessage();
			unset( $e );
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}

		if ( '' === $response ) {
			$response = $this->_last_response;
		}

		return $response;
	}
}
