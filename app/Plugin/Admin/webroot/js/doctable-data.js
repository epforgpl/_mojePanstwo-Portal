
$(document).ready(function() {

    var DocTableData = function($$) {
        this.$$ = $$;
        this.tableData = this.$$.data('table-data');
        this.tables = this.tableDataToTables(this.tableData);
        this.doc = this.tableData['doctable_data'][0]['doctable_data'];
        this.$preview = this.$$.find('.preview').first();
        this.$toolbar = this.$$.find('.toolbar').first();

        var self = this;

        self.refresh();

        self.$preview.on('change', 'input.singleDataValue', function() {
            self.tables
                [$(this).data('tableIndex')]
                ['rows']
                [$(this).data('rowIndex')]
                [$(this).data('colIndex')] = $(this).val();
        });

        self.$preview.on('click', 'button.margeTablesUp', function() {
            var tableToIndex = $(this).data('tableIndex');

            if(tableToIndex > 0) {
                if(self.tables.hasOwnProperty(tableToIndex - 1)) {
                    self.mergeTables(tableToIndex - 1, tableToIndex);
                    self.refresh();
                }
            }
        });

        self.$preview.on('click', 'button.mergeTableAction', function() {
            var tableToIndex = $(this).data('tableIndex'),
                select = $('select[data-table-index="' + tableToIndex + '"]').first(),
                tableFromIndex = select.find(':selected').data('tableIndex');

            self.mergeTables(tableToIndex, tableFromIndex);
            self.refresh();
        });

        self.$preview.on('click', 'button.decreaseParentAction', function() {
            var row = $(this).closest('tr').first().data();
            self.tables[row['tableIndex']]['rowParents'][row['rowIndex']]--;
            self.refresh();
        });

        self.$preview.on('click', 'button.increaseParentAction', function() {
            var row = $(this).closest('tr').first().data();
            self.tables[row['tableIndex']]['rowParents'][row['rowIndex']]++;
            self.refresh();
        });

        self.$preview.on('click', 'button.useDict', function() {
            var selfButton = $(this);
            var tableIndex = $(this).data('tableIndex');
            selfButton.text('Pobieranie..');
            $.get('/admin/docs/getDict', function(res) {
                selfButton.text('Zamiana...').change();
                for(var r = 0; r < res.length; r++) {
                    var from = res[r]['doctable_dict']['from'];
                    var to = res[r]['doctable_dict']['to'];
                    for(var rr = 0; rr < self.tables[tableIndex].rows.length; rr++) {
                        for(var v = 0; v < self.tables[tableIndex].rows[rr].length; v++) {
                            var type = self.tables[tableIndex].cols[v].type;
                            var value = self.tables[tableIndex].rows[rr][v];
                            if(['VARCHAR','CHAR','TEXT'].indexOf(type) !== -1)
                            {
                                var lowerValue = value.toLowerCase(),
                                    pos = lowerValue.search(from.toLowerCase());

                                if(pos !== -1) {
                                    var vvv = value.substring(pos, from.length);
                                    if(vvv.toUpperCase() == vvv) {
                                        to = to.toUpperCase();
                                    } else if(vvv.toLowerCase() == vvv) {
                                        to = to.toLowerCase();
                                    } else if(vvv.charAt(0).toUpperCase() == vvv.charAt(0) && vvv.charAt(1).toLowerCase() == vvv.charAt(1)) {
                                        to = to.charAt(0).toUpperCase() + to.slice(1);
                                    }
                                    self.tables[tableIndex].rows[rr][v] = value.substring(0, pos) + to + value.substring(pos + from.length, value.length);
                                }
                            } else if(type == 'FLOAT') {

                                if(
                                    value.indexOf(',') !== -1 &&
                                    value.split(',').length - 1 == 1 &&
                                    value.indexOf('.') == -1)
                                {
                                    value = value.replace(',', '.');
                                } else if(
                                    value.indexOf(',') !== -1 &&
                                    value.indexOf('.') !== -1 &&
                                    value.split(',').length - 1 == 1 &&
                                    value.split('.').length - 1 == 1
                                )
                                {
                                    var dotPos = value.indexOf('.'),
                                        comPos = value.indexOf(',');
                                    if(dotPos > comPos) {
                                        value = value.replace(',', '');
                                    } else {
                                        value = value.replace('.', '');
                                        value = value.replace(',', '.');
                                    }
                                }

                                value = value.replace(' ', '');
                                if(value == '')
                                    value = '0';
                                self.tables[tableIndex].rows[rr][v] = value;
                            }
                        }
                    }
                }

                self.refresh();
            }, 'json');
        });

        self.$preview.on('change', 'input.tableName', function() {
            var tableIndex = $(this).data('tableIndex');
            self.tables[tableIndex].dbName = $(this).val();
            self.refresh();
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
            self.refresh();
        });

        self.$preview.on('change', 'select.tableColType', function() {
            var tableIndex = $(this).data('tableIndex'),
                colIndex = $(this).data('colIndex');
            self.tables[tableIndex].cols[colIndex].type = $(this).find(':selected').first().html();
            self.refresh();
        });

        this.$toolbar.find('.exportSQL').click(function() {
            var sql = self.getTablesAsSQL();
            var a = document.getElementById('forceDownloadFile');
            a.setAttribute('href', 'data:application/octet-stream;charset=utf-8,' + encodeURIComponent(sql));
            a.setAttribute('download', self.doc['document_id'] + ' - ' + self.doc['name'] + '.sql');
            a.click();
            return false;
        });

        this.$toolbar.find('.exportMySQL').click(function() {
            var sql = self.getTablesAsSQL();
            $.post('/admin/docs/exportMySQL', {
                sql: sql.replace(/(\r\n|\n|\r|\t)/gm, '')
            }, function(res) {
                if(res == true) {
                    alert('Dane zostały poprawnie dodane do MySQL');
                } else {
                    alert('Wystąpił błąd');
                }
            }, 'json');
            return false;
        });

    };

    DocTableData.prototype = {

        constructor: DocTableData,

        refresh: function() {
            this.$preview.html(this.getTablesDOM());

            /* this.$preview.find('table').each(function() {
                $(this).colResizable();
            }); */
        },

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

        prepareValue: function(val, type) {
            switch(type)
            {
                case 'VARCHAR':
                    val = '"' + val.trim() + '"';
                break;

                case 'CHAR':
                    val = '"' + val.trim() + '"';
                break;

                case 'TEXT':
                    val = '"' + val.trim() + '"';
                break;

                case 'INT':
                    if(val.charAt(0) == '-') {
                        val = parseInt(val.replace(/[^\/\d]/g, '') || 0);
                        val = -val;
                    } else {
                        val = parseInt(val.replace(/[^\/\d]/g, '') || 0);
                    }
                break;

                case 'BIGINT':
                    if(val.charAt(0) == '-') {
                        val = parseInt(val.replace(/[^\/\d]/g, '') || 0);
                        val = -val;
                    } else {
                        val = parseInt(val.replace(/[^\/\d]/g, '') || 0);
                    }
                break;

                case 'FLOAT':
                    if(val == '')
                        val = 0.0;
                break;

                default: break;
            }

            return val;
        },

        getTablesAsSQL: function() {
            var s = ['/* SQL */\n'];

            for(var t = 0; t < this.tables.length; t++) {
                var table = this.tables[t];
                s.push('CREATE TABLE IF NOT EXISTS `docd_' + table.dbName + '` (');
                s.push('\t`id` INT(11) UNSIGNED AUTO_INCREMENT,');
                s.push('\t`parent_id` INT(11) UNSIGNED DEFAULT 0,');

                for(var c = 0; c < table.cols.length; c++) {
                    var col = table.cols[c];
                    s.push('\t`' + col.name + '` ' + col.type + '(' + col.size + '),');
                }

                s.push('\tPRIMARY KEY (`id`)');
                s.push(');\n');


                s.push('INSERT INTO `docd_' + table.dbName + '` (');
                s.push('\t`id`,');
                s.push('\t`parent_id`,');
                for(c = 0; c < table.cols.length; c++) {
                    col = table.cols[c];
                    s.push('\t`' + col.name + '`' + (c + 1 == table.cols.length ? '': ','));
                }
                s.push(') VALUES');

                for(var r = 0; r < table.rows.length; r++) {
                    var row = table.rows[r];
                    var parent_id = 0;

                    if(r > 0 && table.rowParents[r] > 0)
                    {
                        var rr = r;
                        do {
                            rr--;
                        } while(table.rowParents[r] - 1 != table.rowParents[rr]);
                        parent_id = rr + 1;
                    }

                    s.push('(');
                    s.push('\t"",');
                    s.push('\t' + parent_id + ',');
                    for(var v = 0; v < row.length; v++) {
                        var type = table.cols[v].type;
                        var value = this.prepareValue(row[v], type);
                        s.push('\t' + value + (v + 1 == row.length ? '' : ','));
                    }
                    s.push(')' + (r + 1 == table.rows.length ? ';' : ','));
                }
                s.push('');
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

                    var docTable = tableData['doctable_data_tables'][t];
                    if(parseInt(docTable[0]['values_count']) == 0)
                        continue;

                    var values = docTable[0]['values'].split('[{~}]'),
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
            var dom = ['<div class="container">'];
            dom.push('<h2 class="text-muted">' + this.doc['name'] + ' <small>' + this.doc['created_at'] +'</small></h2>');
            dom.push('<a target="_blank" href="/admin/docs/tables/' + this.doc['document_id'] +'">Dokument źródłowy</a>');

            for(var t = 0; t < this.tables.length; t++) {
                var table = this.tables[t];
                dom.push('<div style="margin-top: 15px;" class="panel panel-default">');
                dom.push('<div class="panel-heading"><div class="clear row"><div class="clear col-sm-10"><input class="form-control tableName" data-table-index="' + t + '" type="text" placeholder="Nazwa" value="' + table.dbName + '"></div><div class="clear col-sm-1"><button data-table-index="' + t + '" class="btn btn-default btn-block useDict">Popraw</button></div><div class="clear col-sm-1"><button data-table-index="' + t + '" class="btn btn-default btn-block margeTablesUp">&uarr;</button>');
                dom.push('</div></div></div>');


                dom.push('<table data-table-index="' + t + '" class="table table-bordered">');

                if(table.rows.length > 0) {
                    dom.push('<tr class="types">');
                    dom.push('<td></td><td></td>');
                    for(var cc = 0; cc < table.cols.length; cc++) {
                        dom.push('<td><div class="row clear">');

                        dom.push('<div class="col-sm-12 clear"><input type="text" data-table-index="' + t + '" data-col-index="' + cc + '" class="form-control input-sm tableColName" value="' + table.cols[cc].name + '"/></div></div><div class="row clear">');

                        dom.push('<div class="col-sm-8 clear"><select class="form-control input-sm tableColType" data-table-index="' + t + '" data-col-index="' + cc + '">');
                        for(var ty = 0; ty < this.TYPES.length; ty++) {
                            dom.push('<option' + (this.TYPES[ty] == table.cols[cc].type ? ' selected' : '') + '>' + this.TYPES[ty] + '</option>');
                        }
                        dom.push('</select></div>');

                        dom.push('<div class="col-sm-4 clear"><input type="text" data-table-index="' + t + '" data-col-index="' + cc + '" class="form-control input-sm tableColTypeSize" value="' + table.cols[cc].size + '"/></div>');

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
                            '<input type="text" data-table-index="' + t + '" data-row-index="' + r + '" data-col-index="' + c + '" class="form-control singleDataValue" value="' + row[c] + '"/>',
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