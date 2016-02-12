<?php
/**
 * button.smilies
 *
 * @author  Stéphane F
 * @version 1.1
 **/
?>
<?php if(!defined('PLX_ROOT')) exit; ?>
<script type="text/javascript">
<!--
plxToolbar.addButton( {

		smilies : new Array(
					'smile.png', 'neutral.png', 'sad.png', 'big_smile.png', 'yikes.png', 'wink.png',
					'hmm.png', 'tongue.png', 'lol.png', 'mad.png', 'roll.png', 'cool.png', 'icon_eek.gif',
					'icon_redface.gif', 'icon_twisted.gif', 'icon_arrow.gif', 'icon_exclaim.gif', 'icon_question.gif'
				),
		alt : new Array(
					':-)', ':|', ':-(', ':D', ':-C', ';-)',
					':-s', ':p', 'LOL', 'mad', 'roll', '8-)', '8-O',
					':$', 'twisted', '->', '!', '?'
				),
		icon : 'icon-happy',
		title : 'Smilies',

		onclick : function(textarea) {
			var obj = document.getElementById('plxSmilies_'+textarea);
			if(obj==undefined) {
				this.show(textarea);
			} else {
				this.hide(textarea);
			}
			return '';
		},
		show : function(textarea) {
			var obj = document.getElementById('id_'+textarea);
			var p = document.createElement('p');
			p.setAttribute("id","plxSmilies_"+textarea);
			p.innerHTML = this.toolbar(textarea);
			var html = obj.parentNode;
			html.insertBefore(p,obj);
		},
		hide : function(textarea) {
			var obj = document.getElementById('plxSmilies_'+textarea);
			var html = obj.parentNode;
			html.removeChild(obj);
		},
		toolbar : function(textarea)  {
			var s = '<div style="clear:both;float:left">';
			for(i=0;i<(this.smilies.length-1);i++) {
				icon = '<img src="<?php echo PLX_ROOT ?>plugins\/plxtoolbar\/custom.buttons\/smilies\/'+this.smilies[i]+'" \/>';
				img = '<img src=&#34;plugins\/plxtoolbar\/custom.buttons\/smilies\/'+this.smilies[i]+'&#34; alt=&#34;'+this.alt[i]+'&#34; \/>';
				s += '<a href="javascript:void(0)" onclick="plxToolbar.insert(\''+textarea+'\', \''+img+'\', \'\')">'+icon+'<\/a>';
			}
			s += '<\/div>';
			return s;
		}

});
-->
</script>