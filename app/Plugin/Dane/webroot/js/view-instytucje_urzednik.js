var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

$(document).ready(function () {
	
    
    var $documentFastCheck = $('.documentFastCheck');
    if ($documentFastCheck) {
        var modal = $('<div></div>').addClass('modal fade').attr({
            'id': 'documentFastCheckModal',
            'tabindex': "-1",
            'role': 'dialog',
            'aria-labelledby': 'documentFastCheckModalLabel',
            'aria-hidden': 'true'
        }).append(
            $('<div></div>').addClass('modal-dialog').append(
                $('<div></div>').addClass('modal-content').append(
                    $('<div></div>').addClass('modal-header').append(
                        $('<button></button>').addClass('close').attr({
                            'type': 'button',
                            'data-dismiss': 'modal',
                            'aria-label': 'Close'
                        }).append(
                            $('<span></span>').attr('aria-hidden', 'true').html("&times;")
                        )
                    )
                ).append(
                    $('<div></div>').addClass('modal-body').append(
                        $('<iframe></iframe>').addClass('loading').attr('name', 'preview')
                    )
                )
            )
        );
        $('#_main').append(modal);
		
		modal.on('hidden.bs.modal', function () {
		    history.pushState('?', '?', '?');
		});
		
		if( getUrlParameter('rk') ) {
			
			$.each($documentFastCheck, function () {
	        	
	        	$this = $(this).find('a');
	        	
	        	if( $this.data('id')==getUrlParameter('rk') ) {
	                
	                modal.find('.modal-body').html(
	                    $('<iframe></iframe>').addClass('loading').attr('name', 'preview')
	                );
	                modal.modal('show');
	
	                var documentId = $this.data('documentid');
	                var frame = modal.find('iframe');
									
					frame.attr('src', 'https://mojepanstwo.pl/docs/' + documentId + '.html');
										
				}
	                	            
	        });
			
		}
		
        $.each($documentFastCheck, function () {
	        
	        
            $(this).find('a').click(function (e) {
                
                e.preventDefault();
                $this = $(this);
                
                history.pushState($this.data('id'), $this.find('content').text(), '?rk=' + $this.data('id'));
                
                modal.find('.modal-body').html(
                    $('<iframe></iframe>').addClass('loading').attr('name', 'preview')
                );
                modal.modal('show');

                var documentId = $this.data('documentid');
                var frame = modal.find('iframe');
								
				frame.attr('src', 'https://mojepanstwo.pl/docs/' + documentId + '.html');
                
            });
        });
    }
	
	
});