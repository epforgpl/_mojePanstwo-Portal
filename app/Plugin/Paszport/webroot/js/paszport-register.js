var $P = {
    objects: {
        adresaci: {}
    }
};

$(document).ready(function() {
	$('#registration_law_link_more').click(function(event){
		event.preventDefault();
		$('#registration_law').slideToggle();
	});
    
    $('#UserRegisterForm').submit(function(event){
	    if( !$('#law_confirmation_checkbox').prop('checked') ) {
		    alert('Aby dokończyć rejestrację potwierdź zapoznanie się z treścią regulaminu');
		    event.preventDefault();
	    }	    
    });
});