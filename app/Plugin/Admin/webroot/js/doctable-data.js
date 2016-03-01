
$(document).ready(function() {

    var DocTableData = function($$) {
        this.$$ = $$;
        this.tableData = this.$$.data('table-data');
        this.tables = this.tableDataToTables(this.tableData);
        this.doc = this.tableData['doctable_data'][0]['doctable_data'];
        this.$preview = this.$$.find('.preview').first();
        this.$toolbar = this.$$.find('.toolbar').first();

        var self = this;

        self.$preview.html(
            self.getTablesDOM()
        );

        self.$preview.on('click', 'button.mergeTableAction', function() {
            var tableToIndex = $(this).data('tableIndex'),
                select = $('select[data-table-index="' + tableToIndex + '"]').first(),
                tableFromIndex = select.find(':selected').data('tableIndex');

            self.mergeTables(tableToIndex, tableFromIndex);
            self.$preview.html(self.getTablesDOM());
        });

        self.$preview.on('click', 'button.decreaseParentAction', function() {
            var row = $(this).closest('tr').first().data();
            self.tables[row['tableIndex']]['rowParents'][row['rowIndex']]--;
            self.$preview.html(self.getTablesDOM());
        });

        self.$preview.on('click', 'button.increaseParentAction', function() {
            var row = $(this).closest('tr').first().data();
            self.tables[row['tableIndex']]['rowParents'][row['rowIndex']]++;
            self.$preview.html(self.getTablesDOM());
        });

        self.$preview.on('change', 'input.tableName', function() {
            var tableIndex = $(this).data('tableIndex');
            self.tables[tableIndex].dbName = $(this).val();
            self.$preview.html(self.getTablesDOM());
        });

        self.$preview.on('change', 'input.tableColName', function() {
            var tableIndex = $(this).data('tableIndex'),
                colIndex = $(this).data('colIndex');
            self.tables[tableIndex].cols[colIndex].name = $(this).val();
        });

        self.$preview.on('change', 'input.tableColTypeSize', function() {
            var tableIndex = $(this).data('tableIndex'),
                colIndex = $(this).data('colIndex');
            self.tables[tableIndex].cols[colIndex].size = $(this).val();
            self.$preview.html(self.getTablesDOM());
        });

        self.$preview.on('change', 'select.tableColType', function() {
            var tableIndex = $(this).data('tableIndex'),
                colIndex = $(this).data('colIndex');
            self.tables[tableIndex].cols[colIndex].type = $(this).find(':selected').first().html();
            self.$preview.html(self.getTablesDOM());
        });

        this.$toolbar.find('.exportSQL').click(function() {
            console.log(self.getTablesAsSQL());
            /* var a = document.getElementById('forceDownloadFile');
            a.setAttribute('href', 'data:application/octet-stream;charset=utf-8,' + encodeURIComponent(self.getTablesAsSQL()));
            a.setAttribute('download', 'doc.sql');
            a.click(); */
            return false;
        });

    };

    DocTableData.prototype = {

        constructor: DocTableData,

        TYPES: [
            'VARCHAR',
            'CHAR',
            'TEXT',
            'INT',
            'BIGINT',
            'FLOAT'
        ],

        PARENT_COLORS: [
            '#fff',
            '#ccc',
            '#bbb',
            '#aaa',
            '#999',
            '#888',
            '#777',
            '#666',
            '#555',
            '#444',
            '#333',
            '#222'
        ],

        getTablesAsSQL: function() {
            var s = ['/* SQL */\n'];

            console.log(this.tables);

            for(var t = 0; t < this.tables.length; t++) {
                var table = this.tables[t];
                s.push('CREATE TABLE IF NOT EXISTS `' + table.dbName + '` (');
                s.push('\t`id` INT(11) UNSIGNED PRIMARY KEY AUTOINCREMENT,');
                s.push('\t`parent_id` INT(11) UNSIGNED DEFAULT 0,');

                for(var c = 0; c < table.cols.length; c++) {
                    var col = table.cols[c];
                    s.push('\t`' + col.name + '` ' + col.type + '(' + col.size + '),');
                }

                s.push('\tPRIMARY KEY (`id`)');
                s.push(');\n');
            }

            return s.join('\n');
        },

        mergeTables: function(toIndex, fromIndex) {
            var tableTo = this.tables[toIndex],
                tableFrom = this.tables[fromIndex];

            if(tableTo.cols.length != tableFrom.cols.length) {
                alert('Nie można połączyć tabel z różną ilością kolumn');
                return false;
            }

            for(var r = 0; r < tableFrom.rows.length; r++) {
                tableTo.rows.push(tableFrom.rows[r]);
                tableTo.rowParents.push(tableFrom.rowParents[r]);
            }

            this.tables.splice(fromIndex, 1);
        },

        tableDataToTables: function(tableData) {
            var tables = [];

            if(tableData.hasOwnProperty('doctable_data_tables')) {
                for(var t = 0; t < tableData['doctable_data_tables'].length; t++) {
                    var docTable = tableData['doctable_data_tables'][t],
                        values = docTable[0]['values'].split('[{~}]'),
                        data = docTable['doctable_data_table'],
                        table = {
                            name: data['name'],
                            dbName: 'table_' + t,
                            rows: [],
                            cols: [],
                            rowParents: []
                        },
                        c = 0,
                        v = 0,
                        rows = parseInt(data['rows']),
                        cols = parseInt(data['cols']);

                    for(var r = 0; r < rows; r++) {
                        var row = [];
                        while(c < cols) {
                            row.push(values[v]);
                            c++;
                            v++;
                        }
                        table.rows.push(row);
                        table.rowParents.push(0);
                        c = 0;
                    }

                    for(c = 0; c < cols; c++) {
                        table.cols.push({
                            name: 'col_' + c,
                            type: this.TYPES[0],
                            size: 255
                        });
                    }

                    tables.push(table);
                }
            }

            return tables;
        },

        getTablesDOM: function() {
            var dom = ['<div class="container"><h1 class="text-muted">Tabele</h1>'];
            dom.push('<a target="_blank" href="/admin/docs/tables/' + this.doc['document_id'] +'">Dokument źródłowy</a>');

            for(var t = 0; t < this.tables.length; t++) {
                var table = this.tables[t];
                dom.push('<div style="margin-top: 15px;" class="panel panel-default">');
                dom.push('<div class="panel-heading"><div class="clear row"><div class="clear col-sm-6"><input class="form-control tableName" data-table-index="' + t + '" type="text" placeholder="Nazwa" value="' + table.dbName + '"></div><div class="clear col-sm-1"></div><div class="clear col-sm-3"><select data-table-index="' + t + '" class="form-control">');

                for(var tt = 0; tt < this.tables.length; tt++) {
                    if(tt == t) continue;
                    dom.push('<option data-table-index="' + tt + '">' + this.tables[tt].dbName + '</option>');
                }

                dom.push('</select></div><div class="clear col-sm-2"><button class="btn btn-default btn-block mergeTableAction" data-table-index="' + t + '">Dodaj na koniec</button></div></div></div>');
                dom.push('<table data-table-index="' + t + '" class="table table-bordered">');

                if(table.rows.length > 0) {
                    dom.push('<tr class="types">');
                    dom.push('<td></td><td></td>');
                    for(var cc = 0; cc < table.cols.length; cc++) {
                        dom.push('<td><div class="row clear">');

                        dom.push('<div class="col-sm-6 clear"><input type="text" data-table-index="' + t + '" data-col-index="' + cc + '" class="form-control input-sm tableColName" value="' + table.cols[cc].name + '"/></div>');

                        dom.push('<div class="col-sm-4 clear"><select class="form-control input-sm tableColType" data-table-index="' + t + '" data-col-index="' + cc + '">');
                        for(var ty = 0; ty < this.TYPES.length; ty++) {
                            dom.push('<option' + (this.TYPES[ty] == table.cols[cc].type ? ' selected' : '') + '>' + this.TYPES[ty] + '</option>');
                        }
                        dom.push('</select></div>');

                        dom.push('<div class="col-sm-2 clear"><input type="text" data-table-index="' + t + '" data-col-index="' + cc + '" class="form-control input-sm tableColTypeSize" value="' + table.cols[cc].size + '"/></div>');

                        dom.push('</div></td>');
                    }
                    dom.push('</tr>')
                }

                for(var r = 0; r < table.rows.length; r++) {
                    var parent = parseInt(table.rowParents[r]);
                    dom.push('<tr data-table-index="' + t + '" data-row-index="' + r + '">');
                    dom.push('<td class="margin" style="position: absolute; margin-left: -' + (parent * 10) + 'px; width: ' + (parent * 10) + 'px; height: 35px; background: ' + this.PARENT_COLORS[parent] + ';"></td>');
                    dom.push('<td class="arrows"><button class="btn btn-default btn-xs increaseParentAction">&larr;</button><button class="btn btn-default btn-xs ' + (parent > 0 ? '' : 'disabled ') + 'decreaseParentAction">&rarr;</button></td>');
                    var row = table.rows[r];
                    for(var c = 0; c < row.length; c++) {
                        dom.push([
                            '<td>',
                            '<input type="text" data-row-index="' + r + '" data-col-index="' + c + '" class="form-control singleDataValue" value="' + row[c] + '"/>',
                            '</td>'
                        ].join(''));
                    }
                    dom.push('</tr>');
                }

                dom.push('</table>');
                dom.push('</div>');
            }

            dom.push('</div>');
            return dom.join('');
        }

    };

    var doctableData = [];
    $('.doctableData').each(function() {
        doctableData.push(
            new DocTableData($(this))
        );
    });


});