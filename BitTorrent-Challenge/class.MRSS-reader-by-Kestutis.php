<?php
/**
 * @author - Kestutis Matuliauskas
 * @date - 2013.08.12
 * @email - kestutis.itsolutions@gmail.com
 * @description - MRSS XML feed reader's XML manager
 * @version - 1.0
*/

class elementsManager
{
	private $debug = FALSE; // FALSE, TRUE, 2 (more)
	private $elementsToUse = array();
	
	function __construct($elementsToUse, $debug=FALSE)
	{
		$this->elementsToUse = $elementsToUse;
		if(in_array($debug, array(FALSE, TRUE, 2)))
		{
			$this->debug = $debug;
		}
		
	}
	
    // Getter
	public function findElementFromXMLTag($XMLTag, $XMLTagChildTags=array(), $XMLAttributes=array())
	{
		if($this->debug)
		{
			echo "<br />========================================";
			echo "<br />METHOD CALLED: <strong>findElementFromXMLTag: START</strong>";
			echo "<br />XML TAG TO SEARCH: <strong>{$XMLTag}</strong>";
		}
		
		// default return;
		$newKey = FALSE;
		
		// All required childs
		$getChilds = array();
		$newKeys = array();
		
		if(is_array($this->elementsToUse['childs']))
		{
			if($this->debug > 1)
			{
				echo "<br />Childs exist in current pattern";
			}			
			foreach($this->elementsToUse['childs'] AS $name=>$value)
			{
				if(!is_array($value))
				{
					// value is our xml tag to check
					$XMLTagForSearch = $value;
					
					if($this->debug > 1)
					{
						echo "<br />[LEVEL 1] CMP: (\$XMLTagForSearch == \$XMLTag): {$XMLTagForSearch} == {$XMLTag}";
					}
					if($XMLTagForSearch == $XMLTag)
					{
						$newKey = array(
							"new_key" => $name,
							"old_key" => $XMLTag,
							"get_childs" => "",
							"get_attribute" => ""	
						);
					}
					
				} else if(isset($value['root']))
				{
					$XMLTagForSearch = $value['root'];
					
					if($this->debug > 1)
					{
						echo "<br />[LEVEL 2] CMP: (\$XMLTagForSearch == \$XMLTag): {$XMLTagForSearch} == {$XMLTag}";
					}
					if($XMLTagForSearch == $XMLTag)
					{
						if(isset($value['child']) && $value['child'] != "")
						{
							if($this->debug > 1)
							{
								echo "<br />[LEVEL 3A] CMP: in_array(\$Req child tag, \$XMLTag Childs): ";
								echo "in_array({$value['child']}, [".implode(", ", $XMLTagChildTags)."])";
							}
							
							if(sizeof($XMLTagChildTags) > 0 && in_array($value['child'], $XMLTagChildTags))
							{
								if($this->debug > 1)
								{
									echo "<br />[LEVEL 3A] {$value['child']} <strong>is IN_ARRAY!</strong> [KEY: {$name}]";
								}
								$getChilds[] = $value['child'];
								$newKeys[] = $name;
								// RETURN OK (name)
								$newKey = array(
									"new_key" => $newKeys,
									"old_key" => $XMLTag,
									"get_childs" => $getChilds,
									"get_attribute" => ""	
								);
							}

						} else if(isset($value['required_attributes']))
						{
							if($this->debug > 1)
							{
								echo "<br />[LEVEL 3B] DOM Attributes: "; print_r($XMLAttributes);
							}
							
							$passed = true;
							foreach($value['required_attributes'] AS $reqAttribute=>$reqValue)
							{
								if($this->debug > 1)
								{
									echo "<br />[LEVEL 3B] CMP: (\$XMLAttributes[\$reqAttribute] == \$reqValue): {$XMLAttributes[$reqAttribute]} == {$reqValue}";
								}
								if(isset($XMLAttributes[$reqAttribute]) && $XMLAttributes[$reqAttribute] == $reqValue)
								{
									// OK, do nothing
								} else
								{
									// will return false at the end, requirements did not match
									$passed = false;
								}
							}
							
							if($passed)
							{
								// RETURN OK (name)
								$newKey = array(
									"new_key" => $name,
									"old_key" => $XMLTag,
									"get_childs" => "",
									"get_attribute" => $value['get_attribute']	
								);
							}
						}
					}
				}
			}
		}
		
		if($this->debug)
		{
			echo "<br /><strong>RETURN</strong> (\$newKey): <strong>"; var_dump($newKey); echo "</strong>";
			echo "<br />METHOD: <strong>findElementFromXMLTag: FINISH</strong>";
			echo "<br />========================================";
		}
		
		return $newKey;
	}
	
    // Getter
	public function getKeysOfKey($key=array())
	{
		return $this->getKeysAndValuesOfKey($key, "keys");
	}
	
    // Getter
	public function getValuesOfKey($key=array())
	{
		return $this->getKeysAndValuesOfKey($key, "values");
	}
	
	// Getter
	public function getKeysAndValuesOfKey($key=array(),$getOnly="")
	{
		// if this is not an array
		if(!is_array($key))
		{
			$tmpKey = array();
			$tmpKey[0] = $key;
			$key = $tmpKey;
		}
		
		$ret = array();
		$retKeys = array();
		$retValues = array();
		$retBoth = array();
		$childs = $this->elementsToUse;
		
		// Go up to the tree
		foreach($key AS $id=>$keyLevel)
		{
			$tmpElementsToUse = $childs[$keyLevel];
			$childs = $tmpElementsToUse;
		}
		if(is_array($childs))
		{
			foreach($childs AS $name=>$value)
			{
				if(!is_array($value))
				{
					$orgKey = $value;
					$newKey = $name;
					$retKeys[] = $newKey;
					$retValues[] = $orgKey;
					$retBoth[$orgKey] =$newKey;
				} else
				{
					// if is array
					$retKeys[] = array("newKey" => $name, "originalKey" => $value['root']);
					$retValues[] = $value;
					$retBoth[$value['root']] = array("newKey" => $name, "value" => $value);
				}
			}
		} else
		{
			$retKeys[] = $key[0];
			$retValues[] = $childs;
			$retBoth[$key[0]] = $childs;
		}
		
		if($getOnly == "keys")
		{
			$ret = $retKeys;
		} else if($getOnly == "values")
		{
			$ret = $retValues;
		} else
		{
			$ret = $retBoth;
		}
		
		return $ret;
	}
}
?>