/*global translation */

var filtersController = function () {
    var filters = jQuery('#filters'),
        limit = 5;


    // FIX HEIGHTS

    var dataFilters = jQuery('.objectsPageContent .dataBrowser .dataFilters');
    var innerContainer = jQuery('.objectsPageContent .dataBrowser .dataObjects .innerContainer');

    if (dataFilters.length && innerContainer.length) {

        innerContainer.css('min-height', dataFilters.height() - 103 + 'px');

    }


    /*RUN ONLY WHEN FILTER EXIST*/
    if (filters.length) {
        var showMoreFilters = jQuery('.showMoreFilters');

        if (showMoreFilters.length > 0)
            showMoreFilters.remove();


        filters.find('.filter').each(function () {
            var filter;

            /*HIDE OPTIONS OVER LIMIT*/
            if ((filter = jQuery(this).find('.options')).length) {
                var filterChecked = filter.find('li input:checked'),
                    filterNotChecked = filter.find('li input:not(:checked)');

                if ((limit - filterChecked.length) > 0) {
                    jQuery.each((filterNotChecked.slice(limit - filterChecked.length, filterNotChecked.length)), function () {
                        jQuery(this).parents('li.option').hide();
                    });
                }
            }

            /*GENERATE SHOW ALL OPTIONS BUTTON*/
            if ((filter.find('li:hidden')).length > 0) {
                var showMoreButton = jQuery('<span></span>')
                    .addClass('showMoreFilters btn btn-default btn-sm')
                    .attr({'data-toggle': 'modal', 'data-target': '#filtersHiddenModal'})
                    .text(mPHeart.translation.LC_DANE_SHOW_ALL_OPTIONS);

                filter.after(showMoreButton);
            }
        });

        /*CREATE MODAL DIALOG WITH ALL OPTIONS OF FILTER*/
        var filtersHiddenModal = jQuery('#filtersHiddenModal');
        if (filtersHiddenModal.length > 0)
            filtersHiddenModal.remove();

        filters.append(
            jQuery('<div></div>').addClass('modal fade').attr({
                'id': 'filtersHiddenModal',
                'tabindex': "-1",
                'role': "dialog",
                'aria-hidden': "true"
            }).append(
                jQuery('<div></div>').addClass('modal-dialog').append(
                    jQuery('<div></div>').addClass('modal-content').append(
                        jQuery('<div></div>').addClass('modal-header').append(
                            jQuery('<button></button>').addClass('close').attr({
                                'type': 'button',
                                'data-dismiss': 'modal',
                                'aria-hidden': 'true'
                            }).html('&times;')
                        ).append(
                            jQuery('<h4></h4>')
                        )
                    ).append(
                        jQuery('<div></div>').addClass('modal-body filter')
                    ).append(
                        jQuery('<div></div>').addClass('modal-footer').append(
                            jQuery('<div></div>').addClass('form-group filterModalSearch').css({
                                'width': '75%',
                                'float': 'left'
                            }).append(
                                jQuery('<input />').addClass('form-control').attr({
                                    'type': 'text',
                                    'placeholder': mPHeart.translation.LC_DANE_SEARCH,
                                    'autocomplete': 'off'
                                })
                            )
                        ).append(
                            jQuery('<button></button>').addClass('btn btn-primary').attr('type', 'submit').css({
                                'width': '20%',
                                'min-width': '60px',
                                'float': 'right'
                            }).text(mPHeart.translation.LC_DANE_FILTER)
                        )
                    )
                )
            )
        );

        filters.find('#filtersHiddenModal .filterModalSearch input').keyup(function () {
            filters.find('#filtersHiddenModal .modal-body li').each(function () {
                var labelName = jQuery(this).find('label').text();

                if (labelName.toLowerCase().indexOf(filters.find('#filtersHiddenModal .filterModalSearch input').val().toLowerCase()) >= 0) {
                    jQuery(this).removeClass('hidden');
                } else {
                    jQuery(this).addClass('hidden');
                }
            });
        });

        /*SHOW BUTTON - ON CLICK*/
        filters.find('.showMoreFilters').click(function (e) {
            var modalFilter = jQuery('#filtersHiddenModal'),
                filter = jQuery(e.target).parent();

            e.preventDefault();

            modalFilter.find('.modal-header h4').text(filter.find('.label_cont > label').text());
            modalFilter.find('.modal-body').html(filter.find('ul').clone());

            modalFilter.find('.modal-body li').each(function () {
                jQuery(this).find('input').attr('id', 'modal-' + jQuery(this).find('input').attr('id'));
                jQuery(this).find('label').attr('for', 'modal-' + jQuery(this).find('label').attr('for'));
            }).show();

            modalFilter.on('show.bs.modal', function () {
                modalFilter.find('.modal-body').css({'height': jQuery(window).height() * 0.7, 'overflow': 'auto'});
            });

            modalFilter.modal('show');
        });

        /*DATE FILTERS*/
        filters.find('.daysButton button').click(function () {
            var that = jQuery(this),
                parent = that.parents('.filter');

            if (!that.hasClass('disabled')) {
                if (that.hasClass('single')) {
                    parent.find('.daysButton .single').addClass('disabled');
                    parent.find('.daysButton .multi').removeClass('disabled');

                    parent.find('.daysSingle').removeClass('hide');
                    parent.find('.daysMulti').addClass('hide');
                } else if (that.hasClass('multi')) {
                    parent.find('.daysButton .single').removeClass('disabled');
                    parent.find('.daysButton .multi').addClass('disabled');

                    parent.find('.daysSingle').addClass('hide');
                    parent.find('.daysMulti').removeClass('hide');
                }
            }
        });

        filters.find('.changeable > .label_cont').click(function () {
            var $that = $(this).parent('.filter');

            if ($that.hasClass('inactive')) {
                $that.find(">div:not('.label_cont'), > ul, > span").show();
                $that.removeClass('inactive');
            } else {
                $that.find(">div:not('.label_cont'), > ul, > span").hide();
                $that.addClass('inactive');
            }
        });
    }
};

(function () {
    filtersController();
})();
