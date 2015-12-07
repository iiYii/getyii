$('.insert-codes a').click(function (e) {
    e.preventDefault();
    var editor = ace.edit("markdown");
    var source = editor.getSession().getValue();
    var language = $(this).data('lang');
    var prefixBreak = source ? "\n" : '';
    var srcMerged = prefixBreak + "```" + language + "\n\n```\n";
    console.log(source);
    editor.getSession().setValue(source + srcMerged);
});