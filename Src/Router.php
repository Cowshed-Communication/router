<?php

namespace Cowshed\Router;

use function post_exists;

class Router {
	private static array $routes;

	private array $error_bag;

	/**
	 * Router constructor.
	 */
	public function __construct() {
		$this->routes = [];
	}

	/**
	 * Add a route.
	 *
	 * @param $route
	 *
	 * @return $this
	 */
	public function route( $route ) {
		self::$routes[] = $route;

		return $this;
	}

	/**
	 * Return the URL of the route.
	 *
	 * @param $ref string route reference - specified in the route array.
	 *
	 * @return false|mixed|string
	 */
	public static function url( string $ref ) {
		$filter = array_filter( self::$routes, function ( $el ) use ( $ref ) {
			if ( $el['ref'] == $ref ) {
				return 1;
			}
		} );

		if ( empty( $filter ) ) {
			return false;
		}

		$filter = array_values( $filter );

		$page = get_page_by_title( $filter[0]['name'] );

		if ( ! $page ) {
			return false;
		}

		return $page->guid ?? false;
	}

	/**
	 * Create the pages contained within $this->routes as WordPress CMS pages. If a page with the exact title already
	 * exists, it will be skipped and an error will be inserted to $this->error_bag.
	 * @return $this
	 */
	public function bind() {

		if ( ! function_exists( 'post_exists' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/post.php' );
		}

		foreach ( self::$routes as $route ) {

			if ( \post_exists( $route['name'] ) ) {

				$this->error_bag['notices'][] = "Route {$route['name']} (Page) already exists in the CMS.";

				continue;
			}

			$args = [
				'post_title'   => $route['name'],
				'post_content' => '',
				'post_status'  => 'publish',
				'post_author'  => 1,
				'post_type'    => 'page',
				'meta_input'   => [
					'_wp_page_template' => $route['template'],
				],
			];

			wp_insert_post( $args );
		}

		return $this;
	}

	/**
	 * Return the error bag.
	 * @return array error bag
	 */
	public function errors() {
		return $this->error_bag;
	}
}