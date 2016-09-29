/**
 * plxToolbar
 *
 * @package PLX
 * @author	Stephane F
 **/
function _plxToolbar() {

	this.customButtons = new Array();
	this.path_editor = '';
	this.height;
	this.addButton = function(customButton) {
		this.customButtons.push(customButton);
	}
	this.insert = function(textarea, tag_open, tag_close, qst, mess) {
		var msg = mess || '';
		if((answer = (qst ? prompt(qst, msg) : '')) == null) return;
		switch (tag_open) {
			case "<a>":
				tag_open = '<a href="'+answer+'">';
				break;
			case "<left>":
				tag_open = '<p style="text-align:left">\n';
				tag_close = '</p>';
				break;
			case "<center>":
				tag_open = '<p style="text-align:center">\n';
				tag_close = '</p>';
				break;
			case "<right>":
				tag_open = '<p style="text-align:right">\n';
				tag_close = '</p>';
				break;
			case "<img>":
				tag_close = tag_close.replace(this.racine, "");
				tag_open = '<img src="'+tag_close+'" alt="'+answer+'" />\n';
				tag_close = '';
				break;
		}
		this.addText(textarea, tag_open, tag_close);
	}
	this.doToolbar = function(textarea, origine, mini) {

		if(mini=='mini') {
			var toolbar = '\
	<span class="icon-bold" onclick="plxToolbar.insert(\''+textarea+'\',\'<strong>\',\'<\/\strong>\')" title="'+lang.L_TOOLBAR_BOLD+'"></span>\
	<span class="icon-link" onclick="plxToolbar.insert(\''+textarea+'\',\'<a>\',\'<\/\a>\', \''+lang.L_TOOLBAR_LINK_MSG+'\', \'http://www.\')" title="'+lang.L_TOOLBAR_LINK+'"></span>\
';
		} else {
			var toolbar = '\
	<select onchange="if(this.value!=\'\'){plxToolbar.insert(\''+textarea+'\',\'<\'+this.value+\'>\',\'<\/\'+this.value+\'>\');this.selectedIndex=0;}">\
		<option value="">Style</option>\
		<option value="h1">H1</option>\
		<option value="h2">H2</option>\
		<option value="h3">H3</option>\
		<option value="h4">H4</option>\
		<option value="h5">H5</option>\
		<option value="h6">H6</option>\
		<option value="p">P</option>\
		<option value="pre">Pre</option>\
	</select>\
	<span class="icon-pilcrow" onclick="plxToolbar.insert(\''+textarea+'\',\'<br \/>\\n\')" title="'+lang.L_TOOLBAR_BR+'"></span>\
	<span class="icon-bold" onclick="plxToolbar.insert(\''+textarea+'\',\'<strong>\',\'<\/\strong>\')" title="'+lang.L_TOOLBAR_BOLD+'"></span>\
	<span class="icon-italic" onclick="plxToolbar.insert(\''+textarea+'\',\'<em>\',\'<\/\em>\')" title="'+lang.L_TOOLBAR_ITALIC+'"></span>\
	<span class="icon-underline" onclick="plxToolbar.insert(\''+textarea+'\',\'<ins>\',\'<\/\ins>\')" title="'+lang.L_TOOLBAR_UNDERLINE+'"></span>\
	<span class="icon-strikethrough" onclick="plxToolbar.insert(\''+textarea+'\',\'<strike>\',\'<\/\strike>\')"  title="'+lang.L_TOOLBAR_STRIKE+'"></span>\
	<span class="icon-link" onclick="plxToolbar.insert(\''+textarea+'\',\'<a>\',\'<\/\a>\', \''+lang.L_TOOLBAR_LINK_MSG+'\', \'http://www.\')" title="'+lang.L_TOOLBAR_LINK+'"></span>\
	<span class="icon-pagebreak" onclick="plxToolbar.insert(\''+textarea+'\',\'<hr>\\n\')" title="'+lang.L_TOOLBAR_HR+'"></span>\
	<span class="icon-list-numbered" onclick="plxToolbar.insert(\''+textarea+'\',\'<ol>\\n</li>\',\'<\/li>\\n<\/ol>\')" title="'+lang.L_TOOLBAR_OL+'"></span>\
	<span class="icon-list2" onclick="plxToolbar.insert(\''+textarea+'\',\'<ul>\\n<li>\',\'<\/li>\\n<\/ul>\')" title="'+lang.L_TOOLBAR_UL+'"></span>\
	<span class="icon-quotes-right" onclick="plxToolbar.insert(\''+textarea+'\',\'<blockquote>\',\'<\/blockquote>\')" title="'+lang.L_TOOLBAR_BLOCKQUOTE+'"></span>\
	<span class="icon-paragraph-left" onclick="plxToolbar.insert(\''+textarea+'\',\'<left>\')" title="'+lang.L_TOOLBAR_P_LEFT+'"></span>\
	<span class="icon-paragraph-center" onclick="plxToolbar.insert(\''+textarea+'\',\'<center>\')" title="'+lang.L_TOOLBAR_P_CENTER+'"></span>\
	<span class="icon-paragraph-right" onclick="plxToolbar.insert(\''+textarea+'\',\'<right>\')" title="'+lang.L_TOOLBAR_P_RIGHT+'"></span>\
	<span class="icon-images" onclick="mediasManager.openPopup(\''+textarea+'\', false, \'PLXTOOLBAR_fallback\')" title="'+lang.L_TOOLBAR_MEDIAS+'"></span>\
	<span class="icon-new-tab" onclick="plxToolbar.toogleFullscreen(\''+textarea+'\')" title="'+lang.L_TOOLBAR_FULLSCREEN+'"></span>\
';
			if(this.customButtons.length>0) {
				for(i=0;i<this.customButtons.length;i++){
					toolbar += '<span class="'+this.customButtons[i].icon+'" onclick="plxToolbar.insert(\''+textarea+'\', plxToolbar.customButtons['+i+'].onclick(\''+textarea+'\'),\'\')" title="'+this.customButtons[i].title+'"></span>';
				}
			}

		}
		return toolbar;
	}

	this.addToolbar = function(textarea, origine, mini) {
		var obj = document.getElementById('id_'+textarea);
		var p = document.createElement('p');
		p.id = 'plxtoolbar_'+textarea;
		p.setAttribute("class","plxtoolbar");
		p.setAttribute("className","plxtoolbar"); /* Hack IE */
		p.innerHTML = this.doToolbar(textarea, origine, mini);
		var html = obj.parentNode;
		html.insertBefore(p,obj);

	}
	this.init = function(path_editor, racine) {
		this.racine = racine;
		this.path_editor=path_editor;
		var url = window.location.pathname;
		var mini = '';
		if(url.match(new RegExp("comment.php","gi")))
			mini='mini';
		var textareas = document.getElementsByTagName("textarea");
		for(var i=0;i<textareas.length;i++){
			this.addToolbar(textareas[i].name,'article',mini);
		}
	}

	this.addText = function(where, open, close) {
		close = close==undefined ? '' : close;
		var formfield = document.getElementsByName(where)['0'];
		// IE support
		if (document.selection && document.selection.createRange) {
			formfield.focus();
			sel = document.selection.createRange();
			sel.text = open + sel.text + close;
			formfield.focus();
		}
		// Moz support
		else if (formfield.selectionStart || formfield.selectionStart == '0') {
			var startPos = formfield.selectionStart;
			var endPos = formfield.selectionEnd;
			var restoreTop = formfield.scrollTop;
			formfield.value = formfield.value.substring(0, startPos) + open + formfield.value.substring(startPos, endPos) + close + formfield.value.substring(endPos, formfield.value.length);
			formfield.selectionStart = formfield.selectionEnd = endPos + open.length + close.length;
			if (restoreTop > 0) formfield.scrollTop = restoreTop;
			formfield.focus();
		}
		// Fallback support for other browsers
		else {
			formfield.value += open + close;
			formfield.focus();
		}
		return;
	}
	this.toogleFullscreen = function(textarea) {
		var cible = document.getElementById('id_'+textarea);
		if(cible.getAttribute('class').indexOf('p_fullscreen')<0) {
			this.height=cible.offsetHeight;
			document.getElementById('plxtoolbar_'+textarea).setAttribute('class', 'plxtoolbar plxtoolbar_fullscreen');
			cible.setAttribute('class', cible.getAttribute('class') + ' p_fullscreen');
			cible.setAttribute('style', 'height:'+plxToolbar.getViewportHeight()+'px');
		} else {
			document.getElementById('plxtoolbar_'+textarea).setAttribute('class', 'plxtoolbar');
			cible.setAttribute('class', cible.getAttribute('class').replace(' p_fullscreen', ''));
			cible.setAttribute('style', 'height:'+this.height+'px');
		}
	}
	this.getViewportHeight = function() {
		var height;
		if (window.innerHeight!=window.undefined) height=window.innerHeight;
		else if (document.compatMode=='CSS1Compat') height=document.documentElement.clientHeight;
		else if (document.body) height=document.body.clientHeight;
		return height-160;
	}
}

PLXTOOLBAR_fallback = function(cible, txt, replace) {
	window.opener.plxToolbar.insert(cible, '<img>', txt, lang.L_TOOLBAR_IMG_TITLE);
}

var plxToolbar = new _plxToolbar();
