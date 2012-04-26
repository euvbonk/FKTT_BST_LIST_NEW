<?php

import('de_brb_hvl_wur_stumml_html_Html');
import('de_brb_hvl_wur_stumml_html_table_Table');
import('de_brb_hvl_wur_stumml_html_table_TableRow');
import('de_brb_hvl_wur_stumml_html_table_TableCell');
import('de_brb_hvl_wur_stumml_html_table_TableHeadCell');

import('de_brb_hvl_wur_stumml_util_reportTable_ReportTableList');
import('de_brb_hvl_wur_stumml_util_reportTable_ListRow');

class ReportTableListImpl implements ReportTableList, Html
{
    private $cHeader = null;
    private $cEntries = null;
    private $cFooter = null;
    private $cSelector = false;

    public function setRowSelectorEnabled($bool=false)
    {
        $this->cSelector = $bool;
    }

    public function setTableHead(ListRow $rows)
    {
        $this->cHeader = $rows;
    }

    public function setTableBody(ListRow $rows)
    {
        $this->cEntries = $rows;
    }

    public function setTableFoot(ListRow $rows)
    {
        $this->cFooter = $rows;
    }

    public function getTableHead()
    {
        return $this->buildRows("thead", $this->cHeader, ReportTableListProperties::HEAD_ROW_COLOR, "TableHeadCell");
    }

    public function getTableBody()
    {
        return $this->buildRows("tbody", $this->cEntries, array(ReportTableListProperties::ODD, ReportTableListProperties::EVEN));
    }

    public function getTableFoot()
    {
        return $this->buildRows("tfoot", $this->cFooter, ReportTableListProperties::FOOT_ROW_COLOR);
    }

    protected function buildRows($struct, ListRow $rows = null, $rowColor, $cellForm = "TableCell")
    {
        $str = "<".$struct.">\n";
        if ($rows != null)
        {
        foreach ($rows as $ind => $row)
        {
            //print "<pre>".print_r($row, true)."</pre>";
            if (is_array($rowColor))
            {
                //print ($ind %2)."<br/>";
                $trowColor = $rowColor[($ind %2)];
            }
            else
            {
                $trowColor = $rowColor;
            }
            $trow = new TableRow("bgcolor=\"".$trowColor."\"");
            if ($this->cSelector && $struct == "thead" && $ind == 0)
            {
                $trow->addCell(new $cellForm("X", "rowspan=\"".$rows->count()."\""));
            }
            foreach ($row->getCellsContent() as $key => $cell)
            {
                if ($this->cSelector && $key == 0 && $struct == "tbody")
                {
                    $trow->addCell(new $cellForm("<input type=\"checkbox\" name=\"check[]\" value=\"".$cell."\"/>", "style=\"text-align:center;\"")); //".(($this->checkBox) ? " checked=\"checked\" " : "")."
                }
                else
                {
                    $attr = "";
                    if (array_key_exists($key, $row->getCellsStyle()))
                    {
                        $t = $row->getCellsStyle();
                        $attr = $t[$key];
                    }
                    //print "<pre>".print_r($cell, true)."</pre>";
                    $trow->addCell(new $cellForm($cell, $attr));
                }
            }
            $str .= $trow->getHtml();
        }}
        $str .= "</".$struct.">\n";
        return $str;
    }

    public function getHtml()
    {
        $str = "";
        $str .= ($this->cHeader != null) ? $this->getTableHead() : "";
        $str .= ($this->cEntries != null) ? $this->getTableBody() : "";
        $str .= ($this->cFooter != null) ? $this->getTableFoot() : "";
        return (strlen($str) > 0) ? "<table cellspacing=\"1\">\n".$str."</table>\n" : "Nothing to display!";
    }

    //@Override
    public function __toString()
    {
        return "<table>".$this->cHeader.$this->cEntries.$this->cFooter."</table>";
    }
}

?>
