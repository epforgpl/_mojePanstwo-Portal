$(document).ready(function () {
    $('.share').on('mouseup', function () {
        var t = false;

        if (window.getSelection) {
            t = window.getSelection();
        } else if (document.getSelection) {
            t = document.getSelection();
        } else if (document.selection) {
            t = document.selection.createRange().text;
        }

        console.log(t, t.getRangeAt(0));

        if (t && (t + '').length > 0) {
            if (t.getRangeAt) {
                var range = t.getRangeAt(0),
                    newNode = document.createElement("span");
                newNode.setAttribute('class', 'hide');
                range.insertNode(newNode);
                //range.surroundContents(newNode);
            } else {
                t.pasteHTML('<span class="hide">' + t.htmlText + '</span>');
            }
        }
    });
});