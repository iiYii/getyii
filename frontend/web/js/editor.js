$('.insert-codes a').click(function(e){
    e.preventDefault();
    var language = $(this).data('lang');
    var editor = ace.edit("markdown");
    var srcMerged = "```"+language+"\n\n```\n"
    console.log(language);
    editor.setValue(srcMerged).caret(10);
});