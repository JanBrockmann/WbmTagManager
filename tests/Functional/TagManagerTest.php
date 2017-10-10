<?php

class TagManagerTests extends Enlight_Components_Test_Controller_TestCase
{
    /**
     * @var array
     */
    private $pluginConfig;

    /**
     * @var \WbmTagManager\Services\TagManagerVariables
     */
    private $variables;

    public function setUp()
    {
        parent::setUp();

        $this->pluginConfig = Shopware()->Container()->get('shopware.plugin.cached_config_reader')->getByPluginName('WbmTagManager');
        $this->variables = Shopware()->Container()->get('wbm_tag_manager.variables');
        if (empty($this->pluginConfig['wbmTagManagerContainer'])) {
            $plugin = Shopware()->Container()->get('shopware_plugininstaller.plugin_manager')->getPluginByName('WbmTagManager');
            Shopware()->Container()
                ->get('shopware_plugininstaller.plugin_manager')
                ->saveConfigElement($plugin, 'wbmTagManagerContainer', 'GTM-XXXXXX');
        }
        $this->dispatch('/');
    }

    public function testDataLayerVariables()
    {
        $dataLayerVariables = $this->variables->getVariables();

        $this->assertTrue($dataLayerVariables["google_tag_params"]["ecomm_pagetype"] === "home");
    }
}