<?
/**
 * @Author - Kestutis IT
 * @Version - v1.0
 * @Description - I did not updated this file code since 2007. It just does what I need
**/
$startdir = '.';
$backtositeurl = 'http://nfq.matuliauskas.lt/';
$showthumbnails = true; 
$showdirs = true;
$forcedownloads = false;
	$hide = array(
		'dlf',
		'.idea',
		'vendor',
		'flight',
		'index.php',
		'FTPFileBrowser.php',
		'Thumbs',
		'.htaccess',
		'.htpasswd'
	);
			 
$displayindex = false;
	$indexfiles = array (
		'index.html',
		'index.htm',
		'default.htm',
		'default.html'
	);

	$filetypes = array (
		'png' => 'jpg.gif',
		'jpeg' => 'jpg.gif',
		'bmp' => 'jpg.gif',
		'jpg' => 'jpg.gif', 
		'gif' => 'gif.gif',
		'zip' => 'archive.png',
		'rar' => 'archive.png',
		'exe' => 'exe.gif',
		'setup' => 'setup.gif',
		'txt' => 'text.png',
		'htm' => 'html.gif',
		'html' => 'html.gif',
		'fla' => 'fla.gif',
		'swf' => 'swf.gif',
		'flv' => 'bsp.gif',
		'xls' => 'xls.gif',
		'doc' => 'doc.gif',
		'sig' => 'sig.gif',
		'fh10' => 'fh10.gif',
		'pdf' => 'pdf.gif',
		'psd' => 'psd.gif',
		'rm' => 'real.gif',
		'ram' => 'real.gif',
		'mpg' => 'video.gif',
		'mpeg' => 'video.gif',
		'mov' => 'video2.gif',
		'avi' => 'video.gif',
		'wmv' => 'video.gif',
		'eps' => 'eps.gif',
		'gz' => 'archive.png',
		'asc' => 'sig.gif',
	);
			

error_reporting(0);
if(!function_exists('imagecreatetruecolor')) $showthumbnails = false;
$leadon = $startdir;
if($leadon=='.') $leadon = '';
if((substr($leadon, -1, 1)!='/') && $leadon!='') $leadon = $leadon . '/';
$startdir = $leadon;

if($_GET['dir']) {
	if(substr($_GET['dir'], -1, 1)!='/') {
		$_GET['dir'] = $_GET['dir'] . '/';
	}
	
	$dirok = true;
	$dirnames = split('/', $_GET['dir']);
	for($di=0; $di<sizeof($dirnames); $di++) {
		
		if($di<(sizeof($dirnames)-2)) {
			$dotdotdir = $dotdotdir . $dirnames[$di] . '/';
		}
		
		if($dirnames[$di] == '..') {
			$dirok = false;
		}
	}
	
	if(substr($_GET['dir'], 0, 1)=='/') {
		$dirok = false;
	}
	
	if($dirok) {
		 $leadon = $leadon . $_GET['dir'];
	}
}

if($_GET['download'] && $forcedownloads) {
	$file = str_replace('/', '', $_GET['download']);
	$file = str_replace('..', '', $file);

	if(file_exists($leadon . $file)) {
		header("Content-type: application/x-download");
		header("Content-Length: ".filesize($leadon . $file)); 
		header('Content-Disposition: attachment; filename="'.$file.'"');
		readfile($leadon . $file);
		die();
	}
}

$opendir = $leadon;
if(!$leadon) $opendir = '.';
if(!file_exists($opendir)) {
	$opendir = '.';
	$leadon = $startdir;
}

clearstatcache();
if ($handle = opendir($opendir)) {
	while (false !== ($file = readdir($handle))) { 
		
		if ($file == "." || $file == "..")  continue;
		$discard = false;
		for($hi=0;$hi<sizeof($hide);$hi++) {
			if(strpos($file, $hide[$hi])!==false) {
				$discard = true;
			}
		}
		
		if($discard) continue;
		if (@filetype($leadon.$file) == "dir") {
			if(!$showdirs) continue;
		
			$n++;
			if($_GET['sort']=="date") {
				$key = @filemtime($leadon.$file) . ".$n";
			} else {
				$key = $n;
			}
			$dirs[$key] = $file . "/";
		} else {
			$n++;
			if($_GET['sort']=="date") {
				$key = @filemtime($leadon.$file) . ".$n";
			} else if($_GET['sort']=="size") {
				$key = @filesize($leadon.$file) . ".$n";
			} else {
				$key = $n;
			}
			$files[$key] = $file;
			
			if($displayindex) {
				if(in_array(strtolower($file), $indexfiles)) {
					header("Location: $file");
					die();
				}
			}
		}
	}
	closedir($handle); 
}


if($_GET['sort']=="date") {
	@ksort($dirs, SORT_NUMERIC);
	@ksort($files, SORT_NUMERIC);
}
elseif($_GET['sort']=="size") {
	@natcasesort($dirs); 
	@ksort($files, SORT_NUMERIC);
}
else {
	@natcasesort($dirs); 
	@natcasesort($files);
}


if($_GET['order']=="desc" && $_GET['sort']!="size") {$dirs = @array_reverse($dirs);}
if($_GET['order']=="desc") {$files = @array_reverse($files);}
$dirs = @array_values($dirs); $files = @array_values($files);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1257" />
<title>Failai <?=dirname($_SERVER['PHP_SELF']).'/'.$leadon;?></title>
<link rel="stylesheet" type="text/css" href="dlf/styles.css" />
<?
if($showthumbnails) {
?>
<script language="javascript" type="text/javascript">
<!--
function o(n, i) {
	document.images['thumb'+n].src = 'dlf/i.php?f='+i;

}

function f(n) {
	document.images['thumb'+n].src = 'dlf/trans.gif';
}
//-->
</script>
<?
}
?>
</head>
<body>
<div id="container">
  <h1>Failai <?=dirname($_SERVER['PHP_SELF']).'/'.$leadon;?></h1>
  <div id="breadcrumbs"> <a href="<?=$_SERVER['PHP_SELF'];?>">Pagrindinis</a><br /><a href="<?=$backtositeurl;?>"><b>Grįžti į saitą</b></a>
  <?
 	 $breadcrumbs = split('/', $leadon);
  	if(($bsize = sizeof($breadcrumbs))>0) {
  		$sofar = '';
  		for($bi=0;$bi<($bsize-1);$bi++) {
			$sofar = $sofar . $breadcrumbs[$bi] . '/';
			echo ' &gt; <a href="'.$_SERVER['PHP_SELF'].'?dir='.urlencode($sofar).'">'.$breadcrumbs[$bi].'</a>';
		}
  	}
  
	$baseurl = $_SERVER['PHP_SELF'] . '?dir='.$_GET['dir'] . '&amp;';
	$fileurl = 'sort=name&amp;order=asc';
	$sizeurl = 'sort=size&amp;order=asc';
	$dateurl = 'sort=date&amp;order=asc';
	
	switch ($_GET['sort']) {
		case 'name':
			if($_GET['order']=='asc') $fileurl = 'sort=name&amp;order=desc';
			break;
		case 'size':
			if($_GET['order']=='asc') $sizeurl = 'sort=size&amp;order=desc';
			break;
		case 'date':
			if($_GET['order']=='asc') $dateurl = 'sort=date&amp;order=desc';
			break;  
		default:
			$fileurl = 'sort=name&amp;order=desc';
			break;
	}
  ?>
  </div>
  <div id="listingcontainer">
    <div id="listingheader"> 
	<div id="headerfile"><a href="<?=$baseurl . $fileurl;?>">Failas</a></div>
	<div id="headersize"><a href="<?=$baseurl . $sizeurl;?>">Dydis</a></div>
	<div id="headermodified"><a href="<?=$baseurl . $dateurl;?>">Data</a></div>
	</div>
    <div id="listing">
	<?
	$class = 'b';
	if($dirok) {
	?>
	<div><a href="<?=$_SERVER['PHP_SELF'].'?dir='.urlencode($dotdotdir);?>" class="<?=$class;?>"><img src="dlf/dirup.png" alt="Folder" /><strong>..</strong> <em>-</em> <?=date ("Y-m-d h:i:s", filemtime($dotdotdir));?></a></div>
	<?
		if($class=='b') $class='w';
		else $class = 'b';
	}
	$arsize = sizeof($dirs);
	for($i=0;$i<$arsize;$i++) {
	?>
	<div><a href="<?=$_SERVER['PHP_SELF'].'?dir='.urlencode($leadon.$dirs[$i]);?>" class="<?=$class;?>"><img src="dlf/folder.png" alt="<?=$dirs[$i];?>" /><strong><?=$dirs[$i];?></strong> <em>-</em> <?=date ("Y-m-d h:i:s", filemtime($leadon.$dirs[$i]));?></a></div>
	<?
		if($class=='b') $class='w';
		else $class = 'b';	
	}
	
	$arsize = sizeof($files);
	for($i=0;$i<$arsize;$i++) {
		$icon = 'unknown.png';
		$ext = strtolower(substr($files[$i], strrpos($files[$i], '.')+1));
		$supportedimages = array('gif', 'png', 'jpeg', 'jpg');
		$thumb = '';
		
		if($showthumbnails && in_array($ext, $supportedimages)) {
			$thumb = '<span><img src="dlf/trans.gif" alt="'.$files[$i].'" name="thumb'.$i.'" /></span>';
			$thumb2 = ' onmouseover="o('.$i.', \''.urlencode($leadon . $files[$i]).'\');" onmouseout="f('.$i.');"';
			
		}
		
		if($filetypes[$ext]) {
			$icon = $filetypes[$ext];
		}
		
		$filename = $files[$i];
		if(strlen($filename)>43) {
			$filename = substr($files[$i], 0, 40) . '...';
		}
		
		$fileurl = $leadon . $files[$i];
		if($forcedownloads) {
			$fileurl = $_SESSION['PHP_SELF'] . '?dir=' . urlencode($leadon) . '&download=' . urlencode($files[$i]);
		}

	?>
	<div><a href="<?=$fileurl;?>" class="<?=$class;?>"<?=$thumb2;?>><img src="dlf/<?=$icon;?>" alt="<?=$files[$i];?>" /><strong><?=$filename;?></strong> <em><?=round(filesize($leadon.$files[$i])/1024);?>KB</em> <?=date ("Y-m-d h:i:s", filemtime($leadon.$files[$i]));?><?=$thumb;?></a></div>
	<?
		if($class=='b') $class='w';
		else $class = 'b';	
	}	
	?></div>
	</div>
</div>
</body>
</html>
