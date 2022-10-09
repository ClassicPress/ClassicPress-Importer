<?php
/*
 * @classicpress-plugin
 * Plugin Name:       ClassicPress Importer
 * Plugin URI:        https://wordpress.org/plugins/wordpress-importer/
 * Description:       Import posts, pages, comments, custom fields, categories, tags and more from either a ClassicPress or WordPress export file.
 * Author:            ClassicPress
 * Author URI:        https://www.classicpress.net/
 * Version:           0.1
 * Requires at least: 5.2
 * Requires PHP:      5.6
 * Text Domain:       classicpress-importer
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
	return;
}

/** Display verbose errors */
if ( ! defined( 'IMPORT_DEBUG' ) ) {
	define( 'IMPORT_DEBUG', WP_DEBUG );
}

/** ClassicPress Import Administration API */
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'CP_Importer' ) ) {
	$class_cp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_cp_importer ) ) {
		require $class_cp_importer;
	}
}

/** Functions missing in older ClassicPress versions. */
require_once dirname( __FILE__ ) . '/compat.php';

/** WXR_Parser class */
require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser.php';

/** WXR_Parser_SimpleXML class */
require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-simplexml.php';

/** WXR_Parser_XML class */
require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-xml.php';

/** WXR_Parser_Regex class */
require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-regex.php';

/** CP_Import class */
require_once dirname( __FILE__ ) . '/class-cp-import.php';

function classicpress_importer_init() {
	load_plugin_textdomain( 'classicpress-importer' );

	/**
	 * ClassicPress Importer object for registering the import callback
	 * @global CP_Import $cp_import
	 */
	$GLOBALS['cp_import'] = new CP_Import();
	// phpcs:ignore WordPress.WP.CapitalPDangit
	register_importer( 'classicPress', 'ClassicPress', __( 'Import <strong>posts, pages, comments, custom fields, categories, and tags</strong> from either a ClassicPress or WordPress export file.', 'classicpress-importer' ), array( $GLOBALS['cp_import'], 'dispatch' ) );
}
add_action( 'admin_init', 'classicpress_importer_init' );
