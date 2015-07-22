var highlighter;

window.onload = function () {
    var shareModal = $('#stepper .view');

    rangy.init();

    highlighter = rangy.createHighlighter();

    highlighter.addClassApplier(rangy.createClassApplier("anonim", {
        ignoreWhiteSpace: true,
        tagNames: ["span", "a"]
    }));

    shareModal.on('mouseup', function () {
        rangy.getSelection().expand("word");
    });

};

function highlightSelectedText() {
    highlighter.highlightSelection("anonim");
    unSelect();
}

function removeHighlightFromSelectedText() {
    highlighter.unhighlightSelection();
    unSelect();
}

function unSelect() {
    var t = false;

    if (window.getSelection) {
        t = window.getSelection();
    } else if (document.getSelection) {
        t = document.getSelection();
    } else if (document.selection) {
        t = document.selection.createRange().htmlText;
    }
    t.removeAllRanges();
}