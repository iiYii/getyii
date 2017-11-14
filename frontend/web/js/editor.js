// function insertString (merged, line) {
//     var editor = ace.edit("markdown");
//     editor.$blockScrolling = Infinity;
//     var source = editor.getValue();
//     var prefixBreak = source ? "\n" : '';
//     var srcMerged = prefixBreak + merged;
//     editor.insert(srcMerged);
//     editor.gotoLine(editor.getCursorPosition().row + line);
// }
//
// $('.insert-codes a').click(function (e) {
//     e.preventDefault();
//     var language = $(this).data('lang');
//     insertString("```" + language + "\n\n```\n", -1);
// });
// // var $editor = $('#md-input').dropzone({
// //     url: "https://sm.ms/api/upload",
// //     paramName: 'smfile',
// //     clickable: true,
// //     previewsContainer: '#dropzone-previewer',
// //     headers: { 'Cache-Control': null, 'X-Requested-With': null },
// //     success: function(file, response){
// //         if (response.code == 'success') {
// //             var img = response.data.url;
// //             insertString("![](" + img + ")\n", 1);
// //         } else {
// //             alert(response.msg);
// //         }
// //     }
// // });
//
// // $('#topic-upload-image').click(function(e){
// //     $editor.click();
// // })
//
