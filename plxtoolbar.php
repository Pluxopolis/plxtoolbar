<?php
/**
 * Classe plxToolbar
 *
 * @package PLX
 * @author	Stephane F
 **/
class plxtoolbar extends plxPlugin {

	/**
	 * Constructeur de la classe
	 *
	 * @return	null
	 * @author	Stéphane F.
	 **/
	public function __construct($default_lang) {

		# Appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);

		# Ajoute les hooks nécessaires pour le fonctionnement de la plxToolbar
		$this->addHook('AdminTopEndHead', 'AdminTopEndHead');
		$this->addHook('AdminFootEndBody', 'AdminFootEndBody');

		# Hook dédié à la toolbar pour les customs buttons
		$this->addHook('plxToolbarCustomsButtons', 'getCustomsButtons');

		$this->plugPath = PLX_PLUGINS.__CLASS__.'/';
	}

	/**
	 * Méthode qui récupere les boutons utilisateurs dans le dossier cutom.buttons
	 *
	 * @return	stdio
	 * @author	Stéphane F.
	 **/
	public function getCustomsButtons() {
		$str='';
		# On regarde s'il y a des boutons personnels à ajouter dans la plxtoolbar
		if(is_dir($this->plugPath.'custom.buttons/')) {
			$buttons = plxGlob::getInstance($this->plugPath.'custom.buttons/');
			if($aFiles = $buttons->query('/button.(.*).php$/')) {
				foreach($aFiles as $button) {
					echo '<?php include(\''.$this->plugPath.'custom.buttons/'.$button.'\'); ?>';
				}
			}
		}
	}

	/**
	 * Méthode qui ajoute les déclarations dans la partie <head> de l'administration
	 *
	 * @return	stdio
	 * @author	Stéphane F.
	 **/
	public function AdminTopEndHead() {
		echo "\n".'<link rel="stylesheet" type="text/css" href="'.$this->plugPath.'plxtoolbar/style.css" media="screen" />'."\n";
	}

	/**
	 * Méthode qui ajoute les déclarations dans le footer de l'administration
	 *
	 * @return	stdio
	 * @author	Stéphane F.
	 **/
	public function AdminFootEndBody() {
		$langfile = $this->plugPath.'plxtoolbar/lang/'.$this->default_lang.'.js';
		if(is_file($langfile))
		echo '<script src="'.$langfile.'"></script>'."\n";
		echo "\n".'<script src="'.$this->plugPath.'plxtoolbar/plxtoolbar.js"></script>'."\n";
		echo '<?php eval($plxAdmin->plxPlugins->callHook(\'plxToolbarCustomsButtons\', \'addCustomButtons\')); ?>'."\n";
		echo '<script>plxToolbar.init(\''.$this->plugPath.'\',\''.plxUtils::getRacine().'\');</script>'."\n";
	}

}
?>