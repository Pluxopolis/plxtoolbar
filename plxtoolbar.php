<?php
/**
 * Classe plxToolbar
 *
 * @package PLX
 * @author	Stephane F, Thomas I.
 **/
class plxtoolbar extends plxPlugin {
	public static $v = '?v=1.5.2';#style & script
	public static $plugPath = '';#PLX_PLUGINS.__CLASS__.'/';
	public static $__lang = 'fr';#PLX_SITE_LANG;
	/**
	 * Constructeur de la classe
	 *
	 * @return	null
	 * @author	Stéphane F.,	Thomas I.
	 **/
	public function __construct($default_lang) {

		# Appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);

		if(defined('PLX_ADMIN') && !defined('PLX_GROOT')) {

			# Règle la langue pour choisr le fichier a charger (obligatoire)
			self::$__lang = $default_lang;#legacy
			self::$plugPath = PLX_PLUGINS.__CLASS__.'/';

			# Ajoute les hooks nécessaires pour le fonctionnement de la plxToolbar
			$this->addHook('AdminTopEndHead', 'AdminTopEndHead');
			$this->addHook('AdminFootEndBody', 'AdminFootEndBody');

			# Hook dédié à la toolbar pour les customs buttons
			$this->addHook('plxToolbarCustomsButtons', 'getCustomsButtons');

		}

	}

	/**
	 * Méthode qui récupere les boutons utilisateurs dans le dossier cutom.buttons
	 *
	 * @return	stdio
	 * @author	Stéphane F.
	 **/
	public function getCustomsButtons() {
		# On regarde s'il y a des boutons personnels à ajouter dans la plxtoolbar
		if(is_dir(self::$plugPath.'custom.buttons/')) {
			$buttons = plxGlob::getInstance(self::$plugPath.'custom.buttons/',!1,!0,'');#Fix 5.9RC2+
			if($aFiles = $buttons->query('/button\.(.*)\.php$/')) {
				$str='';
				foreach($aFiles as $button) {
					$str .= 'include(\''.self::$plugPath.'custom.buttons/'.$button.'\');'.PHP_EOL;
				}
				if($str)
					echo '<?php '.$str.' ?>';
			}
		}
	}

	/**
	 * Méthode qui affiche les déclarations dans la partie <head> de l'administration
	 *
	 * @return	stdio
	 * @author	Stéphane F.,	Thomas I.
	 **/
	public static function endHead() {
		echo "\n".'<link rel="stylesheet" type="text/css" href="'.self::$plugPath.'plxtoolbar/style.css'.self::$v.'" media="screen" />'."\n";
	}

	/**
	 * Méthode qui appelle endHead pour les déclarations dans la partie <head> de l'administration
	 *
	 * @return	stdio
	 * @author	Thomas I.
	 **/
	public function AdminTopEndHead() {
		self::endHead();
	}

	/**
	 * Méthode qui affiche les déclarations dans le footer de l'administration
	 *
	 * @return	stdio
	 * @author	Stéphane F., Thomas I. (static)
	 **/
	public static function endBody() {
		$langfile = self::$plugPath.'plxtoolbar/lang/'.self::$__lang.'.js';
		if(is_file($langfile))
			echo '<script src="'.$langfile.self::$v.'"></script>'."\n";
		echo "\n".'<script src="'.self::$plugPath.'plxtoolbar/plxtoolbar.js'.self::$v.'"></script>'."\n";
		echo '<?php $plxAdmin = isset($plxAdmin)?$plxAdmin:$plxMotor; eval($plxAdmin->plxPlugins->callHook(\'plxToolbarCustomsButtons\', \'addCustomButtons\')); ?>'."\n";
		echo '<script>plxToolbar.init(\''.self::$plugPath.'\',\''.plxUtils::getRacine().'\');</script>'."\n";
	}
	/**
	 * Méthode qui appelle endBody pour les déclarations dans le footer de l'administration
	 *
	 * @return	stdio
	 * @author	Thomas I.
	 **/
	public function AdminFootEndBody() {
		self::endBody();
	}

}
?>