<?php

namespace LNCNearComments\Controllers;

use LNCNearComments\Model\Constructor\ConfigPage;

/**
 * Class PageConstructor
 * @package LNCNearComments
 */
class PageConstructor
{
    /**
     * pages pool
     *
     * @var array
     */
    protected array $pages = [];

    /**
     * PageConstructor constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->pageCreator($config);
    }

    /**
     * @param $config
     */
    protected function pageCreator($config)
    {
        $this->pages['config'] = new ConfigPage($config);
    }
}
