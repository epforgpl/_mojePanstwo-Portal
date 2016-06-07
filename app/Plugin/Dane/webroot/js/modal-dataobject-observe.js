/*global $*/
$(document).ready(function () {
    "use strict";
        
    var observeModal = $('#observeModal');
    if (observeModal.length > 0) {
	    
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
	    
	    
	    
	    $('.dataobject-head .btn-observe').click(function(event){
		    
		    event.preventDefault();
		    					    	
		    var appHeader = $(event.target).parents('.dataobject-head');
		    var dataset = appHeader.data('dataset');
		    var object_id = appHeader.data('object_id');
		    var phrase = appHeader.data('phrase');
		    
		    var mode = false;
		    
		    if( dataset && object_id )
		    	mode = 'dataset';
		    else if( phrase )
		    	mode = 'phrase';
		    
		    if( mode) {
		    		 	
		    	   
				var optionsBlock = observeModal.find('.optionsBlock');
				var keywordsBlock = observeModal.find('.keywordsBlock');
								
				if( 
					( mode == 'phrase' ) ||
					(
						( mode == 'dataset' ) && 
						( dataset == 'users_phrases' )
					)
				)
					keywordsBlock.hide();
				else if( 
					( mode == 'dataset' ) && 
					( dataset != 'users_phrases' )
				)
					keywordsBlock.show();
					
				
				optionsBlock.html('');
				keywordsBlock.find('input').val('');
				keywordsBlock.find('.keywords_list').html('');
				observeModal.find('.modal-body-main').hide();
				observeModal.find('.modal-footer').hide();
				observeModal.find('.modal-footer .unobserve').hide();
				observeModal.find('.modal-body-loading').show();
				
				if( mode == 'dataset' ) {
					observeModal.find('input[name=dataset]').val(dataset);
					observeModal.find('input[name=object_id]').val(object_id);
				}
				
				observeModal.modal('show');
				
				if( mode == 'phrase' ) {
					
					var url = '/dane/user_phrases/phrase.json?q=' + phrase;
					
				} else if( mode == 'dataset') {
					
					var url = '/dane/' + dataset + '/' + object_id + '.json?layers[]=channels&layers[]=subscription';
					
				}
						
				$.get(url, function(data){
										
					observeModal.find('.dataobject-title').html('<a href="' + data.url + '">' + data.title + '</a>');
					
					if( mode == 'phrase' ) {
						
						observeModal.find('input[name=dataset]').val('users_phrases');
						observeModal.find('input[name=object_id]').val(data.data.id);
											
					}
					
					var div = '<div class="checkbox first"><input type="checkbox" id="checkbox_all" name="channel[]" value="" checked><label for="checkbox_all">Wszystkie dane</label></div>';
						
					optionsBlock.append(div);
					
					if( data.layers.channels && data.layers.channels.length ) {
											
						for( var i=0; i<data.layers.channels.length; i++ ) {
							
							var ch = data.layers.channels[i];
							
							var div = '<div class="checkbox"><input type="checkbox" id="checkbox_' + ch['DatasetChannel']['subject_dataset'] + '_' + ch['DatasetChannel']['channel'] + '" name="channel[]" value="' + ch['DatasetChannel']['channel'] + '" checked disabled /><label for="checkbox_' + ch['DatasetChannel']['subject_dataset'] + '_' + ch['DatasetChannel']['channel'] + '">' + ch['DatasetChannel']['title'] + '</label></div>';
							optionsBlock.append(div);
							
						}
					
					} else {
						
						observeModal.find('#checkbox_all').prop('checked', true).prop('disabled', true);
						
					}
					
					if( data.layers.subscription && data.layers.subscription.Subscription && data.layers.subscription.Subscription.id ) {

						
						observeModal.find('.modal-footer .unobserve').attr('data-subscription-id', data.layers.subscription.Subscription.id).show();
						
									
						if( data.layers.subscription.SubscriptionChannel && data.layers.subscription.SubscriptionChannel.length ) {
														
							optionsBlock.find('input[type=checkbox]').prop('checked', false).prop('disabled', false);
							
							for( var i=0; i<data.layers.subscription.SubscriptionChannel.length; i++ ) {
								
								var ch = data.layers.subscription.SubscriptionChannel[i];
								var selector = '#checkbox_' + data.layers.subscription.Subscription.dataset + '_' + ch['channel'];
																								
								optionsBlock.find(selector).prop('checked', true);
								
							}
						}
						
						
						if( data.layers.subscription.SubscriptionQuery && data.layers.subscription.SubscriptionQuery.length ) {
							
							for( var i=0; i<data.layers.subscription.SubscriptionQuery.length; i++ ) {
								var q = data.layers.subscription.SubscriptionQuery[i];
								observeModalAddKeywordQ( q['q'] );
							}
							
						}
						
						
					}
					
					
					
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
			        					
					
					observeModal.find('.modal-body-loading').hide();
					observeModal.find('.modal-body-main').show();
					observeModal.find('.modal-footer').show();
					
				});
			    
			}
				
	    });
	    
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
		
		if( !q )
			return false;
		
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
				input.val('').focus();
								
			} else {
				alert('Możesz dodać maksymalnie 5 słów lub fraz.');
			}
		}
		
	}
}