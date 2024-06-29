document.addEventListener('DOMContentLoaded', () => {
    const editor = document.getElementById('editor');
    const fontSelect = document.getElementById('fontSelect');
    const fontSize = document.getElementById('fontSize');
    const fontColor = document.getElementById('fontColor');

    function applyStyle(style, value) {
        document.execCommand(style, false, value);
    }

    function wrapSelectionWithSpan(style, value) {
        const span = document.createElement('span');
        span.style[style] = value;
        const selection = window.getSelection();
        if (!selection.rangeCount) return false;
        const range = selection.getRangeAt(0).cloneRange();
        range.surroundContents(span);
        selection.removeAllRanges();
        selection.addRange(range);
    }

    fontSelect.addEventListener('change', () => {
        applyStyle('fontName', fontSelect.value);
    });

    fontSize.addEventListener('input', () => {
        wrapSelectionWithSpan('fontSize', fontSize.value + 'px');
    });

    fontColor.addEventListener('input', () => {
        applyStyle('foreColor', fontColor.value);
    });
});
