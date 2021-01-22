<?php

namespace Jdlabs\Spaniel\Controllers;

use Jdlabs\Spaniel\Utils\Singleton;

/**
 * Class BaseController
 *
 * @package \Jdlabs\Spaniel\Controllers
 */
abstract class BaseController extends Singleton
{

    /**
     * @param array|\WP_Error $response
     * @param int $http_code
     * @return \WP_REST_Response
     */
    public function json($response, int $http_code = 200): \WP_REST_Response
    {
        if (is_array($response)) {
            return new \WP_REST_Response($response, $http_code);
        } else if (get_class($response) === \WP_Error::class) {
            return $this->error($response->get_error_message(), $response->get_error_code());
        }

        return $this->error('Response is not an array or WP_Error');
    }

    /**
     * @param string $message
     * @param int $http_code
     * @return \WP_REST_Response
     */
    public function error(string $message, int $http_code = 500): \WP_REST_Response
    {
        return $this->json(['error' => $message], $http_code);
    }
}