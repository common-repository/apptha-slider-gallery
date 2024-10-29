<?php
/*
 ***********************************************************/
/**
 * @name          : Slider Gallery.
 * @version	      : 1.1
 * @package       : apptha
 * @subpackage    : slider_gallery
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license	      : GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract      : The core file of calling AsgallSlider.
 * @Creation Date : June 20 2011
 * @Modified Date : July 16 2011
 * */

/*
 ***********************************************************/

/*The Common load file for the plugin */

require_once( dirname(__FILE__) . '/asgallDirectory.php');

$timg =  $_REQUEST['imgname'];
$pluginname =  'apptha-slider-gallery'; 
$file = dirname(dirname(dirname(__FILE__)))."/uploads/".$pluginname."/".$timg;
$fileExt = '';
$allowedExtensions = array("jpg", "jpeg", "png", "gif");
 if(preg_grep( "/$filepart[1]/i" , $allowedExtensions )){
 	$fileExt = true;
 }

if(file_exists($file) && (count($filepart) === 2) && $fileExt == '1'){
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($file));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
ob_clean();
flush();
readfile($file);
 }else{
 	die("No direct access");
 }  

?>
