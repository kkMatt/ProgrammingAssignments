<?php
/**
 * @author - Kestutis Matuliauskas
 * @date - 2013.08.12
 * @email - kestutis.itsolutions@gmail.com
 * @description - TEST module
 * @version - 1.0
*/
require_once("class.XML-processor.php");

$debug = 2; // FALSE, TRUE, 2 (max.)

$feedUrl = "http://vodo.net/feeds/public";
//$debug = FALSE; // FALSE, TRUE, 2 (max.) // Moved to sep. file
$elementsToUse = array(
    "root" => "entry",
    "childs" => array (
        "title" => "title",
        "link" => array (
            "root" => "link",
            "required_attributes" => array("rel" => "alternate"),
            "get_attribute" => "href"
        ),
        "torrent" => array (
            "root" => "link",
            "required_attributes" => array("rel" => "enclosure"),
            "get_attribute" => "href"
        ),
        "published" => "published",
        "id" => "id",
        "author" => array (
            "root" => "author",
            "child" => "name"
        ),
        "description" => "content",
        "size" => array (
            "root" => "format",
            "child" => "size"
        ),
        "duration" => array (
            "root" => "format",
            "child" => "duration"
        ),
        "file_type" => array (
            "root" => "format",
            "child" => "video_codec"
        ),
        "resolution_w" => array (
            "root" => "format",
            "child" => "width"
        ),
        "resolution_h" => array (
            "root" => "format",
            "child" => "height"
        ),
        "aspect_ratio" => array (
            "root" => "format",
            "child" => "pixel_aspect_ratio"
        )
    )
);


$XMLProcessor = new XMLProcessor($feedUrl, $elementsToUse, $debug);

$json = $XMLProcessor->getProcessAndGetJsonAfterProcess();

echo "<br /><br /><strong>FINAL JSON:</strong><br /> {$json}";
?>