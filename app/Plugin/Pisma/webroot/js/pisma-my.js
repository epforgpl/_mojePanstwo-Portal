(function() {

    var myPismaBrowser = {

        main: null,
        allCheckboxes: [],
        baseUrl: '/pisma/moje',
        checked: [],
        query: {},

        setMain: function(main) {
            this.main = main;
            this.query = JSON.parse(this.main.attr('data-query'));
            return this;
        },

        createSelectAccessButton: function() {

            var t = this;
            var m = t.main;

            var accessButton = m.find('.selectAccessButton');
            var accessButtonData = JSON.parse(accessButton.attr('data-json'));

            var labels = {
                private: 'Prywatny',
                public: 'Publiczny',
                reset: 'Wszystkie'
            };

            var h = [
                '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">',
                'Dostęp',
                ' <span class="caret"></span>',
                '</button>'
            ];

            accessButtonData.buckets.push({
                key: 'reset',
                doc_count: false
            });

            if(!this.query.hasOwnProperty('access'))
                this.query['access'] = 'reset';

            if(accessButtonData.buckets.length > 0) {
                h.push('<ul class="dropdown-menu" role="menu">');

                for(var i in accessButtonData.buckets) {
                    if(!accessButtonData.buckets.hasOwnProperty(i))
                        continue;

                    var bucket = accessButtonData.buckets[i];
                    if(labels.hasOwnProperty(bucket.key))
                        bucket.label = labels[bucket.key];
                    else
                        bucket.label = bucket.key;

                    var active = false;
                    if(this.query.hasOwnProperty('access') && this.query['access'] == bucket.key)
                        active = true;

                    h.push('<li' + (active ? ' class="active"' : '') +'>');
                    h.push('<a href="#" class="setQueryParams" data-key="access" data-value="' + bucket.key + '">');

                    if(bucket.doc_count)
                        h.push('<span class="badge pull-right' + (active ? ' active' : '') + '">' + bucket.doc_count + '</span>');

                    h.push(bucket.label);
                    h.push('</a>');
                    h.push('</li>');
                }

                h.push('</ul>');
            }

            accessButton.html(
                h.join('')
            );

        },

        createActionBarButtons: function() {
            var t = this;
            var m = this.main;

            t.createSelectAccessButton();

            m.find('a.setQueryParams').each(function() {
                $(this).click(function() {
                    var key = $(this).attr('data-key');
                    var value = $(this).attr('data-value');
                    t.setQueryParams(key, value);
                    return false;
                });
            });
        },

        encodeQueryData: function(data) {
            return Object.keys(data).map(function(key) {
                return [key, data[key]].map(encodeURIComponent).join("=");
            }).join("&");
        },

        setQueryParams: function(key, value) {
            var q = this.query;
            if(value == 'reset') {
                if(q.hasOwnProperty(key))
                    delete q[key];
            } else
                q[key] = value;

            window.location = this.baseUrl + '?' + this.encodeQueryData(q);
        },

        updateCheckboxes: function() {
            this.main.find('input.itemCheckbox').each(function() {
                $(this).prop('checked', false);
                $(this).closest('.row').removeClass('selected');
            });

            for(var c in this.checked) {
                if(this.checked.hasOwnProperty(c)) {
                    var id = this.checked[c];
                    var row = this.main.find('.row[data-id="' + id +'"]');
                    var checkbox = row.find('input.itemCheckbox');
                    checkbox.prop('checked', true);
                    row.addClass('selected');
                }
            }

            this.main.find('input.checkAll')
                .prop('checked', this.checked.length ? true : false);

            this.updateActionBar();
            return this;
        },

        updateActionBar: function() {
            var actionBar = this.main.find('.actionbar');
            var desc = actionBar.find('.desc');
            var paginationList = desc.find('.paginationList');
            var selectedCount = desc.find('.selectedCount');
            var count = this.checked.length;
            var optionsChecked = actionBar.find('.optionsChecked');
            var optionsUnChecked = actionBar.find('.optionsUnChecked');

            var p = count == 1 ? 'pismo' : count < 5 ? 'pisma' : 'pism';

            if(count) {
                optionsChecked.show();
                optionsUnChecked.hide();
                paginationList.hide();
                selectedCount
                    .text('Zaznaczono ' + count + ' ' + p)
                    .show();
            } else {
                optionsChecked.hide();
                optionsUnChecked.show();
                paginationList.show();
                selectedCount.hide();
            }
        },

        toggleCheckboxes: function(checked) {
            if(checked)
                this.checked = this.allCheckboxes.slice();
            else
                this.checked.length = 0;

            this.updateCheckboxes();
            return this;
        },

        changeCheckbox: function(id, checked) {
            if(checked) {
                this.checked.push(id);
            } else {
                for(var c in this.checked) {
                    if(this.checked.hasOwnProperty(c))
                        if(this.checked[c] == id) {
                            this.checked.splice(c, 1);
                            break;
                        }
                }
            }

            this.updateCheckboxes();
            return this;
        },

        init: function() {

            var t = this;
            var m = t.main;

            var deleteButton = m.find('.deleteButton');

            deleteButton.click(function() {
                alert('Usuwanie');
            });

            m.find('input.checkAll')
                .attr('checked', false);

            m.find('input.itemCheckbox').each(function() {
                $(this).attr('checked', false);
                var id = $(this).closest('.row').attr('data-id');
                t.allCheckboxes.push(id);
            });

            m.find('input.checkAll')
                .change(function() {
                    var checked = $(this).is(':checked');
                    t.toggleCheckboxes(checked);
                });

            m.find('input.itemCheckbox')
                .change(function() {
                    var id = $(this).closest('.row').attr('data-id');
                    var checked = $(this).is(':checked');
                    t.changeCheckbox(id, checked);
                });

            t.createActionBarButtons();

            return this;
        }

    };

    $(document).ready(function() {
        myPismaBrowser
            .setMain($('#myPismaBrowser'))
            .init();
    });


}());