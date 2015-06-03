jQuery(function ($) {

    //goto top
    $('.gototop').click(function (event) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: $("body").offset().top
        }, 500);
    });

    // @ 用户
    function autocompleteAtUser() {
        var atUsers = [],
            user;
        $users = $('.media-heading').find('a.author');
        for (var i = 0; i < $users.length; i++) {
            user = $users.eq(i).text().trim();
            if ($.inArray(user, atUsers) == -1) {
                atUsers.push(user);
            }
            ;
        }
        ;

        $('#md-input').textcomplete([{
            mentions: atUsers,
            match: /\B@(\w*)$/,
            search: function (term, callback) {
                callback($.map(this.mentions, function (mention) {
                    return mention.indexOf(term) === 0 ? mention : null;
                }));
            },
            index: 1,
            replace: function (mention) {
                return '@' + mention + ' ';
            }
        }], {
            appendTo: 'body'
        });

    };
    autocompleteAtUser();

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
            };
            setTimeout(scheduleGetNotification, 15000);
        }
    };
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


    function editorPreview() {
        // Markdown 语法提示
        $("#md-input").focus(function (event) {
            $("#reply-notice").fadeIn(1500);
            // $("#preview-box").fadeIn(1500);
            // $("#preview-lable").fadeIn(1500);

            // if (!$("#md-input").val()) {
            //     $("html, body").animate({ scrollTop: $(document).height()}, 10);
            // }
        });
    };
    editorPreview();


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

            ///**
            // * 监听键盘
            // */
            //$('#md-input').keyup(function () {
            //    runPreview();
            //});
        });

        // Clear Local Storage on submit
        $('.topic-create button[type=submit]').click(function (event) {
            localforage.removeItem('topic_create_content');
            localforage.removeItem('topic_title');
        });
        $('.topic-view button[type=submit]').click(function (event) {
            localforage.removeItem('comment_content');
        });
    };
    localStorage();

    /**
     * markdown预览
     */
    function runPreview() {
        var replyContent = $("#md-input");
        var oldContent = replyContent.val();
        if (oldContent) {

            marked(oldContent, {
                sanitize: true,
            }, function (err, content) {
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
        if (oldContent.length > 0) {
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


    var moveEnd = function (obj) {
        obj.focus();

        var len = obj.value === undefined ? 0 : obj.value.length;

        if (document.selection) {
            var sel = obj.createTextRange();
            sel.moveStart('character', len);
            sel.collapse();
            sel.select();
        } else if (typeof obj.selectionStart == 'number' && typeof obj.selectionEnd == 'number') {
            obj.selectionStart = obj.selectionEnd = len;
        }
    }

    $('form').submit(function () {
        $(this).find("button[type='submit']").prop('disabled', true);
    });
});