$(() => {
    $('.competence').each((_, element) => {
        $(element).click((event) => {
            if (!$(event.target).hasClass('selected')) {
                if ($('#query').val() == '') {
                    $('#query').val($('#query').val() + $(event.target).text());
                }
                else {
                    $('#query').val($('#query').val() + ', ' + $(event.target).text());
                }
            }
            else {
                $('#query').val($('#query').val().replace($(event.target).text(), ''));
                $('#query').val(trimWord($('#query').val(), ', '));
                $('#query').val($('#query').val().replace(' , ', ' '));
            }

            $(event.target).toggleClass('selected');
        });
    });
});
function hasSubstringAt(str, substr, pos) {
    var idx = 0, len = substr.length;

    for (var max = str.length; idx < len; ++idx) {
        if ((pos + idx) >= max || str[pos + idx] != substr[idx])
            break;
    }

    return idx === len;
}
function trimWord(str, word) {
    var start = 0,
        end = str.length,
        len = word.length;

    while (start < end && hasSubstringAt(str, word, start))
        start += word.length;

    while (end > start && hasSubstringAt(str, word, end - len))
        end -= word.length

    return (start > 0 || end < str.length) ? str.substring(start, end) : str;
}