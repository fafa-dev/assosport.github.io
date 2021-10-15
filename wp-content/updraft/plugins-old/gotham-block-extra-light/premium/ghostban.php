<?php 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

function gtbadb_ghostban( $atts, $content = null, $tag = '') {
	
	// On récupère les attributs des short code
	$a = shortcode_atts( array(
	'url' => '', 
	'image_url' => '', 
	'alt' => '',
	'target' => '', 
	'width' => '',
	'height' => '',
	'cloaking' => '', 
	), $atts );

	$url = esc_attr( $a['url'] );
	$image_url = esc_attr( $a['image_url'] );
	$alt = esc_attr( $a['alt'] );
	$target = esc_attr( $a['target'] );
	$width = esc_attr( $a['width'] );
	$height = esc_attr( $a['height'] );
	$cloaking = esc_attr( $a['cloaking'] );
	
	
	if (empty($url)) {
		return;
	}
	
	if (empty($image_url)) {
		return;
	}
	
	// Creation des variables de stockage d'image
	$urlpics2unikey = base64_encode($image_url);
	$upload_dir_url = wp_get_upload_dir();
	$kapsule_dirstokage_p = $upload_dir_url["basedir"];
	$kapsule_dirstokage_pics = $kapsule_dirstokage_p . '/ghostpics_pics';
	$kapsule_dirstokage_pics_final = $kapsule_dirstokage_pics. '/'. $urlpics2unikey;
	
	// Création du Chemin HTTP Upload Images
	$upload_dir_url_chemin_http = $upload_dir_url["baseurl"];
	$upload_dir_url_chemin_http_full = $upload_dir_url_chemin_http. '/ghostpics_pics';
	$upload_dir_url_chemin_http_full_final = $upload_dir_url_chemin_http_full. '/'. $urlpics2unikey;
	
	if (! is_dir($kapsule_dirstokage_pics)) {
			mkdir( $kapsule_dirstokage_pics, 0755 );
	}
	
	if (file_exists($kapsule_dirstokage_pics_final)) { 
		
		if (file_exists($kapsule_dirstokage_pics_final) && (( time() - 86400 > filemtime($kapsule_dirstokage_pics_final)) OR ( 0 == filesize($kapsule_dirstokage_pics_final) ))) {  
			unlink ($kapsule_dirstokage_pics_final); // On l'efface
			if (!copy($image_url, $kapsule_dirstokage_pics_final)) {
				$upload_dir_url_chemin_http_full_final = $image_url; // Le Serveur distant bloque la copie, donc on ne cloak pas la source de l'image pour que ça marche au moins pour les non-adblock
			};
		}
		
	} else {
		
		if (!copy($image_url, $kapsule_dirstokage_pics_final)) {
				$upload_dir_url_chemin_http_full_final = $image_url; // Le Serveur distant bloque la copie, donc on ne cloak pas la source de l'image pour que ça marche au moins pour les non-adblock
		};
		
	}

	// Gestion du ALT
	if (!empty($alt)) {
		
		$io_alt = 'alt="'. $alt .'"';
		
	} else {
		
		$io_alt = NULL;
		
	}
	
	// Gestion du target
	if ($target != "self") {
		
		$io_target = 'target="_blank"';
		
	} else {
		
		$io_target = NULL;
		
	}
	
	// Gestion du Width
	if (!empty($width)) {
		
		$io_width = 'width="'. $width .'"';
		
	} else {
		
		$io_width = NULL;
		
	}
	
	// Gestion du Height 
	if (!empty($height)) {
		
		$io_height = 'height="'. $height .'"';
		
	} else {
		
		$io_height = NULL;
		
	}
	
	if ($cloaking == "yes") {
		
		$url_encoded =  base64_encode($url);
		$balise1 = '<span class="kamesen" datasin="'. $url_encoded. '" style="cursor:pointer;">';
		$balise2 = '</span>';
		
	} else {
		
		$balise1 = '<a href="'. $url. '" '. $io_target. '>';
		$balise2 = '</a>';
		
	}
	$output = $balise1.'<img src="'. $upload_dir_url_chemin_http_full_final. '" '. $io_width. ' '. $io_height. ' '. $io_alt. '>'.$balise2;
					

return $output;

}

add_shortcode( 'ghostban', 'gtbadb_ghostban' );