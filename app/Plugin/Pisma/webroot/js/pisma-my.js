(function() {

    var myPismaBrowser = {

        main: null,
        allCheckboxes: [],
        checked: [],

        setMain: function(main) {
            this.main = main;
            return this;
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

            return this;
        }

    };

    $(document).ready(function() {
        myPismaBrowser
            .setMain($('#myPismaBrowser'))
            .init();
    });


}());