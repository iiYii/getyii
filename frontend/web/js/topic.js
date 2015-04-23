jQuery(function ($) {

    //赞, 踩, 收藏 等操作
    $(document).on('click', '[data-do]', function (e) {
        var _this = $(this),
            _id = _this.data('id'),
            _do = _this.data('do'),
            _type = _this.data('type');
        if (_this.is('a')) e.preventDefault();
        $.ajax({
            url: '/member/' + [_do, _type, _id].join('/'),
            success: function (result) {
                if (result.type != 'success') {
                    return alert(result.message);
                }
                //修改记数
                var num = _this.find('span'),
                    numValue = parseInt(num.html()),
                    active = _this.hasClass('active');
                _this.toggleClass('active');
                if (num.length) {
                    num.html(numValue + (active ? -1 : 1));
                }
                if ($.inArray(_do, ['like', 'hate']) >= 0) {
                    _this.siblings('[data-do=like],[data-do=hate]').each(function () {
                        var __this = $(this),
                            __do = __this.data('do'),
                            __id = __this.data('id'),
                            __active = __this.hasClass('active');
                        if (__id != _id) return; // 同一个话题或评论触发

                        __this.toggleClass('active', __do == _do);

                        var _num = __this.find('span')
                        _numValue = parseInt(_num.html());
                        if (_num.length) {
                            _num.html(_numValue + (__do != _do ? (_numValue > 0 && __active ? -1 : 0) : 1));
                        }
                    });
                }
            }
        });
    });
});