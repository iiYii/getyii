$('.insert-codes a').click(function (e) {
    e.preventDefault();
    var editor = ace.edit("markdown");
    var source = editor.getValue();
    var language = $(this).data('lang');
    var prefixBreak = source ? "\n" : '';
    var srcMerged = prefixBreak + "```" + language + "\n\n```\n";
    editor.insert(srcMerged);
    editor.gotoLine(editor.getCursorPosition().row -1);
});