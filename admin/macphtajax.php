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
require_once('../../../../wp-load.php');

$dbtoken = md5(DB_NAME);
$token = trim($_REQUEST["token"]);

if($dbtoken != $token ){
    die("You are not authorized to access this file");
}
require_once(dirname(dirname(__FILE__)) . '/asgallDirectory.php');

$maceditId = $_REQUEST['macEdit'];
$site_url = get_bloginfo('url');
$uploadDir = wp_upload_dir();
$path = $uploadDir['basedir'].'/apptha-slider-gallery';
?>
<?php
 if($_REQUEST['macdeleteId'] != '')
 {
    $asgallPhoto_id = $_REQUEST['macdeleteId'];   
    $deletePhoto  = $wpdb->get_results("UPDATE " . $wpdb->prefix . "asgallphotos  SET `is_delete` = 1 WHERE asgallPhoto_id='$asgallPhoto_id'");
    $photoAlbid    = $wpdb->get_var("SELECT  asgallAlbum_id FROM " . $wpdb->prefix . "asgallphotos WHERE asgallPhoto_id='$asgallPhoto_id' ");
    $total1 = $wpdb->get_results("SELECT asgallPhoto_id FROM  " . $wpdb->prefix . "asgallphotos   WHERE asgallAlbum_id = $photoAlbid AND  is_delete = 0  ",ARRAY_A);
									
								$stop =  count($total1 ); 
								
								for($i = 0 ; $i< $stop ; $i++ )
								{
									 $id =	$total1[$i]['asgallPhoto_id'];
								  $sql = "UPDATE " . $wpdb->prefix . "asgallphotos  SET  asgallPhoto_sorting =   $i  WHERE asgallPhoto_id = $id"  ;
								    
									$wpdb->query($sql);
									
								}
}
  else if(($_REQUEST['asgallPhoto_desc']) != '')
 {
     $asgallPhoto_desc = $_REQUEST['asgallPhoto_desc'] ;
     $asgallPhoto_id   = $_REQUEST['asgallPhoto_id'];
     $sql = $wpdb->query("UPDATE " . $wpdb->prefix . "asgallphotos SET `asgallPhoto_desc` = '$asgallPhoto_desc' WHERE `asgallPhoto_id` = '$asgallPhoto_id'");
 echo $asgallPhoto_desc;
 }
  else if($_REQUEST['macdelAlbum'] != '')
 {
        $asgallAlbum_id = $_REQUEST['macdelAlbum'];
        $alumImg = $wpdb->get_var("SELECT asgallAlbum_image FROM " . $wpdb->prefix . "asgallAlbum WHERE asgallAlbum_id='$asgallAlbum_id' ");
        $delete = $wpdb->query("DELETE FROM " . $wpdb->prefix . "asgallAlbum WHERE asgallAlbum_id='$asgallAlbum_id'");
        $path1 = "$path/";
        unlink($path1.$alumImg);
        $extense = explode('.', $alumImg);
        unlink($path1.$asgallAlbum_id.'alb.'.$extense[1]);
        //Photos respect to album deleted
        $photos  =$wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "asgallphotos WHERE asgallAlbum_id='$asgallAlbum_id' ");

        foreach ($photos as $albPhotos)
        {

        $asgallPhoto_id = $albPhotos->asgallPhoto_id;
        $photoImg    = $wpdb->get_var("SELECT asgallPhoto_image FROM " . $wpdb->prefix . "asgallphotos WHERE asgallPhoto_id='$asgallPhoto_id' ");
        $deletePhoto  = $wpdb->get_results("DELETE FROM " . $wpdb->prefix . "asgallphotos WHERE asgallPhoto_id='$asgallPhoto_id'");
        $path1 = "$path/";
            unlink($path1 . $photoImg);
            $extense = explode('.', $photoImg);
            unlink($path1 . $asgallPhoto_id . '.' . $extense[1]);
        }
 }
  else if($_REQUEST['macedit_phtid'] != '')
 {
   	  $macedit_name = strip_tags($_REQUEST['macedit_name']);
   	  $macedit_name = preg_replace("/[^a-zA-Z0-9\/_-\s]/", '', $macedit_name);
      $macedit_desc = strip_tags($_REQUEST['macedit_desc']);      
      $macedit_id   = $_REQUEST['macedit_phtid'];
      if(is_int($macedit_id)){
      $sql = $wpdb->get_results("UPDATE " . $wpdb->prefix . "asgallphotos SET `asgallPhoto_name` = '$macedit_name', `asgallPhoto_desc` = '$macedit_desc' WHERE `asgallPhoto_id` = '$macedit_id'");                        
      echo "success";
      }
 }
?>