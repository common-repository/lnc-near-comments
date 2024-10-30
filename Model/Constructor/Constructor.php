<?php

namespace LNCNearComments\Model\Constructor;

use LNCNearComments\Controllers\CommentController;
use LNCNearComments\Controllers\PageConstructor;
use LNCNearComments\Model\Config;

/**
 * Init all main functionality
 *
 * Class Constructor
 * @package LNCNearComments\Model\Constructor
 */
class Constructor
{
    /**
     * Self Constructor object.
     * @var Constructor $instance
     */
    private static Constructor $instance;

    /**
     * Plugin options
     *
     * @var mixed
     */
    public static $options;

    /**
     * @var Config
     */
    private Config $config;

    /**
     * Controllers
     *
     * @var array
     */
    protected array $controllers = [];


    public function getController($name)
    {
        if ($this->controllers[$name]) {
            return $this->controllers[$name];
        }
        return false;
    }

    /**
     * protect singleton  clone
     */
    private function __clone()
    {

    }

    /**
     * Method to use native functions as methods
     *
     * @param $name
     * @param $arguments
     * @return bool|mixed
     */
    public function __call($name, $arguments)
    {
        if (function_exists($name)) {
            return call_user_func_array($name, $arguments);
        }
        return false;
    }

    /**
     * public singleton __wakeup
     */
    public function __wakeup()
    {

    }

    /**
     * Constructor method.
     *
     */
    private function __construct()
    {
        $this->config = new Config();
        $this->controllersInit();
        $this->setUpActions();
        self::$options = apply_filters('getLNCNearCommentsOptions', 'options');
    }

    private function setUpActions()
    {
        add_action('init', [&$this, 'addScripts']);
    }

    public function addScripts()
    {
        wp_enqueue_script(
            $this->config->getPluginName(),
            $this->config->getScriptsPath() . 'index.js',
            ['jquery'],
            '0.01'
        );
        $localize = [
            'comment_form_selector' => is_array(self::$options) && isset(self::$options['comment_form_selector'])
                ? self::$options['comment_form_selector']
                : ''
            ,
            'ajax_url' => admin_url('admin-ajax.php'),
        ];

        wp_localize_script($this->config->getPluginName(), 'lnc_near_comments', $localize);
    }

    /**
     * Method to init controllers
     */
    protected function controllersInit()
    {
        $this->controllers['pageController'] = new PageConstructor($this->config);
        $this->controllers['commentController'] = new CommentController();
    }

    /**
     * Get self object
     *
     * @return Constructor object
     */
    public static function getInstance(): Constructor
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
