/*global $, jQuery, ui, mPHeart*/
(function ($) {
	"use strict";

	var suggesterBlock = $('.suggesterBlockPisma');

	if (suggesterBlock.length) {
		$.each(suggesterBlock, function (index, block) {
			var suggesterCache = {},
				suggesterInput = $(block).find('input.form-control'),
				suggesterForm = suggesterInput.parents('form');

			suggesterInput.autocomplete({
				minLength: 2,
				delay: 300,
				source: function (request, response) {
					var term = request.term;

					if (term in suggesterCache) {
						response(suggesterCache[term]);
					} else {
						suggesterInput.addClass('loader');
						$.get('/dane/suggest.json', {
							'q': term,
							'dataset[]': (suggesterInput.data('dataset')) ? suggesterInput.attr('data-dataset').split(',') : '*'
						}).done(function (data) {
							var results = $.map(data.options, function (item) {
								var shortTitleLimit = 150,
									shortTitle = '';

								if (item.payload !== undefined) {
									if (item.payload.dataset === 'twitter') {
										shortTitle = item.text.replace(/(<([^>]+)>)/ig, "");
									} else {
										if (item.text.length > shortTitleLimit) {
											shortTitle = item.text.substr(0, shortTitleLimit);
											shortTitle = shortTitle.substr(0, Math.min(shortTitle.length, shortTitle.lastIndexOf(" "))) + '...';
										} else {
											shortTitle = item.text;
										}
									}

									return {
										type: 'item',
										title: item.text,
										shortTitle: shortTitle,
										value: item.payload.object_id,
										link: '/dane/' + item.payload.dataset + '/' + item.payload.object_id + ((item.payload.slug) ? ',' + item.payload.slug : ''),
										dataset: item.payload.dataset,
										image: (item.payload.image !== undefined) ? item.payload.image : false,
										detail: (item.payload.desc) ? item.payload.desc : false,

										subdataset: (item.payload.subdataset) ? item.payload.subdataset : false,
										subid: (item.payload.subid) ? item.payload.subid : false
									};
								}
							});

							suggesterCache[term] = results;

							if (results.length === 0) {
								$('.ui-autocomplete').hide();
								suggesterInput.removeClass('open loader');
							} else {
								response(results);
							}
						});
					}
				},
				open: function () {
					var uiIndex = index + 1,
						$ui = $('#ui-id-' + uiIndex);

					$ui.css({
						'margin-top': Math.floor((suggesterInput.offset().top + suggesterInput.outerHeight()) - parseInt($ui.css('top'), 10) - parseInt($ui.css('border-bottom-left-radius'), 10)) + 'px',
						'width': suggesterInput.outerWidth() - 2,
						'left': parseInt($ui.css('left'), 10) + 1 + 'px'
					});

					$ui.find('.row ._title').each(function () {
						var that = $(this);
						that.css('height', that.find('>span').height());
					});
					suggesterInput.addClass('open');
					suggesterInput.removeClass('loader');
				},
				close: function () {
					suggesterInput.removeClass('open');
				},
				focus: function () {
					return false;
				},
				select: function (evt, ui) {
					if (ui.item) {
						
						console.log('select if');
						
						if (suggesterInput.closest('.searcher').find('.indicator').length === 0) {
							suggesterInput.closest('.searcher').append(
								$('<div></div>').addClass('glyphicon glyphicon-ok-circle indicator')
							)
						}
						suggesterInput.val(ui.item.title);
						suggesterForm.find('input[name="adresat_id"]').val(ui.item.subdataset + ':' + ui.item.subid);
						suggesterForm.find('.szablony .pisma-list-button').attr('data-adresatid', ui.item.subid);
						$P.objects.adresaci = {
							id: ui.item.subid,
							dataset: ui.item.subdataset,
							title: ui.item.title,
							object_id: ui.item.value
						};
						
					} else {
						
						console.log('select else');
						
						suggesterInput.closest('.searcher').find('.indicator').remove();
						suggesterForm.find('input[name="adresat_id"]').val('');
						suggesterForm.find('.szablony .pisma-list-button').attr('data-adresatid', false);
						$P.objects.adresaci = {};
						
					}
					return false;
				}
			}).autocomplete('widget').addClass("autocompleteSuggester");

			suggesterInput.data("ui-autocomplete")._renderItem = function (ul, item) {
				if (item.type == 'item') {
					var title = $('<span></span>').text(item.shortTitle),
						image;

					if (item.image.length > 0) {
						image = $('<img />').addClass('doc').attr('src', item.image);
					} else {
						image = $('<i></i>').addClass('icon icon-datasets-' + ((item.subdataset) ? item.subdataset : item.dataset));
					}

					if (item.detail) {
						title.append($('<small></small>').text(item.detail));
					} else {
						title.addClass('vertical-center');
					}

					return $('<li></li>').addClass("row").attr({
						'data-subid': item.subid,
						'data-subdataset': item.subdataset
					}).append(
						$('<a></a>').attr({'href': "#", 'onclick': 'return false;'}).append(
							$('<div></div>').addClass('col-xs-1 _label').append(image)
						).append(
							$('<div></div>').addClass('col-xs-9 col-sm-10 col-md-11 _title').append(title)
						)
					).appendTo(ul);
				}
			};
		});
	}
}(jQuery));
