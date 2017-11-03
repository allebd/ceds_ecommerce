<?php
/**
 * Welcome Screen Class
 * Sets up the welcome screen page, hides the menu item
 * and contains the screen content.
 */
class lithestore_Welcome {

	/**
	 * Constructor
	 * Sets up the welcome screen
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'lithestore_welcome_register_menu' ) );
		add_action( 'load-themes.php', array( $this, 'lithestore_activation_admin_notice' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'lithestore_welcome_style' ) );

		add_action( 'lithestore_welcome', array( $this, 'lithestore_welcome_intro' ), 				10 );

	} // end constructor

	/**
	 * Adds an admin notice upon successful activation.
	 * @since 1.0.3
	 */
	public function lithestore_activation_admin_notice() {
		global $pagenow;

		if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) { // input var okay
			add_action( 'admin_notices', array( $this, 'lithestore_welcome_admin_notice' ), 99 );
		}
	}

	/**
	 * Display an admin notice linking to the welcome screen
	 * @since 1.0.3
	 */
	public function lithestore_welcome_admin_notice() {
		?>
			<div class="updated notice is-dismissible">
				<p><?php echo sprintf( esc_html__( 'Thanks for choosing LitheStore! Just click the following button to get more useful tips on getting started step by step.', 'lithestore' ), '<a href="' . esc_url( admin_url( 'themes.php?page=lithestore-welcome' ) ) . '">', '</a>' ); ?></p>
				<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=lithestore-welcome' ) ); ?>" class="button" style="text-decoration: none;"><?php _e( 'Get started with LitheStore', 'lithestore' ); ?></a></p>
			</div>
		<?php
	}

	/**
	 * Load welcome screen css
	 * @return void
	 * @since  1.4.4
	 */
	public function lithestore_welcome_style( $hook_suffix ) {
		global $lithestore_version;

		if ( 'appearance_page_lithestore-welcome' == $hook_suffix ) {
			wp_enqueue_style( 'lithestore-welcome', get_template_directory_uri() . '/framework/functions/welcome/css/welcome.css', $lithestore_version );
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_script( 'thickbox' );
		}
	}

	/**
	 * Creates the dashboard page
	 * @see  add_theme_page()
	 * @since 1.0.0
	 */
	public function lithestore_welcome_register_menu() {
		add_theme_page( 'LitheStore', 'LitheStore', 'activate_plugins', 'lithestore-welcome', array( $this, 'lithestore_welcome_screen' ) );
	}

	/**
	 * The welcome screen
	 * @since 1.0.0
	 */
	public function lithestore_welcome_screen() {
		?>
		<div class="wrap about-wrap">

			<?php
			/**
			 * @hooked lithestore_welcome_intro - 10
			 */
			do_action( 'lithestore_welcome' ); ?>

		</div>
		<?php
	}

	/**
	 * Welcome screen intro
	 * @since 1.0.0
	 */
	public function lithestore_welcome_intro() {
		require_once( get_template_directory() . '/framework/functions/welcome/content/intro.php' );
	}

}

$GLOBALS['lithestore_Welcome'] = new lithestore_Welcome();
