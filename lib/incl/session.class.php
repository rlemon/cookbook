<?php
/*
 *      session.class
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
class Session {
	public static function init() {
		@session_start();
	}
	public static function set( $key, $value ) {
		$_SESSION[ $key ] = $value;
	}
	public static function get( $key ) {
		if ( isset( $_SESSION[ $key ] ) )
			return $_SESSION[ $key ];
	}
	public static function destroy() {
		unset($_SESSION);
		@session_destroy();
	}
}
