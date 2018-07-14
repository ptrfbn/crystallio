var words = [];

var crystallizeTimeout;
var throttle = 500;

var crystallizer = function (rawText) {
    console.log('modified!');
    console.log(rawText);
}

var crystallizerThrottle = function (rawText) {
    if (!crystallizeTimeout) {
        crystallizeTimeout = setTimeout(function () {
            crystallizer(rawText);
            crystallizeTimeout = null;
        }, throttle);
    }
}

$(function () {
    $('#raw-text').on('DOMSubtreeModified', function () {
        var rawText = $(this).html();
        if (['.', '!', '?', ','].indexOf(rawText.slice(-1)) !== -1
            || ['&nbsp;'].indexOf(rawText.slice(-6)) !== -1) {
            crystallizer(rawText);
        } else {
            crystallizerThrottle(rawText);
        }
    });
});