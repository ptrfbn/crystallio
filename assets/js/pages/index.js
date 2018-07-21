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

    crystallizeWords();

}

function updateCrystalText() {
    var crystalText = $('#raw-text').html();

    for (word in words) {
        if (words[word].tested && words[word].hasOwnProperty('gender')) {
            var gender = words[word].gender;
            var span = '<span class="c-' + gender + '">' + word + '</span>';

            crystalText = crystalText.replace(new RegExp(word, 'g'), span);
        }
    }

    $('#crystallized-text').html(crystalText);
};

function crystallizeWords() {
    var wordsToTest = [];

    for (word in words) {
        if (!words[word].tested) {
            wordsToTest.push(word);
        }
    }

    window.dispatchEvent(onAjax);

    $.ajax({
        url: '/crystallize',
        method: 'post',
        data: {
            words: wordsToTest
        }
    }).done(function (res) {
        window.dispatchEvent(afterAjax);

        if (res.status === 'success') {
            wordsToTest.forEach(function (word) {
                words[word].tested = true;
                if (res.data.hasOwnProperty(word)) {
                    words[word].gender = res.data[word].gender;
                }
            });

            updateCrystalText();
        }
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