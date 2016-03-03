
$(document).ready(function() {

    var DocTable = function($$) {
        this.$$ = $$;
        this.doc = this.$$.data('doc');
        this.documentId = this.$$.data('document-id');
        this.view = 'document';
        this.$preview = this.$$.find('.preview').first();
        this.$toolbar = this.$$.find('.toolbar').first();
        this.$activePage = false;
        this.$viewSelect = this.$toolbar.find('.viewSelect').first();
        this.tables = this.$$.data('tables');
        this.tablesData = this.$$.data('tables-data');
        this.values = [];
        this.$preview.html(this.getPreviewDOM());
        this.mouseX = 0;
        this.mouseY = 0;
        this.createdTable = false;
        this.$createdTable = false;

        var self = this;

        this.$preview.on('mousemove', '.page', function(e) {
            var x = e.pageX - this.offsetLeft,
                y = e.pageY - this.offsetTop;

            if($(e.target).hasClass('table')) {
                var $table = $(e.target),
                    index = parseInt($table.data('index'));

                if(self.tables.hasOwnProperty(index)) {
                    var table = self.tables[index],
                        $line = $table.find('.line').first();
                    if(x < table.x + 20) {
                        // draw line for new row
                        $line.show();
                        $line.css({
                            marginLeft: 0,
                            marginTop: y - table.y,
                            width: table.width - 2,
                            height: 1
                        });
                    } else if(y < table.y + 20) {
                        // draw line for new col
                        $line.show();
                        $line.css({
                            marginLeft: x - table.x,
                            marginTop: 0,
                            width: 1,
                            height: table.height - 2
                        });
                    } else {
                        $line.hide();
                    }
                }
            } else {
                self.$preview.find('.line').hide();
            }

            self.onMouseMove(x, y);
        });

        this.$preview.on('mouseenter', '.page', function() {
            self.setActivePage($(this).data('index'));
        });

        this.$preview.on('mousedown', '.page', function(e) {
            var $table, index, table, tableIndex;
            if($(e.target).hasClass('removeTableAction')) {
                $table = $(e.target).parent().parent();
                index = parseInt($table.data('index'));

                if(self.tables.hasOwnProperty(index)) {
                    self.tables[index] = false;
                    $table.fadeOut(300, function() {
                        $(this).remove();
                    });
                }

                return false;
            } else if($(e.target).hasClass('table')) {
                $table = $(e.target);
                index = parseInt($table.data('index'));

                if(self.tables.hasOwnProperty(index)) {
                    table = self.tables[index];
                    if(self.mouseX < table.x + 20) {
                        // create new row
                        table.rows.push(self.mouseY - table.y);
                        $table.append('<div data-index="' + (table.rows.length - 1) + '" style="width: ' + (table.width - 2) + 'px; margin-top: ' + (self.mouseY - table.y) + 'px;" class="row"><div class="opt"><button type="button" class="btn btn-danger btn-xs removeRowAction"><span aria-hidden="true" class="removeRowActionSpan">&times;</span></button></div></div>');
                    } else if(self.mouseY < table.y + 20) {
                        // create new col
                        table.cols.push(self.mouseX - table.x);
                        $table.append('<div data-index="' + (table.cols.length - 1) + '" style="height: ' + (table.height - 2) + 'px; margin-left: ' + (self.mouseX - table.x) + 'px;" class="col"><div class="opt" style="margin-top: ' + (table.height - 2) + 'px;"><button type="button" class="btn btn-danger btn-xs removeColAction"><span aria-hidden="true" class="removeColActionSpan">&times;</span></button></div></div>');
                    }
                }

            } else if(
                $(e.target).hasClass('removeRowAction') ||
                $(e.target).hasClass('removeRowActionSpan')
            ) {
                var $row = $(e.target).hasClass('removeRowAction') ?
                    $(e.target).parent().parent() :
                    $(e.target).parent().parent().parent();

                $table = $row.parent();
                tableIndex = $table.data('index');
                var rowIndex = $row.data('index');

                if(self.tables.hasOwnProperty(tableIndex)) {
                    table = self.tables[tableIndex];
                    if(table.rows.hasOwnProperty(rowIndex)) {
                        table.rows[rowIndex] = false;
                        $row.fadeOut(300, function() {
                            $(this).remove();
                        });
                    }
                }

                return false;

            } else if(
                $(e.target).hasClass('removeColAction') ||
                $(e.target).hasClass('removeColActionSpan')
            ) {

                var $col = $(e.target).hasClass('removeColAction') ?
                    $(e.target).parent().parent() :
                    $(e.target).parent().parent().parent();

                $table = $col.parent();
                tableIndex = $table.data('index');
                var colIndex = $col.data('index');

                if(self.tables.hasOwnProperty(tableIndex)) {
                    table = self.tables[tableIndex];
                    if(table.cols.hasOwnProperty(colIndex)) {
                        table.cols[colIndex] = false;
                        $col.fadeOut(300, function() {
                            $(this).remove();
                        });
                    }
                }

                return false;

            } else if($(e.target).hasClass('tableNameInput')) {

            } else {
                self.createdTable = {
                    from: {
                        x: self.mouseX,
                        y: self.mouseY
                    }
                };

                if (self.$createdTable) {
                    self.$createdTable.remove();
                    self.$createdTable = false;
                }

                self.$activePage.append('<div style="margin-top: ' + self.createdTable.from.y + 'px; margin-left: ' + self.createdTable.from.x + 'px;" class="createdTable"></div>');
                self.$createdTable = self.$activePage.find('.createdTable').first();
            }
        });

        this.$preview.on('mouseup', '.page', function(e) {
            if(self.createdTable) {
                if((typeof self.createdTable.to.x != 'undefined' ?  self.createdTable.to.x : 0) - self.createdTable.from.x > 30) {
                    self.addTable(
                        self.createdTable.from.x,
                        self.createdTable.from.y,
                        self.createdTable.to.x - self.createdTable.from.x,
                        self.createdTable.to.y - self.createdTable.from.y
                    );
                }

                self.createdTable = false;
                if (self.$createdTable) {
                    self.$createdTable.remove();
                    self.$createdTable = false;
                }
            }
        });

        this.$viewSelect.on('click', 'label', function(e) {
            var $radio = $(e.target).find('input').first();
            if($radio.val() == 'document') {
                self.$preview.html(self.getPreviewDOM());
                self.view = 'document';
            } else {
                self.$preview.html(self.getDataDOM());
                self.view = 'data';
            }
        });

        this.$preview.on('change', 'input.tableNameInput', function() {
            var tableIndex = $(this).data('table-index');
            if(self.tables.hasOwnProperty(tableIndex)) {
                self.tables[tableIndex].name = $(this).val();
            }
        });

        this.$preview.on('change', 'input.singleDataValue', function() {
            var table = $(this).closest('table').first(),
                tableIndex = table.data('table-index'),
                rowIndex = $(this).data('row-index'),
                colIndex = $(this).data('col-index');

            if(
                self.tables.hasOwnProperty(tableIndex) &&
                self.tables[tableIndex].data.hasOwnProperty(rowIndex) &&
                self.tables[tableIndex].data[rowIndex].hasOwnProperty(colIndex)
            ) {
                self.tables[tableIndex].data[rowIndex][colIndex] = $(this).val();
            }
        });

        this.$toolbar.find('.saveDocTables').click(function() {
            if(self.view == 'document') {
                $.post('/admin/docs/saveTables/' + self.documentId + '.json', {
                    tables: self.tables
                }, function(res) {
                    if(res === true) {
                        alert('Zapisano poprawnie');
                    } else {
                        alert('Wystąpił błąd podczas zapisywania');
                    }
                });
            } else {
                var name = prompt('Podaj opcjonalną nazwę zapisywanych danych');
                $.post('/admin/docs/saveTablesData/' + self.documentId + '.json', {
                    tables: self.tables,
                    name: name
                }, function(res) {
                    if(res === true) {
                        alert('Zapisano poprawnie');
                    } else {
                        alert('Wystąpił błąd podczas zapisywania');
                    }
                });
            }

            return false;
        });

        this.$toolbar.find('.importDocTables').click(function() {
            var fileInput = $('#importLocalFile');
            fileInput.change(function() {
                if(this.files.hasOwnProperty(0)) {
                    var file = this.files[0];
                    var fr = new FileReader();
                    fr.onload = function(e) {
                        self.tables = JSON.parse(e.target.result);
                        self.view = 'document';
                        self.$preview.html(self.getPreviewDOM());
                        return false;
                    };
                    fr.readAsText(file);
                }
            });
            fileInput.click();
            return false;
        });

        this.$toolbar.find('.exportDocTables').click(function() {
            var a = document.getElementById('forceDownloadFile');
            a.setAttribute('href', 'data:text/json;charset=utf-8,' + encodeURIComponent(JSON.stringify(self.tables)));
            a.setAttribute('download', 'doc_' + self.documentId + '_data.json');
            a.click();
            return false;
        });

        this.$toolbar.find('.increaseTextFont').click(function() {
            var font = parseInt(self.$preview.find('.text').css("font-size"));
            self.$preview.find('.text').css({
                'font-size': (font + 1) + 'px'
            });
        });

        this.$toolbar.find('.decreaseTextFont').click(function() {
            var font = parseInt(self.$preview.find('.text').css("font-size"));
            self.$preview.find('.text').css({
                'font-size': (font - 1) + 'px'
            });
        });
    };

    DocTable.prototype = {

        constructor: DocTable,

        getDataDOM: function() {
            var dom = ['<div class="container"><h1 class="text-muted">Dane</h1>'];

            dom.push('<h2 class="text-muted">Archiwum</h2>');

            if(this.tablesData.length === 0) {
                dom.push('<div class="alert alert-info" role="alert">Brak danych w archiwum</div>');
            } else {
                dom.push('<ul class="list-group">');
                for(var td = 0; td < this.tablesData.length; td++) {
                    dom.push([
                        '<li class="list-group-item">',
                            '<span class="badge"><abbr title="Ilość tabel">', this.tablesData[td]['0']['tables'] ,'</abbr></span>',
                            '<a href="/admin/docs/tableData/', this.tablesData[td]['doctable_data']['id'] ,'">',
                            this.tablesData[td]['doctable_data']['name'] != '' ? this.tablesData[td]['doctable_data']['name'] : 'Brak nazwy',
                            '</a>',
                            ' zapisano dnia ',
                            this.tablesData[td]['doctable_data']['created_at'],
                            ' przez ',
                            '<a href="/dane/uzytkownicy/', this.tablesData[td]['doctable_data']['user_id'] ,'">',
                            this.tablesData[td]['users']['username'],
                            '</a>',
                        '</li>'
                    ].join(''));
                }
                dom.push('</ul>');
            }

            dom.push('<h2 class="text-muted">Nowe dane</h2>');

            if(this.tables.length === 0) {
                dom.push('<div class="alert alert-warning" role="alert">Nie utworzyłeś/aś jeszcze żadnej tabeli w widoku <em>Dokument</em></div>');
            }

            this.tables.sort(function(a, b) {
                return a.pageIndex == b.pageIndex ? 0 :
                    (a.pageIndex < b.pageIndex) ? -1 : 1;
            });

            for(var tt = 0; tt < this.tables.length; tt++) {
                var table = this.tables[tt];
                if(table === false)
                    continue;

                dom.push('<small class="text-muted">Strona ' + (table.pageIndex + 1) + '</small>');
                dom.push('<div class="panel panel-default">');
                dom.push('<div class="panel-heading"><input class="form-control tableNameInput" data-table-index="' + tt + '" type="text" placeholder="Nazwa tabeli" value="' + table.name + '"></div>');
                dom.push('<table data-table-index="' + tt + '" class="table table-bordered">');

                var data = [];

                if(this.doc.pages.hasOwnProperty(table.pageIndex)) {
                    var texts = this.doc.pages[table.pageIndex].texts;
                    texts.sort(function(a, b) {
                        if(a.top == b.top)
                            return (a.left < b.left) ? -1 : (a.left > b.left) ? 1 : 0;
                        else
                            return (a.top < b.top) ? -1 : 1;
                    });

                    var rows = [];
                    var cols = [];
                    for(var _r = 0; _r < table.rows.length; _r++)
                        if(table.rows[_r] !== false)
                            rows.push(table.rows[_r]);
                    for(_r = 0; _r < table.cols.length; _r++)
                        if(table.cols[_r] !== false)
                            cols.push(table.cols[_r]);

                    rows.sort(function(a, b) {
                        return b > a ? -1 : 1;
                    });

                    var _rows = [];
                    if(rows.length > 0) {
                        _rows.push({
                            from: 0,
                            to: rows[0]
                        });

                        if(rows.length == 1) {
                            _rows.push({
                                from: _rows[0].to,
                                to: table.height
                            });
                        } else {
                            for (var r = 1; r < rows.length; r++) {
                                _rows.push({
                                    from: _rows[_rows.length - 1].to,
                                    to: rows[r]
                                });
                            }
                            _rows.push({
                                from: _rows[_rows.length - 1].to,
                                to: table.height
                            });
                        }

                    } else {
                        _rows.push({
                            from: 0,
                            to: table.height
                        });
                    }

                    cols.sort(function(a, b) {
                        return b > a ? -1 : 1;
                    });

                    var _cols = [];
                    if(cols.length > 0) {
                        _cols.push({
                            from: 0,
                            to: cols[0]
                        });

                        if(cols.length == 1) {
                            _cols.push({
                                from: _cols[0].to,
                                to: table.width
                            });
                        } else {
                            for (var c = 1; c < cols.length; c++) {
                                _cols.push({
                                    from: _cols[_cols.length - 1].to,
                                    to: cols[c]
                                });
                            }
                            _cols.push({
                                from: _cols[_cols.length - 1].to,
                                to: table.width
                            });
                        }

                    } else {
                        _cols.push({
                            from: 0,
                            to: table.width
                        });
                    }

                    if(
                        typeof this.tables[tt].data !== 'undefined' &&
                        this.tables[tt].data.length == _rows.length &&
                        this.tables[tt].data[0].length == _cols.length
                    ) {
                        data = this.tables[tt].data;
                    } else {

                        for (r = 0; r < _rows.length; r++) {
                            var values = [];
                            for (c = 0; c < _cols.length; c++) {
                                var value = '';
                                var margin = 10;
                                for (var t = 0; t < texts.length; t++) {
                                    var text = texts[t],
                                        textRowFrom = parseInt(text.top),
                                        textRowTo = parseInt(text.top) + parseInt(text.height),
                                        textColFrom = parseInt(text.left),
                                        textColTo = parseInt(text.left) + parseInt(text.width);
                                    if (
                                        textRowFrom + margin >= (table.y + _rows[r].from) &&
                                        textRowTo - margin <= (table.y + _rows[r].to) &&
                                        textColFrom + margin >= (table.x + _cols[c].from) &&
                                        textColTo - margin <= (table.x + _cols[c].to)
                                    ) {
                                        value += ' ' + text.content;
                                    }

                                }

                                values.push(value);
                            }
                            data.push(values);
                        }

                        this.tables[tt].data = data;
                    }
                }

                for(r = 0; r < data.length; r++) {
                    dom.push('<tr>');
                    for(c = 0; c < data[r].length; c++) {
                        dom.push('<td><input type="text" data-row-index="' + r + '" data-col-index="' + c + '" class="form-control singleDataValue" value="' + data[r][c] + '"/></td>');
                    }
                    dom.push('</tr>');
                }


                dom.push('</table>');
                dom.push('</div>');
            }

            dom.push('</div>');

            return dom.join('');
        },

        getPreviewDOM: function() {
            var dom = [];
            for(var p = 0; p < this.doc.pages.length; p++) {
                var page = this.doc.pages[p];
                dom.push('<div class="page" style="width: ' + page.width + 'px; height: ' + page.height + 'px;" data-index="' + p + '">');
                for(var t = 0; t < page.texts.length; t++) {
                    var text = page.texts[t];
                    dom.push('<div class="text" style="margin-top: ' + text.top + 'px; margin-left: ' + text.left + 'px; width: ' + text.width + 'px; height: ' + text.height + 'px;" data-page-index="' + p + '" data-index="' + t + '">' + text.content + '</div>');
                }

                for(t = 0; t < this.tables.length; t++) {
                    if(this.tables.hasOwnProperty(t)) {
                        if(this.tables[t].pageIndex == p) {
                            var table = this.tables[t];
                            dom.push('<div style="margin-top: ' + table.y + 'px; margin-left: ' + table.x + 'px; width: ' + table.width + 'px; height: ' + table.height + 'px;" data-index="' + t + '" class="table"><div class="options"><button type="button" class="btn btn-danger btn-sm removeTableAction">Usuń</button><input class="form-control input-sm tableNameInput" data-table-index="' + t + '" style="width: ' + (table.width - 55) + 'px;" type="text" placeholder="Nazwa tabeli" value="' + table.name + '"></div><div class="line"></div>');

                            for(var r = 0; r < table.rows.length; r++) {
                                var row = table.rows[r];
                                if(row === 0 || row === false) continue;
                                dom.push('<div data-index="' + r + '" style="width: ' + (table.width - 2) + 'px; margin-top: ' + row + 'px;" class="row"><div class="opt"><button type="button" class="btn btn-danger btn-xs removeRowAction"><span aria-hidden="true" class="removeRowActionSpan">&times;</span></button></div></div>');
                            }

                            for(var c = 0; c < table.cols.length; c++) {
                                var col = table.cols[c];
                                if(col === 0 || col === false) continue;
                                dom.push('<div data-index="' + c + '" style="height: ' + (table.height - 2) + 'px; margin-left: ' + col + 'px;" class="col"><div class="opt" style="margin-top: ' + (table.height - 2) + 'px;"><button type="button" class="btn btn-danger btn-xs removeColAction"><span aria-hidden="true" class="removeColActionSpan">&times;</span></button></div></div>');
                            }

                            dom.push('</div>');
                        }
                    }
                }

                dom.push('</div>');
            }

            return dom.join('');
        },

        setActivePage: function(index) {
            if(this.$activePage !== false) {
                this.createdTable = false;
                if(this.$createdTable) {
                    this.$createdTable.remove();
                    this.$createdTable = false;
                }

                this.$activePage.removeClass('active');
            }

            this.$activePage = this.$preview.find('.page[data-index="' + index + '"]').first();
            this.$activePage.addClass('active');
        },

        onMouseMove: function(x, y) {
            this.mouseX = parseInt(x || 0);
            this.mouseY = parseInt(y || 0);

            if(this.createdTable && this.$createdTable) {
                this.createdTable.to = {
                    x: this.mouseX,
                    y: this.mouseY
                };

                this.$createdTable.css({
                    width: Math.abs(this.createdTable.to.x - this.createdTable.from.x),
                    height: Math.abs(this.createdTable.to.y - this.createdTable.from.y)
                });
            }
        },

        addTable: function(x, y, width, height) {
            this.tables.push({
                x: x,
                y: y,
                width: width,
                height: height,
                pageIndex: this.$activePage.data('index'),
                rows: [],
                cols: [],
                name: 'Tabela #' + (this.tables.length)
            });

            var table = this.tables[this.tables.length - 1];
            this.$activePage.append('<div style="margin-top: ' + table.y + 'px; margin-left: ' + table.x + 'px; width: ' + table.width + 'px; height: ' + table.height + 'px;" data-index="' + (this.tables.length - 1) + '" class="table"><div class="options"><button type="button" class="btn btn-danger btn-sm removeTableAction">Usuń</button><input class="form-control input-sm tableNameInput" data-table-index="' + (this.tables.length - 1) + '" style="width: ' + (table.width - 55) + 'px;" type="text" placeholder="Nazwa tabeli" value="' + table.name + '"></div><div class="line"></div></div>');
        }

    };

    var doctables = [];
    $('.doctable').each(function() {
        doctables.push(
            new DocTable($(this))
        );
    });

});