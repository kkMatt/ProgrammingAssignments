<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.08.12
 * @email - kestutis.itsolutions@gmail.com
 * @description - MRSS reader and XML processor
 * @version - 1.0
*/

require_once("class.MRSS-reader-by-Kestutis.php");

class XMLProcessor
{
    private $feedUrl = "";
	private $debug = FALSE; // FALSE, TRUE, 2 (more)
	private $elementsToUse = array();
	
	function __construct($feedUrl, $elementsToUse, $debug=FALSE)
	{
        $this->feedUrl = $feedUrl;
		$this->elementsToUse = $elementsToUse;
		if(in_array($debug, array(FALSE, TRUE, 2)))
		{
			$this->debug = $debug;
		}
		
	}

    // Getter
    // Get all attributes if available
    private function getAllAttributes($father)
    {
        $fatherAttributes = array();
        if ($father->hasAttributes())
        {

            foreach ($father->attributes as $attr)
            {
                $attrName = $attr->nodeName;
                $attrValue = $attr->nodeValue;
                $fatherAttributes[$attrName] = $attrValue;
                //echo "Attribute '$name' :: '$value'<br />";
            }
        }
        
        return $fatherAttributes;
    }
    
    // Getter
    // Get all childs
    private function getAllChilds($father)
    {
        $XMLtagChildNodes = array();
        foreach($father->childNodes as $child)
        {
            if($child->nodeType == XML_ELEMENT_NODE)
            {
                $XMLtagChildNodes[] = $child->nodeName;
            }
        }
        
        return $XMLtagChildNodes;

    }   
    
    // Getter
    // Get JSON from XML MRSS feed
    public function getProcessAndGetJsonAfterProcess()
    {
        $feed = new DOMDocument();
        // Load XML
        $feed->load($this->feedUrl);
        
        $elManager = new elementsManager($this->elementsToUse, $this->debug);
        
        // Load elements
        $rootElName = $elManager->getValuesOfKey("root");
        if($this->debug)
        {
            echo "ROOT EL: {$rootElName[0]}<br />";
        }
        // XML DOC SEARCH
        $elements = $feed->getElementsByTagName($rootElName[0]);
        $data = array();
        
        $i = 0;
        foreach($elements AS $node)
        {
            $data[$i] = array();
            foreach($node->childNodes as $child)
            {
                if($child->nodeType == XML_ELEMENT_NODE)
                {
                    if($this->debug)
                    {
                        print "<br />[XML EL] SEARCH: {$child->nodeName}"; //print_r($arrayKeysToSearch);
                    }
                    
                    // Get all attributes if available
                    $childAttributes = $this->getAllAttributes($child);
                    
                    // Get all childs
                    $XMLtagChildNodes = $this->getAllChilds($child);

                    // Find a new key
                    $newKey = $elManager->findElementFromXMLTag($child->nodeName, $XMLtagChildNodes, $childAttributes);
                    
                    // if element exist
                    //$key = array_search($child->nodeName, $arrayKeysToSearch);
                    //if ($key !== FALSE && !is_array($neededElements[$key]))
                    if ($newKey !== FALSE)
                    {
                        if($newKey['get_attribute'] != "")
                        {
                            $value = $child->getAttribute($newKey['get_attribute']);
                            $data[$i][$newKey['new_key']] = base64_encode($value ? $value : "Unknown");
                        } elseif(sizeof($newKey['get_childs']) > 0 && is_array($newKey['new_key']) && sizeof($newKey['get_childs']) == sizeof($newKey['new_key']))
                        {
                            $counter = 0;
                            for($counter = 0; $counter < sizeof($newKey['get_childs']); $counter++)
                            {
                                $value = $child->getElementsByTagName($newKey['get_childs'][$counter])->item(0)->nodeValue;
                                $data[$i][$newKey['new_key'][$counter]] = base64_encode($value ? $value : "Unknown");
                            }
                        } else
                        {
                            $value = $child->nodeValue;
                            $data[$i][$newKey['new_key']] = base64_encode($value ? $value : "Unknown");
                        }
                    }
                } else
                {
                    if($this->debug)
                    {
                        print "<br />[".$child->nodeType."] SEARCH NAME: {$child->nodeName}";
                    }
                }
            }
            $i++;
        }
        
        if($this->debug)
        {
            echo "<br /><br />";
            foreach($data AS $id=>$item)
            {
                echo "<br /><br /><strong>ITEM {$id}:</strong> Array (";
                foreach ($item AS $id2=>$elem)
                {
                    echo "<br />__[{$id2}]__ => &quot;".htmlspecialchars($elem)."&quot;";
                }
                echo "<br />);";
            }
        }
        
        // Convert to JSON format
        //$jsonData = json_encode($data, JSON_FORCE_OBJECT);
        $jsonData = json_encode($data); 
        
        return $jsonData;
    }
}
?>
