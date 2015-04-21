jQuery(function ($) {

    //goto top
    $('.gototop').click(function (event) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: $("body").offset().top
        }, 500);
    });



    // 新窗口打开外链
    $('a[href^="http://"], a[href^="https://"]').each(function() {
       var a = new RegExp('/' + window.location.host + '/');
       if(!a.test(this.href) ) {
           $(this).click(function(event) {
               event.preventDefault();
               event.stopPropagation();
               window.open(this.href, '_blank');
           });
       }
    });

    // 加载代码高亮
    hljs.initHighlightingOnLoad();

    // Markdown 语法提示
    $("#md-input").focus(function(event) {
        $("#reply-notice").fadeIn(1500);
        // $("#preview-box").fadeIn(1500);
        // $("#preview-lable").fadeIn(1500);

        // if (!$("#md-input").val()) {
        //     $("html, body").animate({ scrollTop: $(document).height()}, 10);
        // }
    });

    /**
     * 监听键盘
     */
    $('#md-input').keyup(function () {
        runPreview();
    });

    /**
     * markdown预览
     */
    function runPreview() {
        var replyContent = $("#md-input");
        var oldContent = replyContent.val();
        if (oldContent) {

            marked(oldContent, function (err, content) {
                $('#md-preview').html(content);

                $('pre code').each(function (i, block) {
                    hljs.highlightBlock(block);
                });
                //emojify.run(document.getElementById('preview-box'));
            });
        }
    }

    $(document).on('click', '.btn-reply', function (e) {
        e.preventDefault();
        var username = $(this).data('username');
        var floor = $(this).data('floor');
        var replyContent = $("#md-input");
        var oldContent = replyContent.val();
        var prefix = "@" + username + " #" + floor + "楼 ";
        var newContent = ''
        if(oldContent.length > 0){
            if (oldContent != prefix) {
                newContent = oldContent + "\n" + prefix;
            }
        } else {
            newContent = prefix
        }
        replyContent.focus();
        replyContent.val(newContent);
        moveEnd($("#md-input"));
    });


    var moveEnd = function(obj){
        obj.focus();

        var len = obj.value === undefined ? 0 : obj.value.length;

        if (document.selection) {
            var sel = obj.createTextRange();
            sel.moveStart('character',len);
            sel.collapse();
            sel.select();
        } else if (typeof obj.selectionStart == 'number' && typeof obj.selectionEnd == 'number') {
            obj.selectionStart = obj.selectionEnd = len;
        }
    }
});