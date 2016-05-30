/*global $*/
$(document).ready(function () {
    "use strict";
    var observeModal = $('#observeModal');

    if (observeModal.length > 0) {
        observeModal.find('#checkbox_all').change(function () {
            if ($('#checkbox_all').prop('checked')) {
                observeModal.find('.checkbox input:not(#checkbox_all)').prop({
                    'checked': 'checked',
                    'disabled': 'disabled'
                });
            } else {
                observeModal.find('.checkbox input').prop('disabled', false);
            }
        });
        observeModal.find('.checkbox input').change(function () {
            if (observeModal.find('.alert').is(':visible')) {
                observeModal.find('.alert').slideUp('fast');
            }
        });
        observeModal.find('a.submit').click(function (e) {
            e.preventDefault();
            if (observeModal.find('.checkbox input:checked').length === 0) {
                observeModal.find('.alert').slideDown('fast');
            } else {
                observeModal.find('form').submit();
            }
        });
        observeModal.find('a.unobserve').click(function (e) {
            var that = $(this);

            e.preventDefault();
            that.addClass('disabled');
            $.post('/dane/subscriptions/' + that.attr('data-subscription-id') + '/delete', function () {
                window.location.reload();
            })
        });
        
        observeModal.find('.keywordsBlock .input-keyword').keydown(function(event){
			
			if(event.keyCode == 13) {
				event.preventDefault();
				observeModalAddKeyword();
				return false;
			}
			
		});
		
		observeModal.find('.keywordsBlock .btn-add').click(function(){
			observeModalAddKeyword();
		});
		
		var qs = observeModal.find('.keywordsBlock').data('qs');
		for( var i=0; i<qs.length; i++ ) {
			
			observeModalAddKeywordQ( qs[i] );
			
		}
        
    }
});

function observeModalAddKeywordQ(q) {
	
	var observeModal = $('#observeModal');
	if( observeModal.length ) {

		var list = observeModal.find('.keywordsBlock .keywords_list');
		var li = $('<li><input type="hidden" name="qs[]" /><p class="icons"><a href="#" class="glyphicon glyphicon-remove"></a></p><p class="val"></p></li>').data('q', q);
		li.find('.val').text(q);
		li.find('input').val(q);
		li.find('a').click(function(event){
			event.preventDefault();
			li.remove();
		});
		list.append( li );
		
	}
}

function observeModalAddKeyword() {
	var observeModal = $('#observeModal');
	if( observeModal.length ) {
		
		var input = observeModal.find('.keywordsBlock .input-keyword');
		var list = observeModal.find('.keywordsBlock .keywords_list');
		var list_options = list.find('li');
		
		var q = input.val().trim();
		
		if( q.length<3 ) {
			return alert('Podana fraza jest zbyt krótka');
		}
		
		if( q.length>150 ) {
			return alert('Podana fraza jest zbyt długa');
		}
				
		if( q ) {
			if( list_options.length < 5 ) {
				
				for( var i=0; i<list_options.length; i++ ) {
					if( $(list_options[i]).data('q') == q ) {
						alert('To słowo jest już na liście.');
						return false;
					}
				}
				
				observeModalAddKeywordQ(q);
								
			} else {
				alert('Możesz dodać maksymalnie 5 słów lub fraz.');
			}
		}
		
	}
}