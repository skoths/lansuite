<?php
if ($_GET['design'] != 'popup' and $db->success and !$_SESSION['lansuite']['fullscreen'] and $_GET['action'] != 'wizard' and in_array('sponsor', $ActiveModules)) {
  $banner = $db->qry_first("SELECT sponsorid, pic_path_banner, url, name
    FROM %prefix%sponsor
    WHERE rotation AND ((pic_path != '' AND pic_path != 'http://') OR pic_path_banner != '')
    ORDER BY RAND()");

  $file_name = '';
  $old_file_name = 'ext_inc/banner/banner_'. substr($banner['pic_path'], strrpos($banner["pic_path"], 'ext_inc/banner/') + 15, strlen($banner['pic_path']));

  if ($banner['sponsorid']) $db->qry("UPDATE %prefix%sponsor SET views_banner = views_banner + 1 WHERE sponsorid = %int%", $banner['sponsorid']);

  // If no specific rotation banner is given, use the banner from the sponsor page
  if ($banner['pic_path_banner'] == '' and file_exists($old_file_name)) $file_name = $old_file_name;
  else $file_name = $banner['pic_path_banner'];

  // If no Banner-Thumb was found, use LanSuite default banner
  if ($file_name == '') $file_name = 'ext_inc/banner/one_network_banner.jpg';

  // If entry is HTML-Code
  if (substr($file_name, 0, 12) == 'html-code://') $smarty->assign('MainBanner', $func->AllowHTML(substr($file_name, 12, strlen($file_name) - 12)));
  else {
  	$code = '<img src="'. $file_name .'" border="1" width="468" height="60" class="img_border" title="'. $banner['name'] .'" alt="Sponsor Banner"/>';

  	// Link banner, if in online mode
  	if ($cfg['sys_internet']) $code = '<a href="index.php?mod=sponsor&amp;action=bannerclick&amp;design=base&amp;type=banner&amp;sponsorid='. $banner["sponsorid"] .'" target="_blank">'. $code .'</a>';
  	
  	$smarty->assign('MainBanner', $code);
  }
}
?>
