window.addEventListener('load', function() {
    window.htmlEditor = CodeMirror.fromTextArea(document.getElementById("post-content"), {
        indentUnit: 4,
        lineNumbers: true,
        indentWithTabs: true,
        mode: 'htmlmixed'
    });
})