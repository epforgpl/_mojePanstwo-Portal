var intervalMain;

(function () {
    var myLines = [],
        svg = null,
        $lawMap = jQuery('#lawMap'),
        $lawMapNav = jQuery('.lawMapNav'),
        $lawMapNavLimit = 3,
        $svgLines = jQuery("#svgLines"),
        $svgPathMarker = $lawMap.find('.slide:first .path'),
        $svgLinesDiff = $svgPathMarker.offset().left - $lawMap.offset().left;

    $svgLines.css({
        'width': $svgPathMarker.width(),
        'height': '100%',
        'left': $svgLinesDiff
    });

    svg = Raphael("svgLines", $svgLines.width(), '100%');

    function drawLine(eTarget, eSource, color) {
        if (eTarget.is(':visible') && eSource.is(':visible')) {
            var $lawMapOffset = $lawMap.offset(),
                $sourceOffset = eSource.offset(),
                $targetOffset = eTarget.offset(),

                originX = -$svgLinesDiff + ($sourceOffset.left - $lawMapOffset.left) + (eSource.width() / 2) + 3,
                originY = ($sourceOffset.top - $lawMapOffset.top) + (eSource.height() / 2) - 3,

                endingX = -$svgLinesDiff + ($targetOffset.left - $lawMapOffset.left) + (eTarget.width() / 2) + 3,
                endingY = ($targetOffset.top - $lawMapOffset.top) + (eTarget.height() / 2) - 3,

                space = 35,

                path = "M" + originX + " " + (originY + 10) + " "
                    + "L" + originX + " " + originY + " " /*POINT AT TOP BORDER OF BOTTOM ICON*/
                    + "L" + endingX + " " + (originY - space) + " " /*POINT AT MIDDLE - X SAME AS TOP ICON*/
                    + "L" + endingX + " " + endingY, /*POINT AT BOTTOM BORDER OF TOP ICON*/

                rachaelLine = svg
                    .path(path)
                    .attr({
                        "stroke": color,
                        "stroke-width": 28
                    });

            if (!eSource.hasClass('active'))
                rachaelLine.toBack();

            myLines[myLines.length] = rachaelLine;
        }
    }

    function showLines() {
        var colors = {
            'inactive': '#E6E6E6',
            'lastActive': '#86BCE0',
            'lastNotActive': '#D4DEE2',
            'passActive': '#86BCE0',
            'passNotActive': '#D4DEE2'
        };

        setTimeout(function () {
            svg.clear();
            jQuery('.icon-small').each(function () {
                var $self = jQuery(this),
                    arrayParent = $self.data('parent');
                if (arrayParent !== undefined) {

                    for (var i = 0; i < arrayParent.length; i++) {
                        var color = ($self.parents('.slide').hasClass('inactive') ? colors.inactive
                            : ($self.parents('.slide').hasClass('active')) ?
                            ($self.hasClass('active') ? colors.lastActive
                                : colors.lastNotActive)
                            : ($self.hasClass('active') ? colors.passActive
                            : colors.passNotActive));

                        drawLine(jQuery('#node_' + arrayParent[i]), $self, color);

                    }
                }
            });
        }, Math.floor(Math.random() * 50));
    }

    function loadNodeDocument(params) {
        var container,
            parent = jQuery('.additionalInfo.doc-' + params.s);

        jQuery.ajax({
            type: "GET",
            url: "loadItemData.json",
            data: params,
            success: function (data) {
                if (data != null) {
                    if ((container = jQuery('.lawMap').find('.additionalInfo.addon.doc-' + params.s)).length) {
                        container.html('');
                        /*container reset*/
                        container.attr({'data-document': params.blockId, 'data-totalPage': data.pages});
                    } else {
                        container = jQuery('<div></div>').addClass('additionalInfo addon doc-' + params.s);
                        container.attr({
                            'data-slide': params.s,
                            'data-document': params.blockId,
                            'data-totalPage': data.pages
                        });
                        container.insertAfter(parent);
                        container.hide();
                    }

                    var pagination = jQuery('<ul></ul>'),
                        head = jQuery('<div></div>').addClass('head'),
                        docsLister = jQuery('<ul></ul>').addClass('docsLister');

                    if (params.blockId != 'undefined') {
                        var title = parent.find('.documentList a[data-number="' + params.blockId + '"]').data('title'),
                            docTitles = title.replace(/.{60}\S*\s+/g, "$&@").split(/\s+@/),
                            docTitle = docTitles[0];

                        if (docTitles.length > 1)
                            docListTitle += '...';

                        head.append(
                            jQuery('<div></div>').addClass('name').append(
                                jQuery('<h3></h3>').text(docTitle)
                            )
                        )
                    }

                    if (data.pages > 1) {
                        var paginationLeft,
                            paginationRight,
                            paginationLimit = 3;

                        paginationLeft = (params.currentPage - paginationLimit >= 1) ? paginationLimit : params.currentPage - 1;
                        paginationRight = (params.currentPage + paginationLimit <= data.pages) ? paginationLimit : data.pages - params.currentPage;

                        if (paginationLeft < paginationLimit)
                            (params.currentPage + paginationRight + (paginationLimit - paginationLeft) <= data.pages) ? paginationRight += (paginationLimit - paginationLeft) : paginationRight += data.pages - (params.currentPage + paginationRight);

                        if (paginationRight < paginationLimit)
                            (params.currentPage - paginationLeft - (paginationLimit - paginationRight) >= 1) ? paginationLeft += (paginationLimit - paginationRight) : paginationLeft += (params.currentPage - paginationLeft <= paginationLimit) ? ((params.currentPage - paginationLeft) - 1) : paginationLimit;

                        for (var i = 0; i <= (paginationLeft + paginationRight); i++) {
                            var liNode = jQuery('<li></li>').append(
                                jQuery('<a></a>').attr({
                                    'data-page': params.currentPage - (paginationLeft) + i,
                                    'href': "#"
                                }).text(params.currentPage - (paginationLeft) + i)
                            );
                            if ((params.currentPage - (paginationLeft) + i) == params.currentPage)
                                liNode.find('a').addClass('active');
                            pagination.append(liNode);
                        }

                        pagination.prepend(jQuery('<li></li>').append(jQuery('<a></a>').addClass('prev').attr('href', '#').text('<')));
                        pagination.append(jQuery('<li></li>').append(jQuery('<a></a>').addClass('next').attr('href', '#').text('>')));

                        head.append(pagination);

                        pagination.find('li a').click(function (e) {
                            var that = jQuery(this),
                                self = that.parents('.additionalInfo.addon'),
                                params,
                                page;
                            e.preventDefault();

                            if (that.hasClass('prev')) {
                                page = jQuery(this).parents('ul').find('.active').data('page') - 1;
                                page = (page < 1) ? 1 : page;
                            } else if (that.hasClass('next')) {
                                page = jQuery(this).parents('ul').find('.active').data('page') + 1;
                                page = (page > self.data('totalpage')) ? self.data('totalpage') : page;
                            } else {
                                page = jQuery(this).data('page');
                            }
                            params = {
                                's': self.parents('.slide').data('slide'),
                                'blockId': self.data('document'),
                                'currentPage': page,
                                'limitPerPage': 6,
                                'lang': mPHeart.language.threeDig
                            };

                            loadNodeDocument(params);
                        });
                    }

                    container.append(head);

                    jQuery(data.docs).each(function () {
                        var docsNode = jQuery('<li></li>');
                        docsNode.append(
                            jQuery('<a></a>').attr('href', '#').data('document', this.dokument_id).text(this.title).prepend(
                                jQuery('<img />').attr('src', 'http://docs.sejmometr.pl/thumb/2/' + this.dokument_id + '.png')
                            )
                        );

                        docsLister.append(docsNode);
                    });
                    container.append(docsLister);

                    container.find('.docsLister li a').click(function () {
                        var that = this,
                            docViewer = null,
                            docId = jQuery(this).data('document'),
                            intervalRunable = true;

                        jQuery.ajax({
                            type: "GET",
                            url: "/docs/" + docId + "-1.json",
                            success: function (data) {
                                if (data != null) {
                                    var mapaPrawa = jQuery('#mapaprawa');

                                    jQuery('head').append(
                                        jQuery('<link />').attr({
                                            'id': "imageViewCSS",
                                            'rel': "stylesheet",
                                            'href': 'http://docs.sejmometr.pl/htmlex/' + docId + '/' + docId + '.css',
                                            'type': "text/css"
                                        })
                                    );
                                    docViewer = jQuery('<div></div>').attr('id', 'docViewer').append(
                                        jQuery('<div></div>').addClass('container').append(
                                            jQuery('<div></div>').addClass('htmlexDoc').append(
                                                jQuery('<div></div>').addClass('headline')
                                            ).append(
                                                jQuery('<div></div>').addClass('descline')
                                            ).append(
                                                jQuery('<div></div>').addClass('documentTitle').append(
                                                    jQuery('<div></div>').addClass('row documentTitle').append(
                                                        jQuery('<div></div>').addClass('col-md-2 intro')
                                                    ).append(
                                                        jQuery('<div></div>').addClass('col-md-10 content info')
                                                    )
                                                )
                                            ).append(
                                                jQuery('<div></div>').addClass('docContent canvas').html(data.html)
                                            )
                                        )
                                    );

                                    docViewer.find('.headline').append(mapaPrawa.find('.container > .headline').clone(true));
                                    docViewer.find('.descline').append(mapaPrawa.find('.container > .descline').clone(true));
                                    docViewer.find('.documentTitle .intro').text(mPHeart.translation.LC_MAPAPRAWA_DOKUMENT)
                                        .end()
                                        .find('.documentTitle .content').text(jQuery(that).text());

                                    docViewer.find('.htmlexDoc').append(jQuery('<a></a>').addClass('close glyphicon glyphicon-remove-sign'));

                                    if (data.doc.packages_count > 1)
                                        docViewer.find('.htmlexDoc').append(jQuery('<div></div>').addClass('loadMoreDocumentContent').data({
                                            'currentPackage': 1,
                                            'packages': data.doc.packages_count
                                        }));

                                    mapaPrawa.append(docViewer);

                                    docViewer.find('.close').click(function (event) {
                                        event.preventDefault();

                                        jQuery('#imageViewCSS').remove();
                                        jQuery('#docViewer').remove();

                                        clearInterval(intervalMain);
                                    });

                                    if (jQuery('.loadMoreDocumentContent').length) {
                                        intervalMain = setInterval(function () {
                                            var loadMoreDocumentContent = jQuery('.loadMoreDocumentContent');

                                            if (isElementVisibled('.loadMoreDocumentContent') && intervalRunable) {
                                                if (loadMoreDocumentContent.data('currentPackage') < loadMoreDocumentContent.data('packages')) {
                                                    var page = Number(loadMoreDocumentContent.data('currentPackage')) + 1;

                                                    intervalRunable = false;
                                                    loadMoreDocumentContent.addClass('loading');
                                                    loadMoreDocumentContent.data('currentPackage', page);

                                                    jQuery.ajax({
                                                        type: "GET",
                                                        url: "/docs/" + docId + "-" + page + ".html",
                                                        success: function (html) {
                                                            docViewer.find('.docContent').append(html);
                                                            intervalRunable = true;
                                                        }
                                                    });
                                                } else if (loadMoreDocumentContent.data('currentPackage') == loadMoreDocumentContent.data('packages')) {
                                                    clearInterval(intervalMain);
                                                    loadMoreDocumentContent.remove();
                                                }
                                            }

                                        }, 1500);
                                    }
                                }
                            }
                        });
                    });

                    if (container.is(':hidden')) {
                        container.slideDown({
                            step: function (now, tween) {
                                if (tween.prop == 'height')
                                    showLines();
                            },
                            done: function () {
                                showLines();
                            }
                        });
                    }
                }
            }
        });
    }

    $lawMap.find('.slide').click(function () {
        var self = jQuery(this),
            slideId = self.data('slide'),
            params = {
                s: slideId,
                lang: mPHeart.language.threeDig
            },
            docContent = jQuery('<div></div>'),
            additionalInfo = jQuery('.additionalInfo.doc-' + slideId),
            additionalInfoAddon = jQuery('.additionalInfo.addon.doc-' + slideId);


        if ($(this).hasClass('open')) {
            self.removeClass('open');

            if (additionalInfoAddon.length > 0 && additionalInfoAddon.is(':visible')) {
                additionalInfoAddon.slideUp({
                    step: function (now, tween) {
                        if (tween.prop == 'height')
                            showLines();
                    },
                    done: function () {
                        additionalInfo.slideUp({
                            step: function (now, tween) {
                                if (tween.prop == 'height')
                                    showLines();
                            },
                            done: function () {
                                showLines();
                            }
                        })
                    }
                });
            } else {
                additionalInfo.slideUp({
                    step: function (now, tween) {
                        if (tween.prop == 'height')
                            showLines();
                    }, done: function () {
                        showLines();
                    }
                });
            }

            return;
        }

        self.addClass('open');

        if (additionalInfo.length == 0) {
            var docList = jQuery('<ul></ul>');

            jQuery.ajax({
                type: "GET",
                url: "loadBlockData.json",
                data: params,
                success: function (data) {
                    if (!data)
                        data = {'info': 'Etap', 'list': []};

                    docContent.addClass('additionalInfo doc-' + slideId);

                    if (self.hasClass('active'))
                        docContent.addClass('open-active');
                    else if (self.hasClass('inactive'))
                        docContent.addClass('open-inactive');

                    docContent.attr({
                        'data-slide': slideId
                    });
                    docContent.append(
                        jQuery('<div></div>').addClass('documentInfo').append(
                            jQuery('<h3></h3>').html("&nbsp;")
                        ).append(
                            jQuery('<p></p>').html(data.info)
                        )
                    ).append(function () {

                            if (data.list.length) {

                                var documentList = jQuery('<div></div>').addClass('documentList').addClass('documentation');
                                documentList.append(
                                    jQuery('<h3></h3>').text(mPHeart.translation.LC_MAPAPRAWA_DOKUMENTACJA)
                                ).append(function () {
                                        jQuery(data.list).each(function () {
                                            var docListTitles = this.tytul.replace(/.{48}\S*\s+/g, "$&@").split(/\s+@/),
                                                docListTitle = docListTitles[0];
                                            if (docListTitles.length > 1) docListTitle += '...';

                                            docList.append(jQuery('<li></li>').append(
                                                jQuery('<a></a>').attr({
                                                    'href': "#",
                                                    'data-number': this.id,
                                                    'data-title': this.tytul
                                                }).text(docListTitle)
                                            ))
                                        });
                                        documentList.append(docList);
                                    });
                                docContent.append(documentList)

                            }
                        });

                    docContent.insertAfter(self);
                    docContent.hide();

                    docContent.slideDown({
                        step: function (now, tween) {
                            if (tween.prop == 'height')
                                showLines();
                        },
                        done: function () {
                            showLines();
                        }
                    });

                    docList.find('li a').click(function (e) {
                        var that = jQuery(this),
                            list = that.parents('ul'),
                            parent = that.parents('.additionalInfo');
                        e.preventDefault();

                        list.find('.open').removeClass('open');
                        that.addClass('open');

                        loadNodeDocument({
                            's': parent.data('slide'),
                            'blockId': that.data('number'),
                            'currentPage': 1,
                            'limitPerPage': 6
                        });
                    })

                }
            });
        } else {
            additionalInfo.slideDown({
                step: function (now, tween) {
                    if (tween.prop == 'height')
                        showLines();
                }, done: function () {
                    showLines();
                    if (additionalInfoAddon.length > 0) {
                        additionalInfoAddon.slideDown({
                            step: function (now, tween) {
                                if (tween.prop == 'height')
                                    showLines();
                            },
                            done: function () {
                                showLines();
                            }
                        })
                    }
                }
            });
        }
    });

    if ($lawMap.find('.slide').length > $lawMapNavLimit) {
        var marker = ($lawMap.find('.slide.active:last').length > 0) ? $lawMap.find('.slide.active:last') : $lawMap.find('.slide:first'),
            lawMapNavTop = $lawMapNav.parent().find('> .top'),

            lawMapNavBottom = $lawMapNav.parent().find('> .bottom'),
            showLimit = 5;

        $lawMap.find('.slide').addClass('hide');

        /*SHOW 2 PREVIOUS*/
        marker.prevAll('.slide.hide').slice(0, 2).removeClass('hide');

        /*SHOW MARKED - AS CENTER ONE*/
        marker.removeClass('hide');

        /*SHOW 1 NEXT*/
        marker.next('.slide.hide').removeClass('hide');

        if (marker.prevAll('.slide.hide').length > 0)
            lawMapNavTop.removeClass('hide');
        if (marker.nextAll('.slide.hide').length > 0)
            lawMapNavBottom.removeClass('hide');

        $lawMapNav.click(function () {
            if ($lawMapNav.hasClass('top')) {
                var prevSlide = marker.prevAll('.slide.hide').slice(0, showLimit);

                prevSlide.removeClass('hide');

                if (marker.prevAll('.slide.hide').length == 0)
                    lawMapNavTop.addClass('hide');

            } else if ($lawMapNav.hasClass('bottom')) {
                var nextSlide = marker.nextAll('.slide.hide').slice(0, showLimit);

                nextSlide.removeClass('hide');

                if (marker.nextAll('.slide.hide').length == 0)
                    lawMapNavBottom.addClass('hide');
            }
            showLines();
        });

        showLines();
    } else {
        showLines();
    }
}());