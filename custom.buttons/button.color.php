<?php
/**
 * button.color
 *
 * @author	Stéphane F
 * @version 1.1
 **/
?>
<?php if(!defined('PLX_ROOT')) exit; ?>

<script type="text/javascript">
<!--
plxToolbar.addButton( {
		icon : 'icon-flickr3',
		title : 'Couleur',
		onclick : function(textarea) {
			var color = prompt('Code couleur (exemple: #ffffff)', '');
			if(color!=null) {
				plxToolbar.insert(textarea, '<span style="color:'+color+'">', '<\/span>', '', '');
			}
			return '';
		}
});
-->
</script>
