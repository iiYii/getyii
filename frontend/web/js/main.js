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

});