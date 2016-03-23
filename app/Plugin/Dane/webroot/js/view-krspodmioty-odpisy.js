$(document).ready(function () {
    
    $('.sticky').sticky();
    
    $('.odpisy a').click(function(event){
	    
	    event.preventDefault();
	    
	    var row = $(event.target).parents('.list-group-item');
	    var modal = $('#downloadModal')
	    
	    if( mPHeart.user_id ) {
		    
		    var href = row.find('a').attr('href');
		    modal.find('form').attr('action', href);
		    modal.find('button.submit').click(function(){
			    modal.modal('hide');
		    });
		    
		    if( $('.appHeader [data-target=#observeModal]').hasClass('btn-success') ) {
			    modal.find('.subscribeDiv').hide();
		    } else {
			    modal.find('.subscribeDiv').show();
		    }
		    
	    }	    
	    	    
	    modal.find('.data_odpisu').text( row.find('._ds').text() );
	    modal.modal('show');
	    	    
    });
    
});
