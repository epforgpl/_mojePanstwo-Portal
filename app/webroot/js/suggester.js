/*global $, jQuery, ui, mPHeart*/
(function ($) {
	"use strict";

	var suggesterBlock = $('.suggesterBlock');

	if (suggesterBlock.length) {
		$.each(suggesterBlock, function (index, block) {
			var suggesterCache = {},
				suggesterInput = $(block).find('input.form-control'),
				suggesterForm = suggesterInput.parents('form'),
				params;

			if (suggesterInput.attr('data-searchtag') && suggesterInput.hasClass('searchTagRender') == false) {
				var searchTag = $.parseJSON(suggesterInput.attr('data-searchtag')),
					searchTagBlock = $('<div></div>').addClass('searchTag').text(searchTag.label).css({
						position: 'absolute',
						zIndex: 2,
						top: suggesterInput.css('border-top-width'),
						left: suggesterInput.css('border-left-width'),
						borderTopLeftRadius: suggesterInput.css('border-top-left-radius'),
						borderBottomLeftRadius: suggesterInput.css('border-bottom-left-radius'),
						backgroundColor: '#E6E7E8',
						padding: suggesterInput.css('paddingTop') + ' ' + suggesterInput.css('paddingLeft'),
						fontSize: suggesterInput.css('font-size'),
						fontWeight: suggesterInput.css('font-weight'),
						color: suggesterInput.css('color')
					});

				suggesterInput.attr({
					'data-datasetbase': suggesterInput.data('dataset'),
					'data-paddingbase': suggesterInput.css('padding-left')
				}).addClass('searchTagRender');
				suggesterInput.after(searchTagBlock);
				suggesterInput.css('padding-left', searchTagBlock.outerWidth() + parseInt(suggesterInput.attr('data-paddingbase')) + 'px');

				suggesterInput.keypress(function (e) {
					if ((e.keyCode == jQuery.ui.keyCode.BACKSPACE) && (suggesterInput.val() == '')) {
						searchTagBlock.hide();
						suggesterInput.removeAttr('data-dataset');
						suggesterForm.attr('action', '/dane');
						suggesterInput.css('padding-left', suggesterInput.attr('data-paddingbase'));
					}
				});
				suggesterInput.focusout(function () {
					if ((suggesterInput.val() == '') && searchTagBlock.is(':hidden')) {
						searchTagBlock.show();
						suggesterInput.attr('data-dataset', suggesterInput.attr('data-datasetbase'));
						suggesterForm.attr('action', '');
						suggesterInput.css('padding-left', searchTagBlock.outerWidth() + parseInt(suggesterInput.attr('data-paddingbase')) + 'px');
					}
				});
			}

			if (suggesterInput.attr('data-autocompletion') == 'true') {
				suggesterInput.autocomplete({
					minLength: 2,
					delay: 300,
					source: function (request, response) {
						var term = request.term,
							dataset = (typeof suggesterInput.attr('data-dataset') == "undefined" ? '*' : suggesterInput.attr('data-dataset'));

						if (typeof suggesterCache[dataset] == "undefined") {
							suggesterCache[dataset] = {}
						}

						if (term in suggesterCache[dataset]) {
							response(suggesterCache[dataset][term]);
						} else {
							$.get('/dane/suggest.json', {
								'q': term,
								'dataset[]': dataset.split(',')
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
										};
									}
								});

								suggesterCache[dataset][term] = results;

								if (results.length === 0) {
									$('.ui-autocomplete').hide();
								} else {
									results.push({
										type: 'button',
										q: request.term
									});
									response(results);
								}
							});
						}
					},
					open: function () {
						var uiIndex = index + 1,
							$ui = $('#ui-id-' + uiIndex);

						$ui.css({
							'margin-top': Math.floor((suggesterInput.offset().top + suggesterInput.outerHeight()) - parseInt($ui.css('top'), 10) - parseInt($ui.css('border-bottom-left-radius'), 10)) + 8 + 'px',
							'width': suggesterInput.outerWidth() - 2,
							'left': parseInt($ui.css('left'), 10) + 1 + 'px'
						});

						$ui.find('.row ._title').each(function () {
							var that = $(this);
							that.css('height', that.find('>span').height());
						});
						suggesterInput.addClass('open');
						// suggesterInput.removeClass('loader');
					},
					close: function () {
						suggesterInput.removeClass('open');
					},
					focus: function () {
						return false;
					},
					select: function (evt, ui) {
						if (ui.item) {
							suggesterInput.val(ui.item.title);
							window.location.href = ui.item.link;
						}
						return false;
					}
				}).autocomplete('widget').addClass("autocompleteSuggester");

				suggesterInput.data("ui-autocomplete")._renderItem = function (ul, item) {
					if (item.type !== 'item') {
						if (item.type === 'button') {
							params = '?q=' + item.q;

							return $('<li></li>').addClass("row button").append(
								$('<a></a>').addClass('btn btn-success').attr({
									'href': ((suggesterForm.attr('action').length > 0) ? suggesterForm.attr('action') : ((suggesterInput.attr('data-url').length > 0) ? suggesterInput.attr('data-url') : '')) + params,
									'target': '_self'
								}).html('<span class="glyphicon glyphicon-search"> </span> ' + mPHeart.suggester.fullSearch)
							).appendTo(ul);
						}
					} else {
						var title = $('<span></span>').text(item.shortTitle),
							image;

						if (item.image.length > 0) {
							image = $('<img />').addClass('doc').attr('src', item.image);
						} else {
							image = $('<i></i>').addClass('icon icon-datasets-' + item.dataset);
						}


						if (item.detail) {
							title.append($('<small></small>').text(item.detail));
						} else {
							title.addClass('vertical-center');
						}

						return $('<li></li>').addClass("row").append(
							$('<a></a>').attr({'href': item.link, 'target': '_self'}).append(
								$('<div></div>').addClass('col-xs-1 _label').append(image)
							).append(
								$('<div></div>').addClass('col-xs-9 col-sm-10 col-md-11 _title').append(title)
							)
						).appendTo(ul);
					}
				};
			}
		});
	}
}(jQuery));
