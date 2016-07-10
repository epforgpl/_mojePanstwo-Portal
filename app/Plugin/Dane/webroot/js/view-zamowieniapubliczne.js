$(document).ready(function () {
	
	$('#toc').sticky({topSpacing:50});
	
    $(".open_modal").click(function(){
        var numer=$(this).attr('numer');
       $('#'+numer+'').modal('show');
    });
    
});
