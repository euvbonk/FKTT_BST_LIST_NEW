<?php

import('de_brb_hvl_wur_stumml_beans_tableList_AbstractListRowEntriesImpl');
import('de_brb_hvl_wur_stumml_beans_tableList_datasheet_DatasheetListRowEntries');
import('de_brb_hvl_wur_stumml_html_util_HtmlUtil');

class DatasheetListRowEntriesImpl extends AbstractListRowEntriesImpl implements DatasheetListRowEntries
{
    private $index;
    private $type;
    private $lastChange;
    
    public function __construct($name, $short, $index, $url, $type, $lastChange)
    {
        parent::__construct($name, $short, $url);
        $this->setIndex($index);
        $this->setType($type);
        $this->setLastChange($lastChange);
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setType($t)
    {
        $this->type = $t;
    }
    
    public function getLastChange()
    {
        return $this->lastChange;
    }
    
    public function setLastChange($l)
    {
        $this->lastChange = $l;
    }
    
    public function setIndex($i)
    {
        $this->index = $i;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function getCellsContent()
    {
        return array((($this->getIndex() > 9) ? $this->getIndex() : "0".$this->getIndex()).".",
                     $this->getNameWithReference(),
                     $this->getShortWithReference(),
                     HtmlUtil::toUtf8($this->getType()),
                     $this->getLastChange()
                    );
    }

    public function getCellsStyle()
    {
        return array("style=\"text-align:center;\"");
    }
}
?>
