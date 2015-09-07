/**
 * Created by tomaszdrazewski on 19/08/15.
 */
$(document).ready(function () {

	var pages = $('.page');
	var global_height = 0;

	pages.each(function(){
		page=$(this);
		var page_width = ( page.attr('width') );
		var page_height = Number(page.attr('height'));

		page.css('width', page_width + 'px');
		page.css('height', page_height + 'px');

		if(page.attr('number')==1){
			page.remove();
		}

		var elements = page.find('p');
		elements.each(function(){
			element=$(this);
			var left = Number(element.attr('left'));
			var top = Number(element.attr('top'));
			var width = Number(element.attr('width'));
			var height = Number(element.attr('height'));

			if (top < 165 || left > 1055 || top > 700) {

				element.remove();

			} else {
				element.css('margin-top', top + 'px');
				element.css('min-height', height + 'px');
				element.css('margin-left', left + 'px');
				element.css('min-width', width + 'px');
			}
		});
	})
$('.add_vertical').click(function(){

	var counter=$(this).find('.line_counter');
	counter.html(parseInt(counter.html())+1);
	pages.each(function(){
		page=$(this);
		page.append('<span class="vert_line" data-line-no="'+counter.html()+'" style="height:'+page.outerHeight()+';"></span>')
		page.find('.vert_line[data-line-no="'+counter.html()+'"]').draggable({
			axis: "x",
			cursor: "crosshair",
			stop: function(e, ui) {
				if(!event.altKey) {
					$('.vert_line[data-line-no="' + $(this).data('line-no') + '"]').css({
						left: $(this).css('left')
					});
				}
			}
		});
	})
});
$('.calculate_fields').click(function(){
	pages.each(function(){
		page=$(this);
		var pozycje=[];
		page.find('.vert_line').each(function(){
			pozycje.push($(this).css('left').replace('px',''));
		});
		var last_pozycja=0;
		pozycje.sort(function(a, b){return a-b});
		$.each(pozycje, function(i,pozycja){
			page.find('p').each(function(){
				left=parseInt($(this).css('margin-left').replace('px',''))+14;
				if(left<pozycja){ if(left>last_pozycja){
					col_no=parseInt(i)+1;
					$(this).addClass('kolumna-'+col_no+'');
					$(this).attr('data-col-no', col_no);
				}}
			})
			last_pozycja=pozycja;
		})

		var wiersze=[];
		page.find('.kolumna-5').each(function(){
			wiersze.push(parseInt($(this).css('margin-top').replace('px',''))+parseInt($(this).css('min-height').replace('px','')));
		});
		var last_wiersz=0;
		wiersze.sort(function(a, b){return a-b});
		$.each(wiersze, function(j, wiersz){
			page.find('p').each(function(){
				dist_top=parseInt($(this).css('margin-top').replace('px',''))+4;
				if(dist_top<=wiersz && dist_top>last_wiersz){
					row_no=parseInt(j)+1;
					$(this).addClass('wiersz-'+row_no+'');
					$(this).attr('data-row-no', row_no);
				}
			})
			last_wiersz=wiersz;
		})
	})
});

	$('.save-doc').click(function(){
		console.log("Przygotowanie danych \n")

		var data=[];
		$('.page').each(function(i){
			strona=[];
			$(this).find('p').each(function(){

				if($(this).attr('data-col-no')>4 && $(this).attr('data-col-no')<10 && $(this).attr('width')>90){
					var kwoty=$(this).html().split(' ');
					kwoty=kwoty.filter(Number);
					p=$(this);
					var i=0;
					$.each(kwoty, function(k,v){
						strona.push([
							parseInt(p.attr('data-col-no'))+i,
							p.attr('data-row-no'),
							v
						]);
						i++;
					});
				}else {
					strona.push([
						$(this).attr('data-col-no'),
						$(this).attr('data-row-no'),
						$(this).html()
					]);
				}
			});
			data.push(strona);
		});
		dane=JSON.stringify(data);
		$.ajax({
			url: "",
			method: "post",
			data: {'dane':dane},
			success: function (res) {
				if (res == false) {
					alert("Wystąpił błąd");
				} else {
					//window.location.href = "docs/" + doc_id + "";
				}
			},
			error: function (xhr) {
				alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
			}
		});

		/*var data=[];
		var row_num=0;
		pages.first().each(function(){
			console.log("Strona\n")
			row_num=$('.kolumna-5').length;
			for(_i=2;_i++;_i<row_num){
				console.log('Wiersz '+_i+"\n")
				var row=[];
				$('p[data-row-no='+_i+']').each(function(){
					col_no=$(this).attr('data-col-no');
					row[col_no]=$(this).html();
				})
				data.push(row);
			}
		})*/
	});

/*
		var Item = Class.create({
		nextRowId: 0,
		columns: [
			{'id': '1', 'offset': 105, 'color': '#00FF99'},
			{'id': '2', 'offset': 131, 'color': '#00CCFF'},
			{'id': '3', 'offset': 161, 'color': '#FF99CC'},
			{'id': '4', 'offset': 495, 'color': '#00FF99'},
			{'id': '5', 'offset': 529, 'color': '#00CCFF'},
			{'id': '6', 'offset': 576, 'color': '#FF99CC'},
			{'id': '7', 'offset': 636, 'color': '#00FF99'},
			{'id': '8', 'offset': 699, 'color': '#00CCFF'},
			{'id': '9', 'offset': 762, 'color': '#FF99CC'},
			{'id': '10', 'offset': 821, 'color': '#00FF99'},
			{'id': '11', 'offset': 883, 'color': '#00CCFF'},
			{'id': '12', 'offset': 945, 'color': '#FF99CC'},
			{'id': '13', 'offset': 10000, 'color': '#00FF99'},


		],
		init: function (data, html) {
			this.data = data;
			this.id = Number(this.data.id);


			mBrowser.itemTitleUpdate('&nbsp;');
			this.btnSave = mBrowser.addItemButton('save', 'Zapisz', this.save.bind(this));
			// this.btnAnalyze = mBrowser.addItemButton('analyze', 'Analiza', this.analyze.bind(this));


			$('side_div').update('<div id="dokument" class="_height_controll" height_offset="-10"><div id="docBrowser"></div></div>');
			$('dokument').height_control();

			this.docBrowser = jQuery('#docBrowser');
			this.docBrowser.append(html);


			var pages = this.docBrowser.find('.page');
			var global_height = 0;

			for (var _p = 0; _p < pages.length; _p++) {


				var page = jQuery(pages[_p]);

				var page_width = ( page.attr('width') );
				var page_height = Number(page.attr('height'));

				page.css('width', page_width + 'px');
				page.css('height', page_height + 'px');


				for (var _c = 0; _c < this.columns.length; _c++) {

					var border_left = this.columns[_c]['offset'];
					page.append('<span style="margin-left: ' + border_left + 'px; height: ' + page_height + 'px;" class="vert_line"></span>');

				}


				var rows = [];


				// PRZYGOTOWYWANIE KOLUMN

				var elements = page.find('p');
				for (var _e = 0; _e < elements.length; _e++) {

					var element = jQuery(elements[_e]);

					var left = Number(element.attr('left'));
					var top = Number(element.attr('top'));
					var width = Number(element.attr('width'));
					var height = Number(element.attr('height'));

					if (top < 160 || left > 1055) {

						element.remove();

					} else {

						element.css('margin-top', top + 'px');
						element.css('min-height', height + 'px');
						element.css('margin-left', left + 'px');
						element.css('min-width', width + 'px');


						for (var _c = 0; _c < this.columns.length; _c++) {

							var col = this.columns[_c];

							if (left < col.offset - 3) {

								var right_border = left + width;
								if ((_c < this.columns.length - 1) && (right_border > this.columns[_c + 1]['offset'])) {

									var parts = element.text().trim().split(' ');
									if (parts.length) {

										element.text(parts[0]);
										element.css('min-width', 'inherit');

										var last_element = element;

										for (var _n = 1; _n < parts.length; _n++) {

											left += (width / parts.length);

											var part = parts[_n];
											var new_element = jQuery('<p font="1" height="' + height + '" width="' + width + '" left="' + left + '" top="' + top + '" style="margin-top: ' + top + 'px; margin-left: ' + left + 'px;">' + part + '</p>');

											last_element.after(new_element);
											last_element = new_element;

										}

									}

									element.attr('right_border', right_border);
									element.attr('parts_count', parts.length);
									element.css('background-color', col.color);

								}

								// element.attr('col', _c);
								// element.css('background-color', col.color);

								if (_c == 4) {

									var border_top = top + height + 3;

									page.append('<span style="margin-top: ' + border_top + 'px; width: ' + page_width + 'px;" class="hor_line"></span>');

									rows.push(border_top);

								}

								break;

							}

						}

						page.attr('rows_count', rows.length);

					}

				}


				// OZNACZANIE KOLUMN

				var elements = page.find('p');
				for (var _e = 0; _e < elements.length; _e++) {

					var element = jQuery(elements[_e]);
					var left = Number(element.attr('left'));

					for (var _c = 0; _c < this.columns.length; _c++) {

						var col = this.columns[_c];

						if (left < col.offset - 3) {

							element.attr('col', _c);
							element.css('background-color', col.color);

							break;

						}

					}

				}


				rows.push(10000);


				// OZNACZENIE RZĘDÓW

				var elements = page.find('p');
				for (var _e = 0; _e < elements.length; _e++) {

					var element = jQuery(elements[_e]);

					var top = Number(element.attr('top'));
					var height = Number(element.attr('height'));


					for (var _r = 0; _r < rows.length; _r++) {

						if ((top + height) < rows[_r]) {

							element.attr('row', _r);

							break;

						}

					}


				}


			}


		},
		getNewRowId: function () {

			this.nextRowId++;
			return this.nextRowId;

		},
		save: function () {
			if (mBrowser.enabled) {

				var data = {};


				for (var _c = 0; _c < this.columns.length; _c++) {

					var r = 0;
					data[_c] = {};

					var pages = this.docBrowser.find('.page');
					for (var _p = 0; _p < pages.length; _p++) {

						var page = jQuery(pages[_p]);
						var rows_count = Number(page.attr('rows_count'));

						for (var _r = 0; _r < rows_count; _r++) {

							var elements = page.find('p[col=' + _c + '][row=' + _r + ']');

							if (elements.length) {

								data[_c][r] = jQuery(elements).text();

							}

							r++;

						}

					}


				}

				console.log(data);
				// return false;


				var params = {
					'id': this.id,
					'data': data,
					'col_count': this.columns.length,
					'rows_count': r,
				};

				mBrowser.disable_loading();
				this.btnSave.disable();

				$POST_SERVICE('zapisz', params, this.onSave.bind(this), function () {
					mBrowser.disable_loading
					this.btnSave.enable();
				}.bind(this));

			}
		},
		onSave: function (data) {
			if (data == '4') {
				mBrowser.enable_loading();
				$LICZNIKI.update();
				if (mBrowser.category.id == 'doakceptu') {
					mBrowser.markAsDeleted(this.id);
					mBrowser.loadNextItem();
				}
			} else alert('Element nie został zapisany');
			mBrowser.enable_loading();
			this.btnSave.enable();
		}
	});

	var MBrowser = Class.create(MBrowser, {
		getListItemInnerHTML: function (data) {
			return data['id'];
		}
	});

	var item;
	var mBrowser;

	$M.addInitCallback(function () {
		Event.observe(document, 'keypress', function (event) {
			if (event.ctrlKey && event.charCode == 115) druk.save();
		});
	});
	*/
});
