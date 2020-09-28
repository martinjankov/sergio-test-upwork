<?php
/**
 * @file
 *
 * Post related methods
 */

namespace SergioUpworkTest;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post class
 */
class Post {
	use \SergioUpworkTest\Traits\Singleton;

	/**
	 * Invoked in Singleton trait private constructor
	 *
	 * @return  void
	 */
	private function _initialize() {
		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ), 20 );
	}

	/**
	 * Load assets
	 *
	 * @return  void
	 */
	public function load_assets() {
		if ( ! is_singular( 'post' ) || get_the_ID() !== $this->get_latest_post_id() ) {
			return;
		}

		wp_enqueue_script(
			'sut-post-script',
			SUT_PLUGIN_URL . 'assets/public/js/script.js',
			array( 'jquery' ),
			SUT_VERSION,
			true
		);
	}

	/**
	 * Get latest post id
	 *
	 * @return  mixed<null|int>  if no posts returns null
	 */
	public function get_latest_post_id() {
		$key = 'sut_latest_post_id';

		$post_id = wp_cache_get( $key );

		if ( $post_id ) {
			return $post_id;
		}

		$latest_post = get_posts(
			array(
				'numberposts' => 1,
				'fields'      => 'ids',
			)
		);

		$post_id = null;

		if ( ! empty( $latest_post ) ) {
			$post_id = $latest_post[0];
		}

		wp_cache_set( $key, $post_id, 'sut' );

		return $post_id;
	}
}
