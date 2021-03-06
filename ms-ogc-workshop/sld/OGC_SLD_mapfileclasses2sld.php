<?php

//
// $Id: OGC_SLD_mapfileclasses2sld.php,v 1.5 2007-03-08 01:36:33 tkralidi Exp $
//
// load mapscript
// check what OS this is running on
if (PHP_OS == "WINNT" || PHP_OS == "WIN32") {
  $dlext = "dll";
}
else {
  $dlext = "so";
}

if (!extension_loaded("MapScript")) {
  dl("php_mapscript.$dlext");
}

// required SWIG include (contains constants for PHP7)
include("C:/ms4w/apps/phpmapscriptng-swig/include/mapscript.php");

// instantiate a new Map Object
// with the mapfile as an argument
$oMap = new mapObj("C:/ms4w/apps/ms-ogc-workshop/sld/demo.map");

// output an OGC:SLD document
$sldString = $oMap->generatesld();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="pragma" content="no-cache"/>
	<meta http-equiv="Expires" content="Thu, 01 Dec 1994 120000 GMT"/>
	<head>
		<title>MapServer OGC:SLD Example</title>
	</head>
	<body bgcolor="#ffffff">
		<table align="center" border="0">
			<tr>
				<td colspan="2">MapServer OGC:SLD Example</td>
			</tr>
		</table>
		<hr noshade/>
		<table align="center" border="1">
			<tr>
				<th>Input Mapfile</th>
				<!--<td><a title="Input Mapfile" href="demo.map">demo.map</a></td>-->
				<td><iframe width="800" height="200" src="demo.map"></iframe></td>
			</tr>
			<tr>
				<th>Mapscript code:</th>
				<td>
					<pre>
// load mapscript
dl("php_mapscript.dll");

// required SWIG include (contains constants for PHP7)
include("C:/ms4w/apps/phpmapscriptng-swig/include/mapscript.php");

// instantiate a new Map Object
// with the mapfile as an argument
$oMap = new mapObj("C:/ms4w/apps/ms-ogc-workshop/sld/demo.map");

// generate an SLD into a string variable
$sldString = $oMap->generatesld();

// print out the SLD
// or do whatever with it
echo $sldString;
					</pre>
				</td>
			</tr>
			<tr>
				<th>Output OGC:SLD Document</th>
				<td><textarea rows="25" cols="100"><? echo $sldString?></textarea></td>
			</tr>
		</table>
	</body>
</html>
