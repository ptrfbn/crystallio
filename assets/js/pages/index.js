var onAjax = new Event('onAjax');
var afterAjax = new Event('afterAjax');

window.addEventListener('onAjax', function () {
    $('.navbar .navbar-brand .logo').addClass('spin');
});

window.addEventListener('afterAjax', function () {
    $('.navbar .navbar-brand .logo').removeClass('spin');
});

var words = {};

var crystallizeTimeout;
var throttle = 500;

var splitterRE = /[A-ZÄÖÜẞ][A-Za-zÄÖÜẞäöüß]{1,50}/gm;

var crystallizer = function (rawText) {
    newWords = rawText.match(splitterRE);

    newWords.forEach(function (word) {
        if (!words.hasOwnProperty(word)) {
            words[word] = {
                noun: word,
                tested: false
            }
        }
    });

    CrystallizeWords();

}

function CrystallizeWords() {
    var wordsToTest = [];

    for (word in words) {
        if (!words[word].tested) {
            wordsToTest.push(word);
        }
    }

    $.ajax({
        url: '/crystallize',
        data: wordsToTest
    }).done(function () {
        console.log(data);
    });
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
            clearTimeout(crystallizeTimeout);
            crystallizeTimeout = null;
            crystallizer(rawText);
        } else {
            crystallizerThrottle(rawText);
        }
    });

});