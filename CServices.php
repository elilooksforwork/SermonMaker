<?php

class CServices {

    private $sMethod;
    private $iLimit;
    private $sOrder;

    // constructor
    public function CServices() {
        $this->sMethod = 'xml';
        $this->iLimit = 5;
        $this->sOrder = 'last';
    }

    // set method
    public function setMethod($s) {
        $this->sMethod = $s;  
    }

    // set limit
    public function setLimit($i) {
        $this->iLimit = ($i > 0 && $i < 10) ? $i : $this->iLimit;
    }

    // set order
    public function setOrder($s) {
        $this->sOrder = $s;  
    }

    // return list of videos
    public function getLastVideos() {
        // define order field
        $sOrderField = ($this->sOrder == 'last') ? 'title' : 'views';

        // obtain data from database
        $aData = $GLOBALS['MySQL']->getAll("SELECT * FROM `s189_videos` ORDER BY `{$sOrderField}` DESC LIMIT {$this->iLimit}");

        // output in necessary format
        switch ($this->sMethod) {
            case 'json': // gen JSON result
                // you can uncomment it for Live version
                // header('Content-Type: text/xml; charset=utf-8');
                if (count($aData)) {
                    echo json_encode(array('data' => $aData));
                } else {
                    echo json_encode(array('data' => 'Nothing found'));
                }
                break;
            case 'xml': // gen XML result
                $sCode = '';
                if (count($aData)) {
                    foreach ($aData as $i => $aRecords) {
                        $sCode .= <<<EOF
<unit>
    <id>{$aRecords['id']}</id>
    <title>{$aRecords['title']}</title>
    <author>{$aRecords['author']}</author>
    <image>{$aRecords['thumb']}</image>
    <views>{$aRecords['views']}</views>
</unit>
EOF;
                    }
                }

                header('Content-Type: text/xml; charset=utf-8');
                echo <<<EOF
<?xml version="1.0" encoding="utf-8"?>
<videos>
{$sCode}
</videos>
EOF;
                break;
            case 'html': // gen HTML result
                $sCode = '';
                if (count($aData)) {
                    foreach ($aData as $i => $aRecords) {
                        $sCode .= <<<EOF
<div>
    <img src="{$aRecords['thumb']}" style="float:left;margin-right:10px;" />
    <p>Title: {$aRecords['title']}</p>
    <p>Author: {$aRecords['author']}</p>
    <p>Views: {$aRecords['views']}</p>
</div>
EOF;
                    }
                } else {
                    $sCode = '<div>Nothing found</div>';
                }

                header('Content-Type: text/html; charset=utf-8');
                echo $sCode;
                break;
        }
    }

    public function addVideo($sTitle) {
        // just simulation
        $aData = array('res' => 'Video "' . $sTitle . '" added successfully');

        switch ($this->sMethod) {
            case 'json':
                header('Content-Type: text/xml; charset=utf-8');
                echo json_encode($aData);
                break;
            case 'xml':
                header('Content-Type: text/xml; charset=utf-8');
                echo <<<EOF
<?xml version="1.0" encoding="utf-8"?>
<res>
{$aData['res']}
</res>
EOF;
                break;
            case 'html':
                header('Content-Type: text/html; charset=utf-8');
                echo '<div>' . $aData['res'] . '</div>';
                break;
        }
    }
}