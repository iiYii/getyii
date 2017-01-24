jQuery(function ($) {

    function notificationsCount() {
        var notification = $('.notification-count');
        var originalTitle = document.title;
        if (notification.length > 0) {
            function scheduleGetNotification() {
                $.get(location.origin + '/notification/count', function (data) {
                    var nCount = parseInt(data)
                    if (nCount > 0) {
                        $('.notification-count a span').text(nCount);
                        $('.notification-count a').addClass('new');
                        document.title = '(' + nCount + ') ' + originalTitle;
                    } else {
                        document.title = originalTitle;
                        $('.notification-count a span').text('');
                        $('.notification-count a').removeClass('new');
                    }
                    setTimeout(scheduleGetNotification, 15000);
                });
            }

            setTimeout(scheduleGetNotification, 15000);
        }
    }

    notificationsCount();

    // 新窗口打开外链
    $('a[href^="http://"], a[href^="https://"]').each(function () {
        var a = new RegExp('/' + window.location.host + '/');
        if (!a.test(this.href)) {
            $(this).click(function (event) {
                event.preventDefault();
                event.stopPropagation();
                window.open(this.href, '_blank');
            });
        }
    });

    // 加载代码高亮
    hljs.initHighlightingOnLoad();

    emojify.setConfig({img_dir: 'https://ruby-china-files.b0.upaiyun.com/assets/emojis/'});
    emojify.run();

    function localStorage() {
        $("#md-input").focus(function (event) {
            // Topic Title ON Topic Creation View
            localforage.getItem('topic_title', function (err, value) {
                if ($('.topic-create #topic-title').val() == '' && !err) {
                    $('.topic-create #topic-title').val(value);
                }
            });
            $('.topic-create #topic-title').keyup(function () {
                localforage.setItem('topic_title', $(this).val());
            });

            // Topic Content ON Topic Creation View
            localforage.getItem('topic_create_content', function (err, value) {
                if ($('.topic-create #md-input').val() == '' && !err) {
                    $('.topic-create #md-input').val(value);
                    runPreview();
                }
            });
            $('.topic-create #md-input').keyup(function () {
                localforage.setItem('topic_create_content', $(this).val());
                runPreview();
            });

            // Reply Content ON Topic Detail View
            localforage.getItem('comment_content', function (err, value) {
                if ($('.topic-view #md-input').val() == '' && !err) {
                    $('.topic-view #md-input').val(value);
                    runPreview();
                }
            });
            $('.topic-view #md-input').keyup(function () {
                localforage.setItem('comment_content', $(this).val());
                runPreview();
            });

        });

        // Clear Local Storage on submit
        $('.topic-create button[type=submit]').click(function (event) {
            localforage.removeItem('topic_create_content');
            localforage.removeItem('topic_title');
        });
        $('.topic-view button[type=submit]').click(function (event) {
            localforage.removeItem('comment_content');
        });
    }

    localStorage();

    //add by ruzuojun
    $(document).on("click", "#goTop", function () {
        $('html,body').animate({scrollTop: '0px'}, 800);
    }).on("click", "#goBottom", function () {
        $('html,body').animate({scrollTop: $('.footer').offset().top}, 800);
    }).on("click", "#refresh", function () {
        location.reload();
    });

    //打赏显示和隐藏切换
    $("#donate-btn").click(function () {
        $('#donate-qr-code').toggle();
    });

    // 防止重复提交
    $('form').on('submit', function () {
        var $form = $(this),
            data = $form.data('yiiActiveForm');
        if (data) {
            // 如果是第一次 submit 并且 客户端验证有效，那么进行正常 submit 流程
            if (!$form.data('getyii.submitting') && data.validated) {
                $form.data('getyii.submitting', true);
                return true;
            } else { //  否则阻止提交
                return false;
            }
        }
    });
});
