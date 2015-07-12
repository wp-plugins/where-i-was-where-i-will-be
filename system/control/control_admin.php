<?php
class WIWWIWB_Admin {
	function __construct() {
		add_action('admin_menu', array($this,'add_page')); // Add the admin options page
		add_action('admin_init', array($this,'init_settings')); //Call register settings function
        add_action('admin_init', array($this, 'wiwwiwb_button')); //Insert Button on Page/Post
        add_action('admin_footer',array($this,'wiwwiwb_div')); //To be used on script.js
		
        add_action( 'init', array($this, 'plugin_translate') ); //Translate
    
        $this->load_ajax(); //Call Actions to use Ajax
	}
	
	function add_page() {
		//Add Admin pages
		add_menu_page( 'WIWWIWB', 'Where I Was, Where I Will Be', 'manage_options', 'wiwwiwb', array($this,'wiw_locals'), WIW_DIR_IMAGES.'icon-16x16.png');
        add_submenu_page('wiwwiwb',__('Locals', WIW_TRANSLATE),__('Manage Locals', WIW_TRANSLATE),'manage_options','wiwwiwb',array($this,'wiw_locals'));
        add_submenu_page('wiwwiwb',__('Edit Local', WIW_TRANSLATE),__('Edit Locals', WIW_TRANSLATE),'manage_options','wiw_edit_local',array($this,'wiw_edit_local'));
		add_submenu_page('wiwwiwb',__('New Local', WIW_TRANSLATE),__('New Local', WIW_TRANSLATE),'manage_options','wiw_new_local',array($this,'wiw_new_local'));		
		add_submenu_page('wiwwiwb',__('Type', WIW_TRANSLATE),__('Manage Types', WIW_TRANSLATE),'manage_options','wiw_type',array($this,'wiw_type'));		
		add_submenu_page('wiwwiwb',__('Settings', WIW_TRANSLATE),__('Settings', WIW_TRANSLATE),'manage_options','wiw_settings',array($this,'wiw_settings'));        
	}
    
    function load_ajax() {
        include_once (WIW_DIR_CONTROL.'ajax.php');
        $control_ajax = new WIWWIWB_Ajax();
    
        add_action('wp_ajax_wiw_show_types',array($control_ajax,'wiw_result_show_types'));
        add_action('wp_ajax_wiw_add_type',array($control_ajax,'wiw_result_add_type'));
        add_action('wp_ajax_wiw_edit_type',array($control_ajax,'wiw_result_edit_type'));
        add_action('wp_ajax_wiw_delete_type',array($control_ajax,'wiw_result_delete_type'));
        add_action('wp_ajax_wiw_more_info_local',array($control_ajax,'wiw_result_more_info_local'));
        add_action('wp_ajax_wiw_add_local',array($control_ajax,'wiw_result_add_local'));
        add_action('wp_ajax_wiw_edit_local',array($control_ajax,'wiw_result_edit_local'));
        add_action('wp_ajax_wiw_delete_local',array($control_ajax,'wiw_result_delete_local'));
    }
	
	function register_settings($settings, $section) { //Register Settings
		foreach($settings as $set) {
			register_setting($section[0],$set);
		}
		add_settings_section(
			$section[0],	
			$section[1],	
			$section[2],	
			$section[3]	
		);
	}
	
	function init_settings() {
    
        //$this->plugin_translate(); 
		add_action( 'init', array($this, 'plugin_translate')); //Call Files to translate plugin
		
		//Register Initial Settings
		$settings = array('wiw_standard_type','wiw_standard_text','wiw_google_api','wiw_load_google_api','wiw_drop_table');
		$section = array('wiw_settings','Settings','wiw_settings_section_text','wiwwiwb');
		$this->register_settings($settings,$section);
    }
	
	function include_page($page) {//Make link to Admin Pages
		include_once (WIW_DIR_VIEW_ADMIN.$page.'.php');		
	}
	
	function wiw_settings() {//See includePage
		$this->include_page('setting');
	}	

	function wiw_locals() {//See includePage
		$this->include_page('locals');
	}

	function wiw_edit_local() {//See includePage
		$this->include_page('edit_local');
	}
    
	function wiw_new_local() {//See includePage
		$this->include_page('new_local');
	}

	function wiw_type() {//See includePage
		$this->include_page('type');
	}

    //What happens when the plugin is activated	
	function wiw_activate() {
		//Create Tables
		include_once (WIW_DIR_MODEL.'create.php');
		$create = new WIWWIWB_Model_Create();	
		$create->activate_create_locals_table();
		$create->activate_create_type_table();
		
        //Initiate Options
		add_option('wiw_standard_type', '1');
        add_option('wiw_standard_text', '
            <div style="width:350px; height:350px;">
                <h4>%flag% %city%/%country%</h4>
                <img src="%image%" />
                <HR>
                <a href="%url%">See More...</a>
            </div>
        ');
	}
	
    //What happens when the plugin is deactivated
    function wiw_deactivate() {

        if (get_option('wiw_drop_table')) {
            //Drop Tables
            include_once (WIW_DIR_MODEL.'create.php');
            $create = new WIWWIWB_Model_Create();	
            $create->drop_table('locals');
            $create->drop_table('type');
            
            
            
            //Delete Options
            delete_option('wiw_standard_type');
            delete_option('wiw_standard_text');
            delete_option('wiw_load_google_api');
            delete_option('wiw_drop_table');
            delete_option('wiw_google_api');
        }
    }
    
    //Add Button on Edit/Add Post/Page
    function wiw_register_button( $buttons ) {
       array_push( $buttons, "|", "wiwwiwb" );
       return $buttons;
    }
    
    function add_wiw_plugin( $plugin_array ) {
       $plugin_array['wiwwiwb'] = WIW_DIR_JS . 'call_plugin.js';
       return $plugin_array;
    }
    
    function wiwwiwb_button() {
       if ((!current_user_can('edit_posts')) && (!current_user_can('edit_pages'))) return;
    
       if (get_user_option('rich_editing') == 'true') {
          add_filter('mce_external_plugins', array($this,'add_wiw_plugin'));
          add_filter('mce_buttons', array($this,'wiw_register_button'));
          
       }
    }
    
    function wiwwiwb_div() {
        $screen = get_current_screen();
        if ($screen->parent_base == 'edit') //Only load if user is in Page/Post page
            if (get_user_option('rich_editing') == 'true')
                include_once(WIW_DIR_VIEW_ADMIN.'insert/page_post.php');
    }
    
    function plugin_translate() {
		$domain = WIW_TRANSLATE;
		load_textdomain( $domain, WIW_DIR . '/language' . '/'. $domain . '-' . get_locale() . '.mo' );
        load_plugin_textdomain( $domain, false, WIW_DIR.'language/');
    }
}

?>