<?php
/**
 * @file
 *
 * Autoloader file
 */

/**
 * Autoloader
 *
 * @param   string $class   Loaded class
 *
 * @return  boolean
 */
function sup_plugin_autoloader( $class ) {
	$dir  = '/inc';
	$type = 'class';

	switch ( $class ) {
		case false !== strpos( $class, 'SergioUpworkTest\\Traits\\' ):
										$class = strtolower( str_replace( 'SergioUpworkTest\\Traits', '', $class ) );
										$dir  .= '/traits';
										$type  = 'trait';
			break;
		case false !== strpos( $class, 'SergioUpworkTest\\Core\\' ):
										$class = strtolower( str_replace( 'SergioUpworkTest\\Core', '', $class ) );
										$dir  .= '/core';
			break;
		case false !== strpos( $class, 'SergioUpworkTest\\' ):
										$class = strtolower( str_replace( 'SergioUpworkTest', '', $class ) );
			break;
		default:
			return;
	}

	$filename = SUT_PLUGIN_DIR . $dir . str_replace( '_', '-', str_replace( '\\', '/' . $type . '-', $class ) ) . '.php';

	if ( file_exists( $filename ) ) {
		require_once $filename;

		if ( class_exists( $class ) ) {
			return true;
		}
	}

	return false;
}

spl_autoload_register( 'sup_plugin_autoloader' );
