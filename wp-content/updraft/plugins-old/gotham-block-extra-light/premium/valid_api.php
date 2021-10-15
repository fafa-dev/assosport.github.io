<?php 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

$ghostpremium_doubleface = false;
$ghostpremium_home_url = get_home_url();
$ghostpremium_home_url = str_replace("https://", "", $ghostpremium_home_url);
$ghostpremium_home_url = str_replace("http://", "", $ghostpremium_home_url);
$ghostpremium_home_url = str_replace("www.", "", $ghostpremium_home_url);

$ghostpremium_unik = base64_encode($ghostpremium_home_url);
$ghostpremium_unik = preg_replace("/[^a-zA-Z0-9]/", "", $ghostpremium_unik);

if ( is_multisite() ) {
	
	$ghostpremium_iddusite = get_current_blog_id();
	$ghostpremium_lkey = "$ghostpremium_unik-NJD54-$ghostpremium_iddusite";
	
} else {
	
	$ghostpremium_lkey = "SJFEDD54-$ghostpremium_unik";
	
}

$ghostpremium_cookie_token = GOTHAMBKOCKADBLOCK_ROOTPATH . "temp/token-$ghostpremium_lkey.json";
$ghostpremium_newjeton = false;

// L'URL est-elle bien déclarée
$ghostpremium_url = get_site_url(); 

function ghostpremium_check_site_current_url ($url) {
	$url = str_replace("https://", "", $url);
	$url = str_replace("http://", "", $url);
	$url = str_replace("www.", "", $url);
	
	if (substr($url, -1) == '/') {
		$url = substr($url,0,strlen($url)-1);
	}
	
	return $url;
}

$ghostpremium_choppezla = ghostpremium_check_site_current_url($ghostpremium_url);	

	
// On vire le cache token quand on update la clé API
function check_licence_update_ghostpremium(){

		global $ghostpremium_cookie_token;
		
		if (file_exists($ghostpremium_cookie_token)) { // S'il existe
			unlink ($ghostpremium_cookie_token);
		}
		
		check_kapsuleapi_ghostpremium_licence();
		
}

// On check si API valide
function check_kapsuleapi_ghostpremium_licence() {
	
	/*

	global $ghostpremium_doubleface;
	global $ghostpremium_cookie_token;
	global $ghostpremium_newjeton;
	global $ghostpremium_choppezla;

	 // Si le fichier existe et (qu'il a + de 6H OU qu'il est vide) 
	if (file_exists($ghostpremium_cookie_token) && (( time() - 21600 > filemtime($ghostpremium_cookie_token)) OR ( 0 == filesize($ghostpremium_cookie_token) ) OR ($ghostpremium_newjeton == true))) { 
	
		unlink ($ghostpremium_cookie_token); // On l'efface
		
	}

	if (file_exists($ghostpremium_cookie_token)) {
		
		// Si le fichier de cache existe deja
		$kapsdata = @file_get_contents($ghostpremium_cookie_token); // On charge le fichier de cache
		$kapsdata_array = json_decode($kapsdata, true);
		if ($kapsdata_array['token'] == 'KISh8sUJD5848gkfoSKKSuS' AND $kapsdata_array['acces'] == 'true') {
				if ($kapsdata_array['limit'] == 'premium') {$statut="premium";}
				elseif ($kapsdata_array['limit'] == 'godmod') {$statut="godmod";}
				else {$statut="free";}
			} 
			else {$statut="Erreur";}
		return $statut;
		
	} else {
		
		$jokerjeton = get_option('gothamadblock_option_apijeton');
		$urlcheckapi = "aHR0cHM6Ly9nb3RoYW1hem9uLmNvbS9saWNlbmNlLnBocD90b2tlbj0";
		$urlcheckapi = base64_decode($urlcheckapi);
		$api_endpoint = "$urlcheckapi$jokerjeton&url=$ghostpremium_choppezla";
		$kapsdata = wp_remote_get($api_endpoint);
		
			if ( is_array( $kapsdata ) && ! is_wp_error( $kapsdata ) ) { // Empeche une erreur fatale en cas d'impossibilité de récupérer le flux
				$kapsdata_array = json_decode($kapsdata["body"], true);
				
				if( is_wp_error( $kapsdata  ) || !isset($kapsdata["body"]) || $kapsdata["response"]["code"] != 200 || $kapsdata_array['token'] != 'KISh8sUJD5848gkfoSKKSuS' || $kapsdata_array['acces'] != 'true') 	{
					
					$statut="Erreur";
					
				} else {
					
					if ($kapsdata_array['limit'] == 'premium') {$statut="premium";}
					elseif ($kapsdata_array['limit'] == 'godmod') {$statut="godmod";}
					else {$statut="free";}
					
					$kakabody = $kapsdata["body"];
					
					if ((!empty($ghostpremium_cookie_token)) AND (!empty($kakabody))) 
					{
						file_put_contents($ghostpremium_cookie_token , $kakabody);
					}
					
				} // On crée le cache
				
			} else {
				
				$statut="cUrl"; // Impossible de se connecter au serveur Gothamazon / Bug CUrl
				
			}
			
		return $statut;
	}*/
	
	return "FREETRIAL";
}