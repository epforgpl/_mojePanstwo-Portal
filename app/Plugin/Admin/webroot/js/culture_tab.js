function isNumeric(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}

var _TAB = Class.extend({
	div: false,
	table: false,
	inputTitle: false,
	columnsCount: false,
	rowsCount: false,
	delete_columns_after: false,
	modal: false,
	modalBody: false,
	
	
	init: function( div ) {
		
		this.div = $(div);
		this.table = this.div.find('div.table');
		this.inputTitle = this.div.find('input[name=title]');
		
		this.modal = $('#modal-preview');
		this.modalBody = this.modal.find('.modal-body');
		
		this.fixTable();
		this.addControlls();
		this.count();
		
		if( this.delete_columns_after!==false ) {
			for( var i=this.delete_columns_after; i<this.columnsCount; i++ ) {
				this.table.find('td[column=' + i + ']').remove();
			}
			this.count();		
		}
		
		var self = this;
		$('#btn-preview').click(function(event){
			event.preventDefault();
			self.preview();
		});
		
		var self = this;
		this.modal.find('.btn-save').click(function(event){
			
			event.preventDefault();
			self.modal.find('.btn-save').attr('disabled', 'disabled');
			
			var params = {
				'title': self.inputTitle.val(),
				'surveys': []
			};
			
			var surveys = self.modalBody.find('.survey');
			for( var i=0; i<surveys.length; i++ ) {
				
				var survey_element = $(surveys[i]);
				
				params.surveys.push({
					title: survey_element.find('.title').text(),
					html: survey_element.find('.table-container').html()
				});
				
			}
			
			$.ajax({
				type: "POST",
				url: '/admin/kultura/pliki/' + _tab_id + '.json',
				data: params,
				success: function(){
					
					self.modal.find('.btn-save').attr('disabled', null);
					self.modal.modal('hide');
					
				}
			});
			
		});
				
	},
	preview: function() {
				
		this.modal.find('.btn-save').attr('disabled', null);
		var survey_tds = _tab.table.find('td.survey[row=0]');
		var length = survey_tds.length;
		
		this.modalBody.html('<ul class="surveys"></ul>');
		var surveys_ul = this.modalBody.find('ul.surveys');
		
		if( length ) {
			
			
			
			for( var i=0; i<length; i++ ) {
				
				var title = '';
				var table_html = '<table>';
				
				var survey_td = $( survey_tds[ i ] );
				
				var nav = {
					first: Number( survey_td.attr('column') )
				};
				
				if( i==length-1 ) {
					nav.last = this.columnsCount;
				} else {
					var last_survey_td = $( survey_tds[ i+1 ] );
					nav.last = last_survey_td.attr('column')-1;
				}
				
				var td = this.table.find('td:not(.ctrl)[row=0][column=' + nav.first + ']');
				title = td.text();
				
				for( var r=1; r<this.rowsCount; r++ ) {
					
					table_html += '<tr>';
					
					var td = this.table.find('td:not(.ctrl)[row=' + r + '][column=1]');
					table_html += '<td>' + td.text() + '</td>';
					
					for( var c=nav.first; c<=nav.last; c++ ) {
						
						var td = this.table.find('td:not(.ctrl)[row=' + r + '][column=' + c + ']');
						table_html += '<td>' + td.text() + '</td>';
						
					}
					
					table_html += '</tr>';
					
				}
				
				table_html += '</table>';
				
				surveys_ul.append('<li class="survey"><p class="title">' + title + '</p><div class="table-container">' + table_html + '</div></li>');		
				
			}
			
			
			
			
			
			this.modal.modal('show');
		
		}
			
	},
	addControlls: function() {
		
		this.count();
		
		var tr = $('<tr class="ctrl"></tr>');
		for( var i=0; i<this.columnsCount; i++ ) {
			
			var td = $('<td class="ctrl ctrl-column"></td>');
			tr.append(td);
			
		}
		this.table.find('tbody').prepend( tr );
		
		
		var trs = this.table.find('tr');
		for( var i=0; i<trs.length; i++ ) {
			
			var tr = $( trs[i] );
			
			if( i>1 )
				var td = $('<td class="ctrl ctrl-row"></td>');
			else
				var td = $('<td class="ctrl"></td>');
				
			tr.prepend(td);
			
		}
		
		
		var ctrls = this.table.find('td.ctrl');
		for( var i=0; i<ctrls.length; i++ ) {
			
			var ctrl = $( ctrls[i] );
			var options = false;
			
			if( ctrl.hasClass('ctrl-column') ) {
				options = '<li><a data-action="remove-column" href="#">Usuń kolumnę</a></li><li><a data-action="set-survey" href="#">Ustaw pytanie</a></li>';
			} else if( ctrl.hasClass('ctrl-row') ) {
				options = '<li><a data-action="remove-row" href="#">Usuń rząd</a></li>';
			}
			
			if( options!==false ) {
			
				ctrl.html('<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><span class="caret"></span></a><ul class="dropdown-menu" role="menu">' + options + '</ul></li>');
			
			}
			
		}
		
		var self = this;
		this.table.find('a[data-action=remove-column]').click(function(event){
			event.preventDefault();
			self.removeColumn( $(event.target).parents('td.ctrl').attr('column') );
		});
		this.table.find('a[data-action=remove-row]').click(function(event){
			event.preventDefault();
			self.removeRow( $(event.target).parents('td.ctrl').attr('row') );			
		});	
		this.table.find('a[data-action=set-survey]').click(function(event){
			event.preventDefault();
			self.setSurvey( $(event.target).parents('td.ctrl').attr('column') );
		});	
			
	},
	setSurvey: function( col ) {
		
		this.table.find('td[column=' + col + ']').addClass('survey');
		
	},
	removeColumn: function( col ) {
		
		this.table.find('td[column=' + col + ']').remove();
		this.count();
		
	},
	removeRow: function( row ) {
		
		this.table.find('tr[row=' + row + ']').remove();
		this.count();
		
	},
	count: function() {
		
		this.columnsCount = false;
		this.rowsCount = false;
		
		
		var tds = this.table.find('tr.ctrl td.ctrl-column');
		for( var i=0; i<tds.length; i++ ) {
			$( tds[i] ).attr('column', i);
		}
		
		
		var trs = this.table.find('tr').not('.ctrl');
		this.rowsCount = trs.length;
		
		for( var i=0; i<this.rowsCount; i++ ) {
			
			
			var tr = $( trs[i] );
			var tds = tr.find('td').not('.ctrl');
			
			tr.attr('row', i);
			tr.find('td.ctrl').attr('row', i);
			
			var columnsCount = tds.length;
						
			if(
				this.columnsCount===false ||
				( columnsCount > this.columnsCount )
			)
				this.columnsCount = columnsCount;
			
			for( var j=0; j<columnsCount; j++ ) {
				
				var td = $(tds[j]);
				td.attr('row', i);
				td.attr('column', j);
				
			}
			
			
		}
			
	},
	fixTable: function() {
		
		
		
		// remove empty rows
		
		var trs = this.table.find('tr');
		for( var i=0; i<trs.length; i++ ) {
			
			
			var tr = $( trs[i] );
			var tds = tr.find('td');
			var empty_row = true;
						
			for( j=0; j<tds.length; j++ ) {
				
				var td = $( tds[j] );
				var text = td.text();
				
				td.html('<p class="_">' + text + '</p>');
				
				if( j==0 ) {
					
					if( text=='Lp.' || text=='Lp. ' ) {
						tr.addClass('optionsHeader');
					} else if( isNumeric(text) ) {
						tr.addClass('optionsRow');
					}
					
				}
				
				// if( i==0 ) {
					
					if( (text=='SPECIFICATION') || (text=='Specificacion') ) {
						this.delete_columns_after = j;
					}
					
				// }
				
				if( text!='' ) {
					empty_row = false;
				}
				
				
				
			}
			
			
			if( empty_row ) {
				tr.remove();
			}
			
			
		}
				
		
		// remove header rows

		var header_bufor = [];
		
		var trs = this.table.find('tr');
		for( var i=0; i<trs.length; i++ ) {
			
			var tr = $( trs[i] );
			
			if( tr.hasClass('optionsHeader') ) {
				break;
			} else {
				header_bufor.push( tr.find('td').text() );
				tr.remove();
			}
			
		}



		var title = false;
		if( header_bufor.length==4 ) {
			title = header_bufor[2];
		} else if( header_bufor.length==2 ) {
			title = header_bufor[0];
		}
		if( title ) {
			
			var match = title.match(/^Tabl\..*?\.\s*(.*?)\s*$/i);
			if( match )
				title = match[1];
				
			this.inputTitle.val( title );
			
		}
		
		
		
		this.table.find('._').draggable({
			revert: true
		});
		
		this.table.find('td').droppable({
			drop: function( event, ui ) {
				$(this).html(ui.draggable);
				$(event.target).removeClass('drop-over');
			},
			over: function( event, ui ) {
				$(event.target).addClass('drop-over');
			},
			out: function( event, ui ) {
				$(event.target).removeClass('drop-over');
			}
		});
		
					
		
	}
});

var _tab;

$(document).ready(function(){
	_tab = new _TAB('#_TAB');
});