<?php
/**
 * button.youtube
 *
 * @author	Stéphane F
 * @version 1.1
 **/
?>
<?php if(!defined('PLX_ROOT')) exit; ?>

<script type="text/javascript">
<!--
function get_url_param(param,url) {
	param = param.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+param+"=([^&#]*)";
	var regex = new RegExp(regexS);
	var results = regex.exec(url);
	if(results == null)
		return "";
	else
		return results[1];
}
plxToolbar.addButton( {
		icon : 'icon-youtube',
		title : 'Vid&eacute;o Youtube',
		onclick : function() {
			var url = prompt('Url de la video youtube', 'http://www.youtube.com/watch?v=');
			if(url!=null) {
				var video = get_url_param('v', url);
				s = '<iframe style="border:0;" width="560" height="315" src="https://www.youtube.com/embed/'+video+'" allowfullscreen></iframe>';
				return s;
			}
			return '';
		}
});
-->
</script>
