<?php

/*
 * Plugin Name: Ninja Forms - Error Inspector
 */

if( ! class_exists( 'NF_ErrorInspector' ) ){

    class NF_ErrorInspector
    {
        public function __construct()
        {
            if( ! isset( $_GET[ 'page' ] ) ) return;
            if( 'ninja-forms' != $_GET[ 'page' ] ) return;
            register_shutdown_function( array( $this, 'shutdown' ) );
        }

        public function shutdown()
        {
            if( ! function_exists( 'current_user_can' ) ) return;
            if( ! current_user_can( 'manage_options' ) ) return;

            $error = error_get_last();

            if( ! $error ) return;
            if( ! in_array( $error[ 'type' ], array( E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR ) ) ) return;

            echo '<pre>' . $error[ 'message' ] . '</pre>';
            /* DEBUG */ echo "<pre>"; var_dump( $error ); echo "</pre>";
            die();
        }
    }
}

new NF_ErrorInspector();
