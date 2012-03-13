var By = {
	id: function byId(id) {
		return document.getElementById(id);
	},
	tag: function byTag(tag, context) {
		return (context || document).getElementsByTagName(tag);
	},
	"class": function byClass(klass, context) {
		return (context || document).getElementsByClassName(klass);
	},
	name: function byName(name) {
		return document.getElementsByName(name);
	},
	qsa: function byQuery(query, context) {
		return (context || document).querySelectorAll(query);
	},
	qs: function byQueryOne(query, context) {
		return (context || document).querySelector(query);
	}
};
var listener = {
	add: function listenerAdd(elm, evt, func) {
		if( elm.addEventListener ) {
			elm.addEventListener(evt, func, false);
		} else if( elm.attachEvent ) {
			elm.attachEvent('on'+evt, func);
		}
	},
	remove: function listenerRemove(elm, evt, func) {
		if( elm.removeEventListener ) {
			elm.removeEventListener(evt, func, false);
		} else if( elm.detachEvent ) {
			elm.detachEvent('on'+evt, func);
		}
	}
}
var create = {
	elm: function createElm(type, props) {
		var tmp = document.createElement(type);
		for(var prop in props) {
			tmp.setAttribute(prop, props[prop]);
		}
		return tmp;
	},
	text: function createText(text) {
		return document.createTextNode(text);
	}
}
