<?php
/*
 *      bootstrap.class
 *      
 *      Copyright 2012 Robert Lemon <rob.lemon@gmail.com>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 *      
 *      
 */
class Bootstrap {
	
	public function __construct() {
		try {
			$url = isset( $_GET[ 'url' ] ) ? explode( '/', rtrim( $_GET[ 'url' ], '/' ) ) : null;
			if ( empty( $url[ 0 ] ) ) {
				$url[ 0 ] = 'dashboard';
			}
			$file = 'lib/controllers/' . $url[ 0 ] . '.controller.php';
			if ( !file_exists( $file ) ) {
				$this->error('404');
			}
			require( $file );
			if ( !class_exists( $url[ 0 ] ) ) {
				$this->error('404');
			}
			$controller = new $url[ 0 ];
			$controller->load_model( $url[ 0 ] );
			if ( isset( $url[ 1 ] ) ) {
				if ( !method_exists( $controller, $url[ 1 ] ) ) {
					$this->error('404');
				}
				$params = array_slice( $url, 2 );
				call_user_func_array( array(
					 $controller,
					$url[ 1 ] 
				), $params );
			} else {
				$controller->index();
			}
		} catch( Exception $e ) {
			$this->error('Unknown error: ' . $e );
		}
	}
	
	public function error($message) {
		require( 'lib/controllers/error.controller.php' );
		$error = new Error();
		$error->show($message);
		exit;
	}
	
}
