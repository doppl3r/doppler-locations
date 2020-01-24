window.addEventListener('load', function() {
    var htmlEditor = CodeMirror.fromTextArea(document.getElementById("post-content"), {
        indentUnit: 4,
        lineNumbers: true,
        indentWithTabs: true,
        mode: 'htmlmixed'
    });
})