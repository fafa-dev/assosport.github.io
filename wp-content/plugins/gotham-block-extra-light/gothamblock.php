<?php
/**
 * @package Gotham Block Extra Light
 * @version 1.4.1
 */
/*
Plugin Name: Gotham Block Extra Light
Description: 🇬🇧 ULTRA Light plugin to inform your visitors that ad blockers are killing the viability of your site, and invite them to deactivate them 🇫🇷 Plugin ULTRA Léger pour informer tout simplement vos visiteurs que les bloqueurs de publicité tuent la viabilité de votre site, et les invite à les désactiver.
Version: 1.4.1
Author: Kapsule Network
Author URI: https://www.kapsulecorp.com/
License: GPLv2
*/

if ( ! defined( 'ABSPATH' ) )
	exit;

define('GOTHAMBKOCKADBLOCK_ROOTPATH', plugin_dir_path( __FILE__ )); // Chemin Serveur

//////////////////////
// Check PREMIUM //
$needpremium = get_option('gothamadblock_option_premium_tools');
require_once(GOTHAMBKOCKADBLOCK_ROOTPATH.'/premium/valid_api.php');
// Si on a besoin de fonctions PREMIUM => Test de la Validité de la licence //

if ($needpremium == "oui") {
	
	$ghostpremium_doubleface = false;
	$ghostpremium_doubleface = check_kapsuleapi_ghostpremium_licence();

	if ($ghostpremium_doubleface == "cUrl") {
		
		$msgerreur = "Votre serveur n'arrive pas à se connecter à notre API - cURL error 28: Operation timed out - L'erreur semble venir de votre solution d'hébergement car tout fonctionne du côté des serveurs de Gotham Block Adblock";
		$ghostpremium_doubleface = false;
		
	} elseif ($ghostpremium_doubleface == "Erreur") {
		
		$msgerreur = "Votre serveur n'arrive pas à se connecter à notre API"; 
		$ghostpremium_doubleface=false;
		
	 } else {
		 
		 $msgerreur = "";
		 
	}

	define('KINGBOO', $ghostpremium_doubleface); // API ACTIVE ou NON
	
} else {
	
	define('KINGBOO', false);
	
}
// ! Check PREMIUM //
///////////////////////////

// Est-on en pause ?
$gothamadblock_option_fury = get_option('gothamadblock_option_fury');

if ( ($gothamadblock_option_fury != "paused") AND (!is_admin()) ){ // Si on est pas en pause // Ni en mode admin (ce qui créé un confit avec les nouveaux block widgets)
	
	// Est-on en mode FURY ou non ?
	if (($gothamadblock_option_fury == "ssj2") OR ($gothamadblock_option_fury == "ssj3")) { $agressive_mode = true;} else {$agressive_mode = false;}
	//////////////////////////////

	if ((!isset($_COOKIE['gothamadblock_last_visit_time'])) OR ($agressive_mode == true)) { // Si Pas de Cookie ou Si Mode Agressif activé on affiche la Popup

	// On ajoute le Honey Pot

		/*
		////////////////////////////////////////////////////
		Version avec Ads.js////////////////////////////////
		//////////////////////////////////////////////////
		
		function gothamadblock_register_my_scripts() {
			wp_register_script( 'gothamhoneypot', plugins_url( '/ads.js', __FILE__ ) );
			wp_enqueue_script( 'gothamhoneypot' );
		}
		add_action( 'wp_enqueue_scripts', 'gothamadblock_register_my_scripts', 0 );*/
		
		// Popup si Honeypot bloqué par un Adblocker
		function gothamadblock_mapop() {
			$defopiks = plugin_dir_url( __FILE__ ).'stop.png';
			$igotit = plugin_dir_url( __FILE__ ).'ok.png';
			echo '<script>
			  function gothamadblock_myClosePop() {
				  var mes = document.getElementById("gothamadblock_msg");
				  var over = document.getElementById("gothamadblock_overlayh_n");
				  mes.style.display = "none";
				  over.style.display = "none";
				  document.body.classList.remove("gtmab_leviator");
			  }
			  function gothamadblock_myClosePopSSJ() {
				  window.location.reload()
			  }
			  </script>';


			//////////// Si pas de message personnalisé

							$gothamadblock_option_messageperso_title = get_option('gothamadblock_option_messageperso_title');
							if ($gothamadblock_option_messageperso_title == "") {
										//////////// Zone de Test Langage
											$lang   = '';
											if ( 'fr_' === substr( get_user_locale(), 0, 3 ) ) {
												
												$popup_title = "Adblock détecté";
												
											} else {
												
												$popup_title = "Adblock Detected";
												
											}

										//////////// !Zone de Test Langage
							} else {
								
								$popup_title = $gothamadblock_option_messageperso_title;
							
							}

							$gothamadblock_option_messageperso = get_option('gothamadblock_option_messageperso');
							if ($gothamadblock_option_messageperso == "") {
										//////////// Zone de Test Langage
											$lang   = '';
											if ( 'fr_' === substr( get_user_locale(), 0, 3 ) ) {
												$mon_texte_sensibilisation = "<p><u>Ce site internet ne peut exister que grâce à la présence de publicité</u>.<br />Merci de <strong>couper votre logiciel Adblock</Strong> sur ce site et de cliquer sur le bouton j'ai compris.</p>";
											}
											else {
												$mon_texte_sensibilisation = "<p><u>This website can only exist thanks to the presence of advertising</u>.<br />Please <strong>deactivate your Adblock</Strong> software on this site and click on the button I understood.</p>";
											}

										//////////// !Zone de Test Langage
							}
							else {
							$mon_texte_sensibilisation = $gothamadblock_option_messageperso;
							$mon_texte_sensibilisation = wpautop($mon_texte_sensibilisation); // Conversion des sauts de ligne pour corriger le bug du saut de ligne
							}

							$gothamadblock_option_messageperso_button = get_option('gothamadblock_option_messageperso_button');
							if ($gothamadblock_option_messageperso_button == "") {
										//////////// Zone de Test Langage
											$lang   = '';
											if ( 'fr_' === substr( get_user_locale(), 0, 3 ) ) {
												$popup_ctatext = "J'ai compris";
											}
											else {

												$popup_ctatext = "I Understood";
											}
										//////////// !Zone de Test Langage
							}
							else {
							$popup_ctatext = $gothamadblock_option_messageperso_button;
							}

			// Est-on en SSJ3 ? Si oui la popup recharge la page et donc revérifie si le adblock est bien coupé, sinon cela coupe la popup.
			$gothamadblock_option_fury = get_option('gothamadblock_option_fury');
			if ($gothamadblock_option_fury == "ssj3") {$janemba="gothamadblock_myClosePopSSJ()";} else {$janemba="gothamadblock_myClosePop()";}
			
			// Construction de la Popup
			$cestbononatout_onconstruit = "<div id='gothamadblock_msg' style='display:block;'><h2>$popup_title</h2><img src='$defopiks' alt='Oing' height='300' width='300' />$mon_texte_sensibilisation<button id='gtab_mehn' onclick='$janemba'>$popup_ctatext</button></div><div id='gothamadblock_overlayh_n' style='display:block;'></div>"; 
			$cestbononatout_onconstruit = str_replace(array("\n", "\r\n", "\r", "\t", "    "), "", $cestbononatout_onconstruit); // On vire tous les sauts de ligne

			
			 // Si bloqué on affiche la popup en JS
			 /* Mécanisme inspiré d'un script de AdGlare Ad Server */
			echo "
			<script>
				function gothamBatAdblock() {
					var a = document.createElement('div');
					a.innerHTML = '&nbsp;';
					a.className = 'gothamads publicite 300x250 text-ad text_ad text_ads text-ads pub_728x90 textAd text-ad-links adsbox moneytizer';
					a.style = 'position: absolute !important; width: 0!important; height: 1px !important; left: -1000px !important; top: -10000px !important;';
					var r = false;
					try {
						document.body.appendChild(a);
						var e = document.getElementsByClassName('gothamads')[0];
						if(e.offsetHeight === 0 || e.clientHeight === 0) r = true;
						if(window.getComputedStyle !== undefined) {
							var tmp = window.getComputedStyle(e, null);
							if(tmp && (tmp.getPropertyValue('display') == 'none' || tmp.getPropertyValue('visibility') == 'hidden')) r = true;
						}
						document.body.removeChild(a);
					} catch (e) {}
					return r;
				}
		   if(gothamBatAdblock()) {
		   document.write(\"$cestbononatout_onconstruit\");
			document.body.classList.add('gtmab_leviator');
		  } 
			</script>";

			  // Si bloqué on affiche le CSS
			echo "<style type='text/css'>
				.gtmab_leviator {height:100%;overflow:hidden;}
				#gothamadblock_msg{position:fixed;width:800px;margin:0 auto;background:#fff;height:auto;display:block;float:left;z-index:99999999;text-align:center;left:50%;top:50%;transform:translate(-50%,-50%);border-radius:8px;border:4px solid orange;padding:40px 0!important;}#gothamadblock_msg img{width:150px;height:150px;margin:20px auto!important;clear:both}#gothamadblock_msg h2{font-weight:700!important;font-family:arial!important;padding:10px 0!important;font-size:26px!important;}#gothamadblock_msg p{margin:30px 0!important;}button#gtab_mehn {cursor:pointer;display: inline-block;text-align: center;vertical-align: middle;padding: 12px 24px;border: 1px solid #4443cf;border-radius: 8px;background: #807eff;background: -webkit-gradient(linear, left top, left bottom, from(#807eff), to(#4443cf));background: -moz-linear-gradient(top, #807eff, #4443cf);background: linear-gradient(to bottom, #807eff, #4443cf);font: normal normal bold 20px arial;color: #ffffff;text-decoration: none;}button#gtab_mehn:focus,button#gtab_mehn:hover{border:1px solid ##504ff4;background:#9a97ff;background:-webkit-gradient(linear,left top,left bottom,from(#9a97ff),to(#5250f8));background:-moz-linear-gradient(top,#9a97ff,#5250f8);background:linear-gradient(to bottom,#9a97ff,#5250f8);color:#fff;text-decoration:none}button#gtab_mehn:active{background:#4443cf;background:-webkit-gradient(linear,left top,left bottom,from(#4443cf),to(#4443cf));background:-moz-linear-gradient(top,#4443cf,#4443cf);background:linear-gradient(to bottom,#4443cf,#4443cf)}button#gtab_mehn:before{content:'';display:inline-block;height:24px;width:24px;line-height:24px;margin:0 4px -6px -4px;position:relative;top:0;left:-3px;background:url($igotit) no-repeat left center transparent;background-size:100% 100%}#gothamadblock_overlayh_n{position:fixed;width:100%;margin:0 auto;opacity:.8;background:#000;height:100%;display:block;float:left;z-index:99999998;top:0;}
				@media only screen and (max-width: 1024px){#gothamadblock_msg{position:fixed;width:90%;margin:0 auto;background:#fff;height:auto;display:block;float:left;z-index:99999999;text-align:center;left:50%;top:50%;transform:translate(-50%,-50%);border-radius:8px;border:4px solid orange;padding:10px;}}@media only screen and (max-width: 767px){#gothamadblock_msg img {width:100px;height:100px;}#gothamadblock_msg {padding:10px!important;}}
				</style>";
			}

			// On lance le plugin
			function gothamadblock_gothamkill() {
				$chosen = gothamadblock_mapop();
				}
			add_action( 'wp_footer', 'gothamadblock_gothamkill' );
	}


	// On dépose un cookie 
	add_action( 'init', 'gothamadblock_add_Cookie' );
	function gothamadblock_add_Cookie() {
		if (!isset($_COOKIE['gothamadblock_last_visit_time'])) { // Si un cookie n'est pas déjà en place et le délai afférant entrain de courir
		$tempsdecuisson = get_option('gothamadblock_option_cookietime'); // On récupère la durée voulue
		if ((empty($tempsdecuisson)) OR ($tempsdecuisson=="")) {$tempsdecuisson=2592000;} // Si paramétrage de la durée de vie du cookie vide, on fixe à 30 jours par défaut
		setcookie("gothamadblock_last_visit_time", "1", time()+$tempsdecuisson, "/"); // On pose le cookie
		}
	}
}

//////////////////////////////////////////////////////////////////////////////////////
// Création du Copyrighting
//////////////////////////////////////////////////////////////////////////////////////
$gothamadblock_option_powered_check = get_option('gothamadblock_option_powered');
if ($gothamadblock_option_powered_check == "oui") {
		function gothamadblock_powered_seo() {
			echo "<p style='text-align:center;'>Plugin <a href='https://www.kapsulecorp.com/' target='_blank' rel='noopener'>Kapsule Corp</a></p>";
			}
		add_action( 'wp_footer', 'gothamadblock_powered_seo' );
}

//////////////////////////////////////////////////////////////////////////////////////
// Création du Menu et de l'enregistrement des options
//////////////////////////////////////////////////////////////////////////////////////

// Si c'est l'admin
if ( is_admin() ){

	///////////////////////////////////
	// On créé les options dans le SQL
	///////////////////////////////////

	function gotham_blockadblock_html_sanitize_callback ($string)
	{
		$gotham_blockadblock_allowed_html = array(
		'a' => array(
			'href' => array(),
			'title' => array(),
			'rel' => array(),
			'target' => array()
		),
		'br' => array(),
		'em' => array(),
		'strong' => array(),
		'b' => array(),
		'u' => array(),
		'strike' => array(),
		'h1' => array(
			'id' => array(),
			'class' => array(),
			'style' => array()
		),
		'h2' => array(
			'id' => array(),
			'class' => array(),
			'style' => array()
		),
		'h3' => array(
			'id' => array(),
			'class' => array(),
			'style' => array()
		),
		'h4' => array(
			'id' => array(),
			'class' => array(),
			'style' => array()
		),
		'h5' => array(
			'id' => array(),
			'class' => array(),
			'style' => array()
		),
		'p' => array(
			'id' => array(),
			'class' => array(),
			'style' => array()
		),
		'span' => array(
			'id' => array(),
			'class' => array(),
			'style' => array()
		),
		'ul' => array(
			'id' => array(),
			'class' => array(),
			'style' => array()
		),
		'ol' => array(
			'id' => array(),
			'class' => array(),
			'style' => array()
		),
		'li' => array(
			'id' => array(),
			'class' => array(),
			'style' => array()
		)
		);	
		
		return wp_kses($string,$gotham_blockadblock_allowed_html);
	}

	add_action( 'admin_init', 'gothamadblock_batarang' );
	function gothamadblock_batarang() {
		register_setting( 'gothamadblockbat-settings-group', 'gothamadblock_option_fury', 'sanitize_text_field' );
		register_setting( 'gothamadblockbat-settings-group', 'gothamadblock_option_cookietime', 'sanitize_text_field' );
		register_setting( 'gothamadblockbat-settings-group', 'gothamadblock_option_messageperso_title', 'sanitize_text_field' );
		register_setting( 'gothamadblockbat-settings-group', 'gothamadblock_option_messageperso', 'gotham_blockadblock_html_sanitize_callback' );
		register_setting( 'gothamadblockbat-settings-group', 'gothamadblock_option_messageperso_button', 'sanitize_text_field' );
		register_setting( 'gothamadblockbat-settings-group', 'gothamadblock_option_powered', 'sanitize_text_field' );
		// PREMIUM API KEY
		register_setting( 'gothamadblockbat-settings-group', 'gothamadblock_option_premium_tools', 	'sanitize_text_field' );
		register_setting( 'gothamadblockbat-settings-group', 'gothamadblock_option_apijeton', 	'sanitize_text_field' );
		add_action('admin_enqueue_scripts', 'check_licence_update_ghostpremium');
	}

	///////////////////////////////////
	// On créé le menu
	//////////////////////////////////

	add_action('admin_menu','gothamadblock_setupmenu');
	function gothamadblock_setupmenu(){
		  add_menu_page('Configuration de Gotham Block Adblock', 'G BlockAdblock', 'administrator', 'gotham-plugin', 'gothamadblock_init_cave', 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMjQgMjQiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PHBhdGggZD0iTTE2LjUsMTYuNSAgYy03LTMtOSwzLTksM2MtNS41LTItNyw0LTcsNGMwLTkuNSw0LTEzLDQtMTNzLTEsMywyLDNzMS45OTk4Njg0LTQuNSwwLTVoMC4yOTI4OTM5ICBjMC40NTI3NTI2LDAsMC44ODY5NjE1LTAuMTc5ODU1MywxLjIwNzEwNTYtMC40OTk5OTlMOC4wMDAwMDEsNy45OTk5OTk1QzguMzIwMTQ0Nyw3LjY3OTg1NTMsOC41LDcuMjQ1NjQ2NSw4LjUsNi43OTI4OTM5VjYuNSAgYzAuNSwxLjk5OTg2ODQsNSwzLDUsMHMtMy0yLTMtMnMzLjUtNCwxMy00YzAsMC02LDEuNS00LDdDMTkuNSw3LjUsMTMuNSw5LjUsMTYuNSwxNi41IiBmaWxsPSJub25lIiBzdHJva2U9IiMzMDNDNDIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIi8+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PC9zdmc+' );
	}

	///////////////////////////////////
	// On charge le JS de l'admin
	//////////////////////////////////

	function gothamadblock_monjsdansladmin() {
	echo "<style>
	.gotham_ad_wrap #logo_admin {text-align:center;background:black;color:#ac5b5b;padding:80px;border-radius:8px;}
	.gotham_ad_wrap{margin: 10px 20px 0 2px;}
	.gotham_ad_form{float: left;width: 79%;}
	.gotham_ad_credit{float: left;width:17%;background:#fff;box-shadow: 0 0 0 1px rgba(0,0,0,0.05);padding:1%;margin-left:1%;}
	#batbaseadmin tr td.libelle{font-weight:bold;width:250px;}
	#batbaseadmin input, #batbaseadmin select, #batbaseadmin textarea {width:280px;float:left;}
	.explain {background:white;box-shadow: 0 0 0 1px rgba(0,0,0,0.05);}
	.explain p{padding:10px;}
	.explain ul{padding: 0 10px;list-style: square inside;}
	.explain li{padding:10px 0;}
	.explain h3 {padding:6px 10px;border-bottom:1px solid #eee;}
	</style>";

	echo "<script>function besoindelacuisiniere(sel) {var gotham_cuisiniere_ssj = sel.value;if (gotham_cuisiniere_ssj == 'ssj1') {document.getElementById('gothamadblock_option_cookietime').style.display = 'block';} else { document.getElementById('gothamadblock_option_cookietime').style.display = 'none';}} </script><script>
		window.onload = function () {
		document.getElementById('need_premium_or_not').addEventListener('change', function () {
			if (this.value == 'oui') {
				document.getElementById('hidou').style.display = 'table-row';
			} else {
				document.getElementById('hidou').style.display = 'none';
			}
		}, false)
		};
		</script>";

	}

	add_action('admin_enqueue_scripts', 'gothamadblock_monjsdansladmin');

	// Création de la page d'options du plugin ////////////////
	function gothamadblock_init_cave(){

	///////////////////////////////////////
	/// Mini zone de langage pour l'admin
	///////////////////////////////////////

	///FRANCAIS
	if ( 'fr_' === substr( get_user_locale(), 0, 3 ) ) {
		$txt_adwin_welcome = "🦇 Bienvenue dans la BatBase 🦇";
		$txt_adwin_yes = "Oui";
		$txt_adwin_no = "Non";
		$txt_adwin_ssj1 = "SSJ1 ⚡ Light";
		$txt_adwin_ssj2 = "SSJ2 ⚡⚡ Agressive";
		$txt_adwin_ssj3 = "SSJ3 ⚡⚡⚡ Fury";
		$txt_adwin_paused = "Pause ⏸️";
		$txt_adwin_titre = "Titre personnalisé";
		$txt_adwin_corpus = "Texte personnalisé (HTML autorisé)";
		$txt_adwin_cta = "Bouton personnalisé";
		$txt_adwin_firemode = "1. Je choisis le degré d'agressivité du plugin !";
		$txt_adwin_firemode_p = "<p>Dans tous les cas, la popup informera l'internaute que bloquer les publicités tue votre buisness model et l'invitera à désactiver son adblocker. Mais vous pouvez choisir ci-dessous le comportement de la popup en fixant son degré d'agressivité selon 3 niveaux.</p><ul><li>⚡ <strong>SSJ1</strong> (Choix par défaut) : Le message ne s'affichera <u>qu'une fois tous les x minutes/heures/jours</u> (30 jours par défaut), tant que l'internaute aura un logiciel Adblock activé, mais <u>l'internaute pourra fermer la popup</u> et continuer à naviguer sur votre site normalement (<em>même avec Adblock activé</em>)</li><li>⚡⚡ <strong>SSJ2</strong> : Le message s'affichera <u>à chaque chargement de page</u>, tant que l'internaute aura un logiciel Adblock activé, cependant <u>l'internaute pourra à chaque fois fermer la popup</u> et continuer à naviguer sur votre site normalement (<em>même avec Adblock activé</em>)</li><li>⚡⚡⚡ <strong>SSJ3</strong> : Le message s'affichera <u>à chaque chargement de page</u>, et l'internaute <u>ne pourra pas naviguer sur votre site tant qu'il aura un logiciel Adblock activé</u>. ⚠️ <strong>Rends la navigation impossible avec Adblock</strong> !</li></ul>";
		$txt_adwin_mecha = "2. Je customise (<em>ou pas</em>) la popup !";
		$txt_adwin_mecha_p = "Saisissez le texte de votre choix ou laissez vide pour afficher le texte par défaut.";
		$txt_adwin_premium_title = "3. Je passes au Mode PREMIUM pour déverrouiller AntiAdblock pour les bannières";
		$txt_adwin__premium_explain = "Vous en avez marre de voir vos bannières masquées par Adblock ? Avec  le mode PREMIUM, paramétrez dans un shortcode ou dans un widget en 30 secondes : l'url de la publicité, l'url de l'image ( et en option ses dimensions, sa balise alt, sa façon de s'ouvrir, si l'url sera cloaké ou non) pour passer à travers Adblock. La bannière publicitaire sera stocké sur votre serveur et sera mise à jour toutes les 24H pour être toujours en adéquation avec les offres de l'annonceur, et ne jamais devenir une vieille bannière has-been !";
		$txt_adwin_helpkapsule = "4. Je soutiens l'éditeur de ce plugin car je suis quelqu'un de bien";
		$txt_adwin_helpkapsule_p = "En sélectionnant OUI, un lien hypertexte discret vers notre site sera inséré en bas de page de votre site.";
		$txt_adwin_helpkapsule_label = "J'accepte le deal";
		$txt_adwin_blokright_title = "Besoin d’aide ?";
		$txt_adwin_blokright_corpus_1 = "💔 Ce plugin semble parfois incompatible avec certains plugins de cache. En attendant que nous trouvions une solution, il vous faudra choisir entre eux et nous !<br /><br /> Si vous rencontrez d'autres problèmes avec cette extension, vous trouverez probablement des réponses dans ces deux pages :";
		$txt_adwin_blokright_corpus_2 = "Documentation";
		$txt_adwin_blokright_corpus_3 = "Forum de Support";
		$txt_adwin_blokright_aime = "Vous aimez cette extension ?";
		$txt_adwin_blokright_vote = "Notez nous 5/5";
		$txt_adwin_blokright_sur = "sur";
		$txt_adwin_mot_jours = "jours";

	}
	///ANGLAIS
	else {
		$txt_adwin_welcome = "🦇 Welcome to the BatBase 🦇";
		$txt_adwin_yes = "Yes";
		$txt_adwin_no = "No";
		$txt_adwin_ssj1 = "SSJ1 ⚡ Light";
		$txt_adwin_ssj2 = "SSJ2 ⚡⚡ Agressive";
		$txt_adwin_ssj3 = "SSJ3 ⚡⚡⚡ Fury";
		$txt_adwin_paused = "Pause ⏸️";
		$txt_adwin_titre = "Customized Headline";
		$txt_adwin_corpus = "Customized message (HTML allowed)";
		$txt_adwin_cta = "Customized Button";
		$txt_adwin_firemode = "1. I choose the degree of aggressiveness of the plugin";
		$txt_adwin_firemode_p = "<p>In any case, the popup will inform the user that blocking ads kills your buisness model and will invite him to deactivate his adblocker. But you can choose below the behavior of the popup by setting its degree of aggressiveness according to 3 levels.</p><ul><li>⚡ <strong>SSJ1</strong> (Default) : The message will only be displayed once every X minute/hours/days (30 days by default), as long as the user has Adblock software activated, but the user can close the popup and continue browsing your site normally (<em>even with Adblock activated</em>)</li><li>⚡⚡ <strong>SSJ2</strong> : The message will appear on each page load, as long as the user has Adblock software activated, however the user can each time close the popup and continue browsing your site normally (<em>even with Adblock activated</em>)</li><li>⚡⚡⚡ <strong>SSJ3</strong> : The message will appear on each page load, and the user will not be able to navigate on your site as long as he has Adblock software activated. <strong>⚠️This level of aggressiveness makes navigation impossible with Adblock!</strong></li></ul>";
		$txt_adwin_mecha = "2. I customize (<em>or not</em>) the popup";
		$txt_adwin_mecha_p = "Enter your text or leave blank for display the default text";
		$txt_adwin_premium_title = "3. I Subscribe to PREMIUM Mode to unlock AntiAdblock for Banners";
		$txt_adwin__premium_explain = "Are you tired of seeing your banners hidden by Adblock? With PREMIUM mode, configure in a shortcode or in a widget in 30 seconds: the url of the advertisement, the url of the image (and optionally its dimensions, its alt tag, its way of opening, if the url will be cloaked or not) to pass through Adblock. The advertising banner will be stored on your server and will be updated every 24 hours to always be in line with the advertiser's offers, and never to become an old has-been banner!";
		$txt_adwin_helpkapsule = "4. I support the editor of this plugin because I am a good person !";
		$txt_adwin_helpkapsule_p = "By selecting YES, a discreet backlink to our site will be inserted in the footer of your site.";
		$txt_adwin_helpkapsule_label = "I accept the deal";
		$txt_adwin_blokright_title = "Need help ?";
		$txt_adwin_blokright_corpus_1 = "💔 Sometimes, this plugin doesn't work with some cache plugins. Until we find a solution, you will have to choose between them and us!<br /><br /> If you have another problem with this extension, you will find answers on these two pages:";
		$txt_adwin_blokright_corpus_2 = "Documentation";
		$txt_adwin_blokright_corpus_3 = "Support Forum";
		$txt_adwin_blokright_aime = "Do you like this plugin ?";
		$txt_adwin_blokright_vote = "Rate 5/5";
		$txt_adwin_blokright_sur = "on";
		$txt_adwin_mot_jours = "days";

	}
	////////////////////////////////////////

	?>
	<div class="gotham_ad_wrap">
	  <h1 id="logo_admin"><?php echo $txt_adwin_welcome; ?></h1>

	  <div class="gotham_ad_form">
	  <form method="post" action="options.php">
	  <?php settings_fields( 'gothamadblockbat-settings-group' ); ?>
	  <?php do_settings_sections('gothamadblockbat-settings-group'); ?>


		  <table id="batbaseadmin">
				<tr class="explain">
				<td colspan="2">
			  <h3>🔥 <?php echo $txt_adwin_firemode; ?></h3>
			  <?php echo $txt_adwin_firemode_p; ?>
				</td>
				</tr>
			  <tr>
				  <td class="libelle"><label for="gothamadblock_option_fury">Fury Mode :</label></td>
				  <td>
					<?php $gothamadblock_option_fury = get_option('gothamadblock_option_fury'); ?>
					<select id="gothamadblock_option_fury" name="gothamadblock_option_fury" value="<?php echo get_option('gothamadblock_option_fury'); ?>" onchange="besoindelacuisiniere(this)">
						<option value="ssj1" <?php selected( $gothamadblock_option_fury, 'ssj1' ); ?>><?php echo $txt_adwin_ssj1; ?></option>
						<option value="ssj2" <?php selected( $gothamadblock_option_fury, 'ssj2' ); ?>><?php echo $txt_adwin_ssj2; ?></option>
						<option value="ssj3" <?php selected( $gothamadblock_option_fury, 'ssj3' ); ?>><?php echo $txt_adwin_ssj3; ?></option>
						<option value="paused" <?php selected( $gothamadblock_option_fury, 'paused' ); ?>><?php echo $txt_adwin_paused; ?></option>
					</select>
					<?php $gothamadblock_option_cookietime = get_option('gothamadblock_option_cookietime'); ?>
					<select id="gothamadblock_option_cookietime" name="gothamadblock_option_cookietime" value="<?php echo get_option('gothamadblock_option_cookietime'); ?>" <?php if ($gothamadblock_option_fury != "ssj1") { ?>style="display:none;"<?php } ?>>
						<option value="2592000" <?php selected( $gothamadblock_option_cookietime, '2592000' ); ?>>30 <?php echo $txt_adwin_mot_jours; ?> (Default)</option>
						<option value="1296000" <?php selected( $gothamadblock_option_cookietime, '1296000' ); ?>>15 <?php echo $txt_adwin_mot_jours; ?></option>
						<option value="604800" <?php selected( $gothamadblock_option_cookietime, '604800' ); ?>>7 <?php echo $txt_adwin_mot_jours; ?></option>
						<option value="172800" <?php selected( $gothamadblock_option_cookietime, '172800' ); ?>>48H</option>
						<option value="86400" <?php selected( $gothamadblock_option_cookietime, '86400' ); ?>>24H</option>
						<option value="7200" <?php selected( $gothamadblock_option_cookietime, '7200' ); ?>>2H</option>
						<option value="3600" <?php selected( $gothamadblock_option_cookietime, '3600' ); ?>>1H</option>
						<option value="1800" <?php selected( $gothamadblock_option_cookietime, '1800' ); ?>>30 min</option>
						<option value="600" <?php selected( $gothamadblock_option_cookietime, '600' ); ?>>10 min</option>
						<option value="300" <?php selected( $gothamadblock_option_cookietime, '300' ); ?>>5 min</option>
						<option value="120" <?php selected( $gothamadblock_option_cookietime, '120' ); ?>>2 min</option>
						<option value="60" <?php selected( $gothamadblock_option_cookietime, '60' ); ?>>1 min</option>	
					</select>
			  </tr>
			  
			<tr class="explain">
				<td colspan="2">
			  <h3>⚙️ <?php echo $txt_adwin_mecha; ?></h3>
			  <p><?php echo $txt_adwin_mecha_p; ?></p>
				</td>
			</tr>
			
			<tr>
				  <td class="libelle"><label for="gothamadblock_option_messageperso_title"><?php echo $txt_adwin_titre; ?> :</label></td>
				  <td><input type="text" id="gothamadblock_option_messageperso_title" name="gothamadblock_option_messageperso_title" value="<?php echo get_option('gothamadblock_option_messageperso_title'); ?>" /></td>
			  </tr>
			  <tr>
				  <td class="libelle"><label for="gothamadblock_option_messageperso"><?php echo $txt_adwin_corpus; ?> :</label></td>
				  <?php $gothamadblock_option_messageperso = get_option('gothamadblock_option_messageperso'); ?>
				<td	><textarea id="gothamadblock_option_messageperso" name="gothamadblock_option_messageperso"><?php echo esc_textarea($gothamadblock_option_messageperso); ?></textarea></td>
			  </tr>
			  <tr>
				  <td class="libelle"><label for="gothamadblock_option_messageperso_button"><?php echo $txt_adwin_cta; ?> :</label></td>
				  <td><input type="text" id="gothamadblock_option_messageperso_button" name="gothamadblock_option_messageperso_button" value="<?php echo get_option('gothamadblock_option_messageperso_button'); ?>" /></td>
			  </tr>
			 
			 
			<tr class="explain">
				<td colspan="2">
					<h3>🚀 <?php echo $txt_adwin_premium_title; ?></h3>
					<p><?php echo $txt_adwin__premium_explain; ?></p>
				</td>
			</tr>
			
			<tr>
				  <td class="libelle"><label for="gothamadblock_option_premium_tools">⭐ PREMIUM VERSION :</label></td>
				  <td>
					<?php $gothamadblock_option_premium_tools = get_option('gothamadblock_option_premium_tools'); ?>
					<select id="need_premium_or_not" name="gothamadblock_option_premium_tools" value="<?php echo get_option('gothamadblock_option_premium_tools'); ?>">
						<option value="non" <?php selected( $gothamadblock_option_premium_tools, 'non' ); ?>><?php echo $txt_adwin_no; ?></option>
						<option value="oui" <?php selected( $gothamadblock_option_premium_tools, 'oui' ); ?>><?php echo $txt_adwin_yes; ?></option>
					</select>
				  </td>
			</tr>
			<tr <?php if ($gothamadblock_option_premium_tools != "oui") {?>style="display:none"<?php } ?> id="hidou">
				 <td class="libelle">
					<label for="puipui_ghostpremium_form_option_apijeton">
						🔑 
						<dfn data-info="Essayez gratuitement cette future fonction PREMIUM (payante) en saisissant le code FREETRIAL">API KEY
							<?php
							
							$check_if_exist_licence_key_ghostpremium = get_option('gothamadblock_option_apijeton'); 
							if ($check_if_exist_licence_key_ghostpremium == NULL) {
								
								$licence_key_exist_ghostpremium = "non";
								
							} else {
								
								$licence_key_exist_ghostpremium = "oui";
								
							}

							if ($licence_key_exist_ghostpremium == "oui") { // Si le champ API Key est rempli
							
								if (KINGBOO != false) { // Si la connexion se fait
										
									echo "<span style='color:green;'>OK</span> ("; echo KINGBOO.")";
											
								} else { // Sinon, si pas de connexion
										
									echo "<br /><span style='color:red;'>⚠️ Clé Invalide</span>";
											
								} 
										
							} else {
								
								echo "<br /><span style='color:red;'>⚠️ Clé Inconnue</span>";
							}
							?>
						</dfn>
					</label>
				</td>
				<td>
					<input type="text" id="gothamadblock_option_apijeton" name="gothamadblock_option_apijeton" value="<?php echo get_option('gothamadblock_option_apijeton'); ?>" />
				</td>
			</tr>
			<tr class="explain">
				<td colspan="2">
			  <h3>💪 <?php echo $txt_adwin_helpkapsule; ?> 💪</h3>
			  <p><?php echo $txt_adwin_helpkapsule_p; ?></p>
				</td>
			</tr>
			
			<tr>
				  <td class="libelle"><label for="gothamadblock_option_powered"><?php echo $txt_adwin_helpkapsule_label; ?> :</label></td>
				  <td>
					<?php $gothamadblock_option_powered = get_option('gothamadblock_option_powered'); ?>
					<select id="gothamadblock_option_powered" name="gothamadblock_option_powered" value="<?php echo get_option('gothamadblock_option_powered'); ?>">
						<option value="non" <?php selected( $gothamadblock_option_powered, 'non' ); ?>><?php echo $txt_adwin_no; ?></option>
						<option value="oui" <?php selected( $gothamadblock_option_powered, 'oui' ); ?>><?php echo $txt_adwin_yes; ?></option>
					</select>
				  </td>
			  </tr>
		  </table>

	  <?php submit_button(); ?>
	  </form>
	  </div>
	   <div class="gotham_ad_credit">
						<h3>🦇 Gotham Adblock</h3>
						<div class="inside">
							<h4 class="inner"><?php echo $txt_adwin_blokright_title; ?></h4>
							<p class="inner"><?php echo $txt_adwin_blokright_corpus_1; ?></p>
							<ul>
								<li>- <a href="https://wordpress.org/plugins/gotham-block-extra-light/"><?php echo $txt_adwin_blokright_corpus_2; ?></a></li>
								<li>- <a href="https://wordpress.org/support/plugin/gotham-block-extra-light/"><?php echo $txt_adwin_blokright_corpus_3; ?></a></li>
							</ul>
							<hr>
							<h4 class="inner">🏆 <?php echo $txt_adwin_blokright_aime; ?></h4>
							<p class="inner">⭐ <a href="https://wordpress.org/support/plugin/gotham-block-extra-light/reviews/?filter=5#new-post" target="_blank"><?php echo $txt_adwin_blokright_vote; ?></a> <?php echo $txt_adwin_blokright_sur; ?> WordPress.org</p>
							<hr>
							<p class="inner">© Copyright <a href="https://www.kapsulecorp.com/">Kapsule Corp</a></p>
						</div>
		</div>
	</div>
	
	<?php
	
	} // Fin du Init Cave

} // Fin de l'Admin

// Widget PREMIUM //
if ($needpremium == "oui") {
	
	if ((KINGBOO != "Erreur") AND (KINGBOO != false)) { 

		require_once(GOTHAMBKOCKADBLOCK_ROOTPATH.'premium/ghostban.php');
			
		if (! function_exists('kapsule_cloaking_rewritee')) {
			
			function kapsule_cloaking_rewritee() {
				
				wp_enqueue_script( 'ghost-js-obf', plugins_url('premium/obf.js', __FILE__ ), array(), NULL );	

			}
			
			add_action( 'wp_enqueue_scripts', 'kapsule_cloaking_rewritee' );	
			
		}
		
		// Widget PREMIUM
			
		require_once(GOTHAMBKOCKADBLOCK_ROOTPATH.'premium/smartadserver.php');
		function gothamabadblock_load_widget() {
			
				register_widget( 'gothamblockadblock_smartban_widget' );
		}
			
		add_action( 'widgets_init', 'gothamabadblock_load_widget' );
		
		if ( is_admin() ){
			
			
			// Ajout du  Bouton de ShortCode dans Tiny MCE
			function gtadb_premium_tinymce_button() {
				if ( ! current_user_can('edit_posts') 
				  && ! current_user_can('edit_pages') ) {
					return false;
				}
				if ( get_user_option('rich_editing') == 'true') {
					add_filter( 'mce_external_plugins', 'gtadb_premium_script_tiny' );
					add_filter( 'mce_buttons', 'gtadb_premium_register_button' );
				}
			}

			function gtadb_premium_register_button( $buttons ) {
				array_push( $buttons, '|', 'gtadb_premium_bouton' );
				return $buttons;
			}

			add_action( 'admin_init', 'gtadb_premium_tinymce_button' );
			function gtadb_premium_script_tiny( $plugin_array ) {
				$plugin_array['ekoghostban'] = plugins_url( '/premium/tiny.js', __FILE__ );
				return $plugin_array;
			}
			// ! Fin Ajout du  Bouton de ShortCode dans Tiny MCE
			
		}

	}
	
}
// ! Widget Premium //