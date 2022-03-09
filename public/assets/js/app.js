//
// App
// Helpers and other global stuff
//

//
// Escape html string
$.escape = function(html, nl2br) {
    var content = $('<div>').text(html).html()
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

    if (nl2br === true) content = $.nl2br(content);
    return content;
}

//
// Newline to <br>
$.nl2br = function(str, isXhtml) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (isXhtml || typeof isXhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

//
// Generic XHR error
$.xhrError = function(xhr, notify) {
    if (typeof notify === 'undefined') notify = true;

    var message = xhr.responseText;
    if (typeof xhr.responseJSON === 'object') {
        message = $.escape(xhr.responseJSON.message, true);
        if (xhr.responseJSON.debug) {
            message = message + `
                <div><small>` + $.escape(xhr.responseJSON.debug, true) + `</small></div>
            `;
        }
    }

    message = message || 'Something went wrong. Please try again in a bit or contact support.';
    if (notify) toastr.error(message, xhr.status + ' ' + xhr.statusText);

    return message;
}

$(function() {
    $.appUrl = $('meta[name="app-url"]').attr('content');
    $.ajaxUrl = $.appUrl + '/ajax';
})
