<?php

class ANONY_WC_Settings_Tab {

    /*
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_oprics_settings', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_oprics_settings', __CLASS__ . '::update_settings' );
    }
    
    
    /*
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['oprics_settings'] = 'Oprics settings';
        return $settings_tabs;
    }


    /*
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }


    /*
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }


    /*
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function get_settings() {

        $settings = array(
            'texts' => array(
                'name'     => 'Texts',
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_oprics_settings_texts'
            ),
            'Sph' => array(
                'name' => 'Power',
                'type' => 'text',
                'id'   => 'wc_oprics_settings_Sph',
                'default' => 'Power'
            ),
            
            'Cyl' => array(
                'name' => 'Cylinder',
                'type' => 'text',
                'id'   => 'wc_oprics_settings_Cyl',
                'default' => 'Cylinder'
            ), 
            
            'Axis' => array(
                'name' => 'Axis',
                'type' => 'text',
                'id'   => 'wc_oprics_settings_Axis',
                'default' => 'Axis'
            ),
            
            
            'Add' => array(
                'name' => 'Add',
                'type' => 'text',
                'id'   => 'wc_oprics_settings_Add',
                'default' => 'Add'
            ),            
            
            'Ipd' => array(
                'name' => 'Ipd',
                'type' => 'text',
                'id'   => 'wc_oprics_settings_Ipd',
                'default' => 'Ipd'
            ),
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_oprics_settings_section_end'
            )
        );

        return apply_filters( 'wc_oprics_settings_settings', $settings );
    }

}

ANONY_WC_Settings_Tab::init();