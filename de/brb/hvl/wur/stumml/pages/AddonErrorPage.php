<?php

import('de_brb_hvl_wur_stumml_pages_Frame');

class AddonErrorPage extends Frame
{
    private $cMessage;

    /**
     * @param String|null $message
     */
    public function __construct($message)
    {
        parent::__construct();
        $this->cMessage = $message;
    }

    /**
     * @return String|void
     */
    //@Override
    public function getLastChangeTimestamp()
    {
    }

    /**
     * Shows given error message
     */
    //@Override
    public function showContent()
    {
        print "<h2>Fehler!</h2>";
        print "<p>".$this->cMessage."</p>";
    }
}
