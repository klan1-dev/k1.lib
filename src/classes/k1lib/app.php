<?php

namespace k1lib;
use k1lib\app\config;

class app
{
    protected config $config;
    protected bool $is_web = false;
    protected bool $is_shell = false;
    protected bool $is_api = false;
    protected string $script_path;
    static string $base_path;
    static string $base_url;
    /**
     * @param config $app_config
     * @param bool $api_mode
     */
    function __construct(config $app_config, string $script_path, $api_mode = false)
    {
        $this->config = $app_config;
        $this->is_api = $api_mode;
        $this->script_path = $script_path;
        $this->bootstrap();
    }
    /**
     * @return void
     */
    function bootstrap(): void
    {
        /**
         * Lests define if is web or shell
         */
        if (array_key_exists('SHELL', $_SERVER)) {
            if ($this->is_api) {
                trigger_error('You can\'t start an API app with shell', E_USER_ERROR);
            }
            $this->is_shell = true;
        }
        if (array_key_exists('HTTP_HOST', $_SERVER)) {
            if (!$this->is_api) {
                $this->is_web = true;
            }
        }

        $this->auto_config();

    }
    /**
     * @return void
     */
    function auto_config(): void
    {
        /**
         * Genral config about paths
         */

        // AUTO CONFIGURATED PATHS
        define('k1app\K1APP_ROOT', str_replace('\\', '/', dirname($this->script_path)));
        define('k1app\K1APP_DIR', basename(\k1app\K1APP_ROOT) . '/');
        define('k1app\K1APP_DOMAIN', $_SERVER['HTTP_HOST']);

        define('k1app\K1APP_CONTROLLERS_PATH', \k1app\K1APP_ROOT  . '/src/controllers/'); // 2.0
        define('k1app\K1APP_CLASSES_PATH', \k1app\K1APP_ROOT  . '/src/classes/'); // 2.0
        define('k1app\K1APP_ASSETS_PATH', \k1app\K1APP_ROOT  . '/assets/'); // 2.0
        define('k1app\K1APP_ASSETS_IMAGES_PATH', \k1app\K1APP_ASSETS_PATH  . 'images/'); // 2.0

        // define('k1app\K1APP_VIEWS_PATH', \k1app\K1APP_ROOT . '/views/');

        // define('k1app\K1APP_VIEWS_CRUD_PATH', \k1app\K1APP_VIEWS_PATH . '/k1lib.crud/');
        define('k1app\K1APP_SETTINGS_PATH', \k1app\K1APP_ROOT  . '/settings/');
        define('k1app\K1APP_UPLOADS_PATH', \k1app\K1APP_ASSETS_PATH  . 'uploads/');
        define('k1app\K1APP_SHELL_SCRIPTS_PATH', \k1app\K1APP_ASSETS_PATH  . '/shell-scripts/');
        // define('k1app\K1APP_TEMPLATES_PATH', \k1app\K1APP_RESOURCES_PATH . '/templates/');
        define('k1app\K1APP_FONTS_PATH', \k1app\K1APP_ASSETS_PATH  . 'fonts/');

        /**
         * COMPOSER
         */
        define('k1app\COMPOSER_PACKAGES_PATH', \k1app\K1APP_ROOT  . 'vendor/');

        // AUTO CONFIGURATED URLS
        if ($this->is_web) {
            /**
             * If this error is trigger you should set by hand the CONST: k1app\K1APP_BASE_URL
             * with your personal configuration.
             */
            $app_base_url = dirname(substr($_SERVER['SCRIPT_FILENAME'], strlen($_SERVER['DOCUMENT_ROOT']))) . '/';
            if ($app_base_url == '//' || $app_base_url == '\/') {
                $app_base_url = '/';
            }
            define('k1app\K1APP_BASE_URL', $app_base_url);

            //    define('k1app\K1APP_DOMAIN_URL', (\k1lib\common\get_http_protocol() . '://') . \k1app\K1APP_DOMAIN);
            define('k1app\K1APP_DOMAIN_URL', '//' . \k1app\K1APP_DOMAIN);

            define('k1app\K1APP_URL', \k1app\K1APP_DOMAIN_URL  . \k1app\K1APP_BASE_URL);
            define('k1app\K1APP_HOME_URL', \k1app\K1APP_URL);
            define('k1app\K1APP_ASSETS_URL', \k1app\K1APP_HOME_URL  . 'assets/');
            define('k1app\K1APP_IMAGES_URL', \k1app\K1APP_ASSETS_URL  . 'images/');
            define('k1app\K1APP_UPLOADS_URL', \k1app\K1APP_ASSETS_URL  . 'uploads/');
            define('k1app\K1APP_TEMPLATES_URL', \k1app\K1APP_ASSETS_URL  . 'templates/');
            //    define('k1app\K1APP_TEMPLATE_IMAGES_URL', \k1app\K1APP_TEMPLATE_URL . 'img/');

            /**
             * COMPOSER
             */
            define('k1app\COMPOSER_PACKAGES_URL', \k1app\K1APP_URL  . 'vendor/');
        }
    }
    /**
     * @return void
     */
    function start_controllers(): void
    {

    }
}
