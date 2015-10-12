
$(document).ready(function() {

	$('form.letterResponseForm').each(function() {

		var form = $(this),
			url = form.data('url'),
			dropzone = form.find('.dropzoneForm').first(),
			datepicker = form.find('.datepickerResponseDate').first();

		$.fn.bootstrapDP = $.fn.datepicker.noConflict();

		datepicker.bootstrapDP({
			language: 'pl',
			orientation: 'auto top',
			format: "yyyy-mm-dd",
			autoclose: true
		});

		dropzone.dropzone({
			url: url,
			clickable: '.btn-addfile',
			acceptedFiles: '.pdf,.docx,.doc,.tif,.html,.jpg,.xml,.xls,.xlsx,.rtf,.png',
			autoQueue: true,
			autoProcessQueue: true,
			previewsContainer: '#preview',
			previewTemplate: [
				'<div class="file">',
					'<div class="title">',
						'<span class="name" data-dz-name></span>',
						'<span class="size" data-dz-size></span>',
						'<span class="error text-danger" data-dz-errormessage></span>',
					'</div>',
					'<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">',
						'<div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress>',
						'</div>',
					'</div>',
					'<div class="buttons">',
						//'<button class="btn btn-sm btn-primary start"><i class="glyphicon glyphicon-upload"></i></button>',
						//'<button data-dz-remove class="btn btn-sm btn-warning cancel"><i class="glyphicon glyphicon-ban-circle"></i></button>',
						//'<button data-dz-remove class="btn btn-sm btn-danger delete"><i class="glyphicon glyphicon-trash"></i></button>',
					'</div>',
				'</div>'
			].join('')
		});

	});

});
