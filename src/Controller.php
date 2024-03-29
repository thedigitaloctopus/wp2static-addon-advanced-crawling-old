<?php

namespace WP2StaticAdvancedCrawling;

class Controller {
    const VERSION = '0.1';
    const PLUGIN_NAME = 'wp2static-addon-advanced-crawling';
    const OPTIONS_KEY = 'wp2static-addon-advanced-crawling-options';
    const HOOK = 'wp2static-addon-advanced-crawling';

	public function __construct() {

	}

	public function run() {
        // initialize options DB
        global $wpdb;

        $table_name = $wpdb->prefix . 'wp2static_addon_advanced_crawling_options';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            value VARCHAR(255) NOT NULL,
            label VARCHAR(255) NULL,
            description VARCHAR(255) NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );

        // check for seed data
        // if deployment_url option doesn't exist, create:
        $options = $this->getOptions();

        if ( ! isset( $options['crawlPort'] ) ) {
            $this->seedOptions();
        }

        add_filter(
            'wp2static_render_options_page_vars',
            [ $this, 'addOptionsTemplateVars' ],
            15,
            1);

        add_filter(
            'wp2static_add_ui_admin_notices',
            [ $this, 'addAdminNotices' ],
            15,
            1);

        add_action(
            'wp2static_addon_ui_save_options',
            [ $this, 'uiSaveOptions' ],
            15,
            1);

        if ( defined( 'WP_CLI' ) ) {
            \WP_CLI::add_command(
                'wp2static advanced_detection',
                [ 'WP2StaticAdvancedCrawling\CLI', 'advanced_detection' ]);
        }
	}

    public function addAdminNotices( $notices ) {
        $notices['errors'][] = 'added an error notice via zip plugin';

        return $notices;
    }

    /**
     *  Get all add-on options
     *
     *  @return mixed[] All options
     */
    public function getOptions() : array {
        global $wpdb;
        $options = [];

        $table_name = $wpdb->prefix . 'wp2static_addon_advanced_crawling_options';

        $rows = $wpdb->get_results( "SELECT * FROM $table_name" );

        foreach($rows as $row) {
            $options[$row->name] = $row;
        }

        return $options;
    }

    /**
     * Seed options
     *
     */
    public static function seedOptions() : void {
        global $wpdb;

        $table_name = $wpdb->prefix . 'wp2static_addon_advanced_crawling_options';

        // TODO: plop in here old advanced crawling options from core
        /*
            crawlPort
            crawlDelay
            crawlUserAgent
            dontUseCrawlCaching
        */

        $query_string = "INSERT INTO $table_name (name, value, label, description) VALUES (%s, %s, %s, %s);";
        $query = $wpdb->prepare(
            $query_string,
            'crawlPort',
            '',
            'Crawl Port',
            'Set port when not using protocol default');

        $wpdb->query( $query );

        $query_string = "INSERT INTO $table_name (name, value, label, description) VALUES (%s, %s, %s, %s);";
        $query = $wpdb->prepare(
            $query_string,
            'crawlDelay',
            '',
            'Crawl Delay',
            'Ease server load by delaying by n seconds between URL crawls');

        $wpdb->query( $query );

        $query_string = "INSERT INTO $table_name (name, value, label, description) VALUES (%s, %s, %s, %s);";
        $query = $wpdb->prepare(
            $query_string,
            'crawlUserAgent',
            'WP2Static.com',
            'User Agent',
            'Override default user agent (WP2Static.com)');

        $wpdb->query( $query );

        $query_string = "INSERT INTO $table_name (name, value, label, description) VALUES (%s, %s, %s, %s);";
        $query = $wpdb->prepare(
            $query_string,
            'dontUseCrawlCaching',
            '',
            'Disable Crawl Caching',
            'Crawl all detected URLs each time (slower)');

        $wpdb->query( $query );
    }

    /**
     * Save options
     *
     */
    public static function saveOption( $name, $value ) : void {
        global $wpdb;

        $table_name = $wpdb->prefix . 'wp2static_addon_advanced_crawling_options';

        $query_string = "INSERT INTO $table_name (name, value) VALUES (%s, %s);";
        $query = $wpdb->prepare( $query_string, $name, $value );

        $wpdb->query( $query );
    }

    public function addOptionsTemplateVars( $template_vars ) {
        $template_vars['wp2static_advanced_crawling_addon_options'] = $this->getOptions();

        // find position of crawling options
        $deployment_options_position = 0;
        foreach( $template_vars['options_templates'] as $index => $options_template ) {
          if (strpos($options_template, 'core-crawling-options.php') !== false) {
            $deployment_options_position = $index + 1;
          } 
        } 

        // insert zip deploy options template after that
        array_splice(
            $template_vars['options_templates'],
            $deployment_options_position,
            0, // # elements to remove
            [__DIR__ . '/../views/crawling-options.php']
        );

        return $template_vars;
    }

    public function uiSaveOptions() {
        error_log('Advanced Crawling Addon Saving Options, accessing $_POST');

        if (isset($_POST['deployment_url'])) {
            // TODO: validate URL
            $this->saveOption( 'deployment_url', $_POST['deployment_url'] );
        }
    }

    /*
     * Naive encypting/decrypting
     *
     */
    public static function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";

        $secret_key =
            defined( 'AUTH_KEY' ) ?
            constant( 'AUTH_KEY' ) :
            'LC>_cVZv34+W.P&_8d|ejfr]d31h)J?z5n(LB6iY=;P@?5/qzJSyB3qctr,.D$[L';

        $secret_iv =
            defined( 'AUTH_SALT' ) ?
            constant( 'AUTH_SALT' ) :
            'ec64SSHB{8|AA_ThIIlm:PD(Z!qga!/Dwll 4|i.?UkC§NNO}z?{Qr/q.KpH55K9';

        $key = hash('sha256', $secret_key);
        $variate = substr(hash('sha256', $secret_iv), 0, 16);

        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $variate);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $variate);
        }

        return $output;
    }

    public static function setDefaultOptions() : void {
        $encrypted_options =
            self::encrypt_decrypt('encrypt', 'someoptionsforzipaddon');

        update_option(self::OPTIONS_KEY, $encrypted_options);
    }

    public static function activate_for_single_site() : void {
        self::setDefaultOptions();
    }

    public static function deactivate_for_single_site() : void {
        error_log('deactivating zip addon, maintaining options');
        //delete_option(self::OPTIONS_KEY);
    }

    public static function deactivate( bool $network_wide = null ) : void {
        error_log('deactivating zip addon 2');
        if ( $network_wide ) {
            global $wpdb;

            $query = 'SELECT blog_id FROM %s WHERE site_id = %d;';

            $site_ids = $wpdb->get_col(
                sprintf(
                    $query,
                    $wpdb->blogs,
                    $wpdb->siteid
                )
            );

            foreach ( $site_ids as $site_id ) {
                switch_to_blog( $site_id );
                self::deactivate_for_single_site();
            }

            restore_current_blog();
        } else {
            self::deactivate_for_single_site();
        }
    }

    public static function activate( bool $network_wide = null ) : void {
        error_log('activating zip addon 2');
        if ( $network_wide ) {
            global $wpdb;

            $query = 'SELECT blog_id FROM %s WHERE site_id = %d;';

            $site_ids = $wpdb->get_col(
                sprintf(
                    $query,
                    $wpdb->blogs,
                    $wpdb->siteid
                )
            );

            foreach ( $site_ids as $site_id ) {
                switch_to_blog( $site_id );
                self::activate_for_single_site();
            }

            restore_current_blog();
        } else {
            self::activate_for_single_site();
        }
    }
}
