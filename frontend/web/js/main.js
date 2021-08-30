jQuery(function ($) {
  function notificationsCount() {
    var notification = $(".notification-count");
    var originalTitle = document.title;
    if (notification.length > 0) {
      function scheduleGetNotification() {
        $.get(location.origin + "/notification/count", function (data) {
          var nCount = parseInt(data);
          if (nCount > 0) {
            $(".notification-count a span").text(nCount);
            $(".notification-count a").addClass("new");
            document.title = "(" + nCount + ") " + originalTitle;
          } else {
            document.title = originalTitle;
            $(".notification-count a span").text("");
            $(".notification-count a").removeClass("new");
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
    var a = new RegExp("/" + window.location.host + "/");
    if (!a.test(this.href)) {
      $(this).click(function (event) {
        event.preventDefault();
        event.stopPropagation();
        window.open(this.href, "_blank");
      });
    }
  });

  // 加载代码高亮
  hljs.initHighlightingOnLoad();

  emojify.setConfig({
    img_dir: "https://cdn.learnku.com/assets/images/emoji/",
  });
  emojify.run();

  function localStorage() {
    $("#md-input").focus(function (event) {
      // Topic Title ON Topic Creation View
      localforage.getItem("topic_title", function (err, value) {
        if ($(".topic-create #topic-title").val() == "" && !err) {
          $(".topic-create #topic-title").val(value);
        }
      });
      $(".topic-create #topic-title").keyup(function () {
        localforage.setItem("topic_title", $(this).val());
      });

      // Topic Content ON Topic Creation View
      localforage.getItem("topic_create_content", function (err, value) {
        if ($(".topic-create #md-input").val() == "" && !err) {
          $(".topic-create #md-input").val(value);
          runPreview();
        }
      });
      $(".topic-create #md-input").keyup(function () {
        localforage.setItem("topic_create_content", $(this).val());
        runPreview();
      });

      // Reply Content ON Topic Detail View
      localforage.getItem("comment_content", function (err, value) {
        if ($(".topic-view #md-input").val() == "" && !err) {
          $(".topic-view #md-input").val(value);
          runPreview();
        }
      });
      $(".topic-view #md-input").keyup(function () {
        localforage.setItem("comment_content", $(this).val());
        runPreview();
      });
    });

    // Clear Local Storage on submit
    $(".topic-create button[type=submit]").click(function (event) {
      localforage.removeItem("topic_create_content");
      localforage.removeItem("topic_title");
    });
    $(".topic-view button[type=submit]").click(function (event) {
      localforage.removeItem("comment_content");
    });
  }

  localStorage();

  //add by ruzuojun
  $(document)
    .on("click", "#goTop", function () {
      $("html,body").animate({ scrollTop: "0px" }, 800);
    })
    .on("click", "#goBottom", function () {
      $("html,body").animate({ scrollTop: $(".footer").offset().top }, 800);
    })
    .on("click", "#refresh", function () {
      location.reload();
    });

  //打赏显示和隐藏切换
  $("#donate-btn").click(function () {
    $("#donate-qr-code").toggle();
  });

  // 防止重复提交
  $("form").on("submit", function () {
    var $form = $(this),
      data = $form.data("yiiActiveForm");
    if (data) {
      // 如果是第一次 submit 并且 客户端验证有效，那么进行正常 submit 流程
      if (!$form.data("getyii.submitting") && data.validated) {
        $form.data("getyii.submitting", true);
        return true;
      } else {
        //  否则阻止提交
        return false;
      }
    }
  });

  // function called if wwads is blocked
  function ABDetected() {
    var adBlockDetected_div = document.createElement("div");
    adBlockDetected_div.style.cssText =
      "position: absolute; top: 0; left: 0; width: 100%; background: #fc6600; color: #fff; z-index: 9999999999; font-size: 14px; text-align: center; line-height: 1.5; font-weight: bold; padding-top: 6px; padding-bottom: 6px;";
    adBlockDetected_div.innerHTML =
      "我们的广告服务商 <a style='color:#fff;text-decoration:underline' target='_blank' href='https://wwads.cn/page/end-user-privacy'>并不跟踪您的隐私</a>，为了支持本站的长期运营，请将我们的网站 <a style='color: #fff;text-decoration:underline' target='_blank' href='https://wwads.cn/page/whitelist-wwads'>加入广告拦截器的白名单</a>。";
    document.getElementsByTagName("body")[0].appendChild(adBlockDetected_div);
    // add a close button to the right side of the div
    var adBlockDetected_close = document.createElement("div");
    adBlockDetected_close.style.cssText =
      "position: absolute; top: 0; right: 10px; width: 30px; height: 30px; background: #fc6600; color: #fff; z-index: 9999999999; line-height: 30px; cursor: pointer;";
    adBlockDetected_close.innerHTML = "×";
    adBlockDetected_div.appendChild(adBlockDetected_close);
    // add a click event to the close button
    adBlockDetected_close.onclick = function () {
      this.parentNode.parentNode.removeChild(this.parentNode);
    };
  }

  function docReady(t) {
    "complete" === document.readyState || "interactive" === document.readyState
      ? setTimeout(t, 1)
      : document.addEventListener("DOMContentLoaded", t);
  }

  //check if wwads' fire function was blocked after document is ready with 3s timeout (waiting the ad loading)
  docReady(function () {
    setTimeout(function () {
      if (window._AdBlockInit === undefined) {
        ABDetected();
      }
    }, 3000);
  });
});
