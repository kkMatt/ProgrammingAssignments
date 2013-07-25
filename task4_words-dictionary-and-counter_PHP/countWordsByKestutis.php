<?php
/**
 * @author - Kestutis Matuliauskas
 * @date - 2013.07.25
 * @email - kestutis.itsolutions@gmail.com
 * @description - Count the words
 * @version - 1.3
*/


// is that is a linux command line interface?
$debug = false;
$CLI = false;
$fileName = $CLI ? $argv[1] : "document.txt";

// open the file
$fileHandler = @fopen($fileName, "r");

$sentencesInFile = array();
// Check if file is open
if ($fileHandler)
{
    while (true)
	{
        $value = fgets($fileHandler);
        if ($value == false)
        {
            // break loop if we reached end of file
            break;
        }
		$sentencesInFile[] = trim($value);
    }
    
    // Check if that is the end of file
    if (!feof($fileHandler))
    {
        kPrint("Error: bad end of file pointer got from fgets()", $CLI);
    }
    fclose ($fileHandler);
}

$wordsDatabase = array();
$wordsCountDatabase = array();

// Go over all sentences, and swap case
foreach($sentencesInFile AS $sentence)
{
    
    // Remove line chars and tabs
    $sentenceWithWordsOnly = str_replace(array('\r','\n', '\t'), ' ', $sentence);
    
    // remove bad chars
    $sentenceWithWordsOnly = preg_replace('~[^\p{L}]++~u', ' ', $sentenceWithWordsOnly);

    // remove multiple spaces
    $sentenceWithWordsOnly = preg_replace('/\s+/', ' ', $sentenceWithWordsOnly);
    
    // Lowercase the words
    $sentenceWithWordsOnly = strtolower($sentenceWithWordsOnly);
    
    // Debug
    if($debug)
    {
        kPrint("=================", $CLI);
        kPrint("<strong>Sen. Before:</strong> ".$sentence, $CLI);
        kPrint("<strong>Sen. After:</strong> ".$sentenceWithWordsOnly, $CLI);
    }
    
    //explode by word
    $words = explode(" ", $sentenceWithWordsOnly);
    foreach($words AS $word)
    {
        // Search for a words in words DB
        $key = array_search($word, $wordsDatabase);
        
        // if the word is not in the words database
        if($key === FALSE)
        {
            // the add it to database
            $wordsDatabase[] = $word;
            // and add the word counter to words count database
            $wordsCountDatabase[] = 1;
        } else
        {
            // increase the word counter by +1
            $wordsCountDatabase[$key] += 1;
        }
    }
    
    
}

$totalWords = sizeof($wordsDatabase);
// Now print out the results
kPrint("<strong>Words database:</strong>", $CLI);
kPrint("=================", $CLI);
for($i = 0; $i < $totalWords; $i++)
{
    $word = $wordsDatabase[$i];
    $number = $wordsCountDatabase[$i];
    kPrint("Word &#39;<strong>{$word}</strong>&#39;\t, repeats [ <strong>{$number}</strong> ] times", $CLI);
}

// Print based on interface
function kPrint($line, $CLI = false)
{
	if(strlen($line) > 0)
	{
		$output = $CLI ? $line."\n" : $line."<br />";
		print $output;
	}
}
?>