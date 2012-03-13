var btn_add = By.id('add-ingredient'),
	icount = 0;
function btn_add_handler(e) {
	var container = By.id('ingredient-container');
	
	icount++;
	
	var group = create.elm('div', {
			'class': 'control-group'
		}),
		lbl = create.elm('label', {
			'class': 'control-label'
		}),
		ctrls = create.elm('div', {
			'class': 'controls'
		}),
		amount = create.elm('input', {
			'type': 'text',
			'class': 'span1',
			'name': 'ingredient-amount[]'
		}),
		unit = create.elm('select', {
			'class': 'span1',
			'name': 'ingredient-unit[]'
		}),
		ingredient = create.elm('input', {
			'type': 'text',
			'class': 'span3',
			'name': 'ingredient[]'
		}),
		help = create.elm('p', {
			'class': 'help-line'
		}),
		btn = create.elm('a', {
			'class': 'btn btn-mini btn-inverse'
		}),
		icon = create.elm('i', {
			'class': 'icon-remove icon-white'
		});
		
	var unit_values = {
		'tsp': 'tsp',
		'tbsp': 'tbsp',
		'cup': 'cup',
		'ml': 'ml',
		'l': 'litre',
		'g': 'gram',
		'kg': 'kg'
	};
	unit.appendChild(create.elm('option'));
	for( var unit_type in unit_values ) {
		var option = create.elm('option', {
			'value': unit_type
		});
		option.appendChild(create.text(unit_values[unit_type]));
		unit.appendChild(option);
	}
	
	lbl.appendChild(create.elm('i',{'class':'icon-shopping-cart'}));
	ctrls.appendChild(amount);
	
	ctrls.appendChild(unit);
	ctrls.appendChild(ingredient);
	
	btn.appendChild(icon);
	btn.appendChild(create.text(' remove'));
	listener.add(btn, 'click', function() {
		var cont = this.parentNode.parentNode;
		cont.className += ' warning'; //buggy in chrome
		if(confirm('Remove the Ingredient?')) {
			cont.parentNode.removeChild(cont);
		} else {
			cont.className = 'control-group';
		}
	});
	ctrls.appendChild(btn);
	
	group.appendChild(lbl);
	group.appendChild(ctrls);
	
	container.appendChild(group);
}




listener.add(btn_add, 'click', btn_add_handler);
