<?php

import('de_brb_hvl_wur_stumml_Settings');
import('de_brb_hvl_wur_stumml_io_File');

class GoodsTrafficSettings extends Settings
{
    private static $INSTANCE = null;

    /**
     * @static instance
     * @return Settings
     */
    public static function getInstance()
    {
        if (null === self::$INSTANCE)
        {
            self::$INSTANCE = new self;
        }
        return self::$INSTANCE;
    }

    /**
     * @return String
     */
    /*@Override*/
    public function lastAddonChange()
    {
        return '14. Oktober 2011 22:30:00';
    }

    /**
     * @return File
     */
    //@Override
    public final function getTemplateFile()
    {
        return new File($this->addonTemplateBaseDir().'/goods_traffic_basics.php');
    }

    private function __construct(){}
    private function __clone(){}
}