jQuery(function ($) {

    //#main-slider
    $(function () {
        $('#main-slider.carousel').carousel({
            interval: 8000
        });
    });

    $('.centered').each(function (e) {
        $(this).css('margin-top', ($('#main-slider').height() - $(this).height()) / 2);
    });

    $(window).resize(function () {
        $('.centered').each(function (e) {
            $(this).css('margin-top', ($('#main-slider').height() - $(this).height()) / 2);
        });
    });

    //portfolio
    $(window).load(function () {
        $portfolio_selectors = $('.portfolio-filter >li>a');
        if ($portfolio_selectors != 'undefined') {
            $portfolio = $('.portfolio-items');
            $portfolio.isotope({
                itemSelector: 'li',
                layoutMode: 'fitRows'
            });
            $portfolio_selectors.on('click', function () {
                $portfolio_selectors.removeClass('active');
                $(this).addClass('active');
                var selector = $(this).attr('data-filter');
                $portfolio.isotope({filter: selector});
                return false;
            });
        }
    });

    //contact form
    var form = $('.contact-form');
    form.submit(function () {
        $this = $(this);
        $.post($(this).attr('action'), function (data) {
            $this.prev().text(data.message).fadeIn().delay(3000).fadeOut();
        }, 'json');
        return false;
    });

    //goto top
    $('.gototop').click(function (event) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: $("body").offset().top
        }, 500);
    });

    //Pretty Photo
    $("a[rel^='prettyPhoto']").prettyPhoto({
        social_tools: false
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