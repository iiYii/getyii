/**
 * Created by Administrator on 2016/3/10.
 */
var emojis = ["plus1", "ok_hand", "joy", "clap", "smile", "smirk", "sleepy", "smiley", "heart", "kiss", "copyright", "coffee"];
var emojisList = $.map(emojis, function (value, i) {
    return {'id': i, 'name': value};
});
$(".field-md-input textarea").atwho({
    at: ':',
    displayTpl: "<li><img src='https://ruby-china-files.b0.upaiyun.com/assets/emojis/${name}.png' height='20' width='20'/> ${name} </li>",
    insertTpl: ":${name}:",
    data: emojisList
}).atwho({
    at: "@",
    data: "/at-users",
    //data: ["one", "two", "three"],
    limit: 6
}).atwho({
    at: "#",
    data: ["干货分享#", "心情#", "小贴士#"],
    limit: 6
});