var tmpObject;
$().ready(function(){
	$('.newItem').bind('focus', doFocus);
	$('.newItem').bind('blur', doBlur);
	$('form#TodoAddForm').submit(function(e){
		e.preventDefault();
		addNewItem($(this).find('input[type="text"]'));
	});
	$('input[type="checkbox"]').bind('click', toggleMark);
	$('.list a').bind('click', removeItem);
	$('.list span').bind('dblclick', editItem);
});

doBlur = function(){
	$(this).val('Enter New Todo Item');
	$(this).removeClass('editing');
}

doFocus = function(){
	$(this).val('');
	$(this).addClass('editing');
}

revert = function(){
	tmpObject.bind('click', editItem);
	$(this).replaceWith(tmpObject);
	tmpObject = null;
}

editItem = function(e){
	self = $(this);
	input = $('<input />').attr({
		'type': 'text',
		'name': 'data[Todo][title]',
		'value': $(this).html()
	});
	tmpObject = $(this);
	$(this).replaceWith(input);
	input.focus();
	input.bind("blur", revert);
	input.keyup(function(e){
		if(e.keyCode == 13){
			$.ajax({
				url: '/todos/edit/'+ self.attr('alt'),
				type: 'POST', 
				data: input.serialize(),
				dataType: 'json',
				success: function(res){
					tmpObject.bind('dblclick', editItem);
					input.replaceWith(tmpObject.html(res['data']['Todo']['title']));
				}
			});
		}
	});
}

addNewItem = function(el){
	if($(el).val().length == 0 || $(el).val().toLowerCase() == "enter new todo item"){
		return false;
	}
	$form = $(el).closest('form');
	
	$.ajax({
		url: $form.attr('action'),
		type: 'POST',
		data: $form.serialize(),
		dataType: 'json',
		success: function(res){
			if(res != null){
				li = $('<li />').addClass('list');
				hidden = $('<input />').attr({
					'type': 'hidden',
					'name': 'data[todo]',
					'id': 'todo_'+res['data']['Todo']['id'],
					'value': 0
				});
				checkbox = $('<input />').attr({
					'type': 'checkbox',
					'name': 'data[todo]',
					'id': 'todo_'+res['data']['Todo']['id'],
					'class': 'mark',
					'value': 1
				});
				checkbox.bind('click', toggleMark);
				span = $('<span />').append(res['data']['Todo']['title']);
				span.bind('dblclick', editItem);
				link = $('<a />').attr({
					'href': '/todos/delete/'+res['data']['Todo']['id'],
				});
				image = $('<img />').attr({
					'src': '/img/close_button.png',
					'width': 21,
					'height': 21
				});
				link.bind('click', removeItem).append(image);
				li.append(hidden).append(checkbox).append(span).append(link);
				$('#todolist').append(li);
				$('.newItem').focus();
			}
		}
	});
}

removeItem = function(e){
	e.preventDefault();
	self = $(this);
	$.ajax({
		url: $(self).attr('href'),
		type: "POST",
		dataType: 'json',
		success: function(res){
			if(res['status'] == 'success'){
				self.parent().remove();
			}
		}
	});
}

toggleMark = function(){
	self = $(this);
	$.ajax({
		url: "/todos/mark/"+$(this).attr('id'),
		type: "POST",
		data: $(this).serialize(),
		dataType: 'json',
		success: function(res){
			if(res['data']['Todo']['done']){
				li = self.parent().find('span').addClass('done');
			}
			else{
				li = self.parent().find('span').removeClass('done');
			}
		}
	})
}