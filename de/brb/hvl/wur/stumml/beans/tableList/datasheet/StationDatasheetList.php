<?php

import('de_brb_hvl_wur_stumml_beans_tableList_datasheet_AbstractDatasheetList');
import('de_brb_hvl_wur_stumml_beans_tableList_datasheet_DatasheetListRowData');

import('de_brb_hvl_wur_stumml_util_reportTable_ListRowCells');

class StationDatasheetList extends AbstractDatasheetList
{
    /**
     * @param bool   $isEditorPresent
     * @param string $order [optional]
     * @return StationDatasheetList
     */
    public function __construct($isEditorPresent, $order = "ORDER_SHORT")
    {
        parent::__construct($isEditorPresent, $order);

        return $this;
    }

    /**
     * @param DatasheetListRowData $data
     * @return ListRowCells
     */
    protected function getListRowImpl(DatasheetListRowData $data)
    {
        return new SheetListRowEntries($data);
    }
}

class SheetListRowEntries implements ListRowCells
{
    private $oListRowData;

    public function __construct(DatasheetListRowData $data)
    {
        $this->oListRowData = $data;
    }

    /**
     * @return DatasheetListRowData
     */
    protected function getData()
    {
        return $this->oListRowData;
    }

    /**
     * @return array mixed
     */
    public function getCellsContent()
    {
        $index = (($this->getData()->getIndex() > 9) ? $this->getData()->getIndex() : "0".$this->getData()->getIndex()).".";
        $name = $this->getData()->getBaseElement()->getValueForTag('name');
        $datei = $this->getData()->getFile();
        $nameRef = $datei->toDownloadLink($name, false);
        $kuerzel = $this->getData()->getBaseElement()->getValueForTag('kuerzel');
        $kuerzelRef = $datei->toDownloadLink($kuerzel, false);
        $type = $this->getData()->getBaseElement()->getValueForTag('typ');
        $lastChange = strftime("%a, %d. %b %Y %H:%M", $datei->getMTime());
        return array($index, $nameRef, $kuerzelRef, HtmlUtil::toUtf8($type), $lastChange,
            $this->buildCommandLink("Fpl_View", $kuerzel, $datei),
            ($this->getData()->isEditorPresent()) ? $this->buildCommandLink("Edit_Datasheet",
                "<img src=\"http://www.java.com/js/webstart.png\"  alt=\"Java WS Launch Button\"/>",
                $datei) : "&nbsp;");
    }

    /**
     * @return array string
     */
    public function getCellsStyle()
    {
        return array("style=\"text-align:center;\"", "", "style=\"text-align:center;\"", "style=\"text-align:center;\"",
            "", "style=\"text-align:center;\"", "style=\"text-align:center;\"");
    }

    protected function buildCommandLink($pageName, $label, $url)
    {
        return HtmlUtil::toUtf8(QI::buildAbsoluteLink($pageName, $label,
                "cmd=".str_replace(".xml", "", basename($url))));
    }
}
