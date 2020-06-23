// @ts-nocheck

/* For sidebar remember previous state */
$.AdminLTESidebarTweak = {};

$.AdminLTESidebarTweak.options = {
    EnableRemember: true,
    NoTransitionAfterReload: true
    //Removes the transition after page reload.
};

$(function () {
    "use strict";

    $("body").on("collapsed.pushMenu", function () {
        if ($.AdminLTESidebarTweak.options.EnableRemember) {
            localStorage.setItem("toggleState", "closed");
        }
    });

    $("body").on("expanded.pushMenu", function () {
        if ($.AdminLTESidebarTweak.options.EnableRemember) {
            localStorage.setItem("toggleState", "opened");
        }
    });

    if ($.AdminLTESidebarTweak.options.EnableRemember) {
        var toggleState = localStorage.getItem("toggleState");
        if (toggleState == 'closed') {
            if ($.AdminLTESidebarTweak.options.NoTransitionAfterReload) {
                $("body").addClass('sidebar-collapse hold-transition').delay(100).queue(function () {
                    $(this).removeClass('hold-transition');
                });
            } else {
                $("body").addClass('sidebar-collapse');
            }
        }
    }
});

/* For select2 */
if ($.fn.modal != undefined) {
    $.fn.modal.Constructor.prototype.enforceFocus = function () { };
}


function formatErrorMessage(jqXHR, exception) {
    if (jqXHR.status === 0) {
        return ajax_errors.http_not_connected;
    } else if (jqXHR.status == 400) {
        return ajax_errors.request_forbidden;
    } else if (jqXHR.status == 404) {
        return ajax_errors.not_found_request;
    } else if (jqXHR.status == 500) {
        return ajax_errors.session_expire;
    } else if (jqXHR.status == 503) {
        return ajax_errors.service_unavailable;
    } else if (exception === 'parsererror') {
        return ajax_errors.parser_error;
    } else if (jqXHR.status == 419 || exception === 'timeout') {
        return ajax_errors.request_timeout;
    } else if (exception === 'abort') {
        return ajax_errors.request_abort;
    } else {
        var message = '';
        try {
            var r = jQuery.parseJSON(jqXHR.responseText);
            if (jQuery.isEmptyObject(r) == false) {
                $.each(r.errors, function (key, value) {
                    if (jQuery.isEmptyObject(r) != false) {
                        $.each(value, function (key, row) {
                            message += '<p>' + row + '</p>';
                        });
                    } else {
                        message += '<p>' + value + '</p>';
                    }
                });
            }
        } catch (e) {
            message = 'Uncaught Error.\n' + jqXHR.responseText;
        }
        return message;
    }
}

function formatErrorMessageFromJSON(jsonData) {
    var message = '';
    try {
        var r = jQuery.parseJSON(JSON.stringify(jsonData));

        if (jQuery.isEmptyObject(r) == false) {
            $.each(r, function (key, value) {
                if (jQuery.isEmptyObject(r) == false) {
                    $.each(value, function (key, row) {
                        message += '<p>' + row + '</p>';
                    });
                } else {
                    message += '<p>' + value + '</p>';
                }
            });
        }
    } catch (e) {
        message = 'Uncaught Error.\n' + jsonData;
    }
    return message;
}

function active_current_url() {
    let findAllLink = $('ul.sidebar-menu').find('a');
    if (findAllLink.length) {
        $.each(findAllLink, function (index, value) {
            let href = $(this).attr('href');
            if (current_url == href) {
                $(this).parent('li').addClass('active');
            }
        });
        let $this = $('ul.sidebar-menu').find('li.active');
        $this.parentsUntil(".sidebar-menu").addClass('open active');
    }
}
active_current_url();

function initBasicCkEditor() {
    CKEDITOR.config.toolbar = [
        ['Styles', 'Format', 'Font', 'FontSize', 'Bold', 'Italic', 'Underline', 'StrikeThrough', '-', 'Find', 'Replace', '-', 'Outdent', 'Indent'],
        ['NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
        ['Smiley', 'TextColor', 'BGColor', 'Source']
    ];
}

function reloadTable(table) {
    $(`#${table}`).DataTable().ajax.reload();
}

function initStarRating(read_only) {
    read_only = read_only !== undefined ? read_only : false;

    $('.rating-widget').starRating({
        initialRating: 5,
        strokeColor: '#894A00',
        strokeWidth: 5,
        starSize: 17,
        readOnly: read_only
    });
}

// For telInput Plugin
const dial_codes = {
    "358": "fi", "93": "af", "355": "al", "213": "dz", "1684": "as", "376": "ad", "244": "ao", "1264": "ai", "1268": "ag", "54": "ar", "374": "am", "297": "aw", "61": "cc", "43": "at", "994": "az", "1242": "bs", "973": "bh", "880": "bd", "1246": "bb", "375": "by", "32": "be", "501": "bz", "229": "bj", "1441": "bm", "975": "bt", "591": "bo", "387": "ba", "267": "bw", "55": "br", "246": "io", "1284": "vg", "673": "bn", "359": "bg", "226": "bf", "257": "bi", "855": "kh", "237": "cm", "1": "us", "238": "cv", "599": "cw", "1345": "ky", "236": "cf", "235": "td", "56": "cl", "86": "cn", "57": "co", "269": "km", "243": "cd", "242": "cg", "682": "ck", "506": "cr", "225": "ci", "385": "hr", "53": "cu", "357": "cy", "420": "cz", "45": "dk", "253": "dj", "1767": "dm", "593": "ec", "20": "eg", "503": "sv", "240": "gq", "291": "er", "372": "ee", "251": "et", "500": "fk", "298": "fo", "679": "fj", "33": "fr", "594": "gf", "689": "pf", "241": "ga", "220": "gm", "995": "ge", "49": "de", "233": "gh", "350": "gi", "30": "gr", "299": "gl", "1473": "gd", "590": "mf", "1671": "gu", "502": "gt", "44": "gb", "224": "gn", "245": "gw", "592": "gy", "509": "ht", "504": "hn", "852": "hk", "36": "hu", "354": "is", "91": "in", "62": "id", "98": "ir", "964": "iq", "353": "ie", "972": "il", "39": "va", "1876": "jm", "81": "jp", "962": "jo", "7": "ru", "254": "ke", "686": "ki", "383": "xk", "965": "kw", "996": "kg", "856": "la", "371": "lv", "961": "lb", "266": "ls", "231": "lr", "218": "ly", "423": "li", "370": "lt", "352": "lu", "853": "mo", "389": "mk", "261": "mg", "265": "mw", "60": "my", "960": "mv", "223": "ml", "356": "mt", "692": "mh", "596": "mq", "222": "mr", "230": "mu", "262": "re", "52": "mx", "691": "fm", "373": "md", "377": "mc", "976": "mn", "382": "me", "1664": "ms", "212": "eh", "258": "mz", "95": "mm", "264": "na", "674": "nr", "977": "np", "31": "nl", "687": "nc", "64": "nz", "505": "ni", "227": "ne", "234": "ng", "683": "nu", "672": "nf", "850": "kp", "1670": "mp", "47": "sj", "968": "om", "92": "pk", "680": "pw", "970": "ps", "507": "pa", "675": "pg", "595": "py", "51": "pe", "63": "ph", "48": "pl", "351": "pt", "974": "qa", "40": "ro", "250": "rw", "290": "sh", "1869": "kn", "1758": "lc", "508": "pm", "1784": "vc", "685": "ws", "378": "sm", "239": "st", "966": "sa", "221": "sn", "381": "rs", "248": "sc", "232": "sl", "65": "sg", "1721": "sx", "421": "sk", "386": "si", "677": "sb", "252": "so", "27": "za", "82": "kr", "211": "ss", "34": "es", "94": "lk", "249": "sd", "597": "sr", "268": "sz", "46": "se", "41": "ch", "963": "sy", "886": "tw", "992": "tj", "255": "tz", "66": "th", "670": "tl", "228": "tg", "690": "tk", "676": "to", "1868": "tt", "216": "tn", "90": "tr", "993": "tm", "1649": "tc", "688": "tv", "1340": "vi", "256": "ug", "380": "ua", "971": "ae", "598": "uy", "998": "uz", "678": "vu", "58": "ve", "84": "vn", "681": "wf", "967": "ye", "260": "zm", "263": "zw"
};

function getLatLong(address) {
    var location = { latitude: null, longitude: null };
    if (!$.trim(address)) return location;
    return new Promise((resolve, reject) => {
        var geocoder = new google.maps.Geocoder();

        geocoder.geocode({ address }, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                location.latitude = results[0].geometry.location.lat();
                location.longitude = results[0].geometry.location.lng();
            }
            resolve(location);
        });
    });
}

const formatDate = (date = null, format = 'YYYY-MM-DD hh:mm A') => moment(moment.utc(date).toDate()).local().format(format);

function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
    try {
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

        const negativeSign = amount < 0 ? "-" : "";

        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;

        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
    } catch (e) {
        console.log(e);
    }
};

// For Cropper.js
function dataURLtoMimeType(dataURL) {
    var BASE64_MARKER = ';base64,';
    var data;

    if (dataURL.indexOf(BASE64_MARKER) == -1) {
        var parts = dataURL.split(',');
        var contentType = parts[0].split(':')[1];
        data = decodeURIComponent(parts[1]);
    } else {
        var parts = dataURL.split(BASE64_MARKER);
        var contentType = parts[0].split(':')[1];
        var raw = window.atob(parts[1]);
        var rawLength = raw.length;

        data = new Uint8Array(rawLength);

        for (var i = 0; i < rawLength; ++i) {
            data[i] = raw.charCodeAt(i);
        }
    }

    var arr = data.subarray(0, 4);
    var header = "";
    for (var i = 0; i < arr.length; i++) {
        header += arr[i].toString(16);
    }
    switch (header) {
        case "89504e47":
            mimeType = "image/png";
            break;
        case "47494638":
            mimeType = "image/gif";
            break;
        case "ffd8ffe0":
        case "ffd8ffe1":
        case "ffd8ffe2":
            mimeType = "image/jpeg";
            break;
        default:
            mimeType = ""; // Or you can use the blob.type as fallback
            break;
    }

    return mimeType;
}

function initSelect2(target = '.select2-class') {
    $(target).select2({
        width: '100%',
        dir: current_lang == 'ar' ? 'rtl' : 'ltr',
    });
}

function initSelect2Custom(target = '.select2-class2') {
    $(target).select2({
        width: '100%',
        allowClear: true,
        dir: current_lang == 'ar' ? 'rtl' : 'ltr',
    });
}

String.prototype.trimToLength = function (m) {
    return (this.length > m)
        ? jQuery.trim(this).substring(0, m).split(" ").slice(0, -1).join(" ") + ".."
        : this;
};

$(document).ready(function (e) {
    if ($('.select2-class').length > 0) {
        initSelect2();
    }
    if ($('.select2-class2').length > 0) {
        initSelect2Custom();
    }

    if ($('.multiple-select').length > 0) {
        $('.multiple-select').multipleSelect({
            width: '100%',
        });
    }

    if ($('.date-picker').length > 0) {
        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });
    }

    if ($('.dob-picker').length > 0) {
        $('.dob-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            endDate: new Date()
        });
    }

    if ($('.timepicker-class').length > 0) { $('.timepicker-class').timepicker(); }

    if ($('.alpha-num-text').length > 0) {
        $('.alpha-num-text').keyup(function () {
            var yourInput = $(this).val();
            re = /[`~!@#$%^&*()_|+\-=?;'"<>\{\}\[\]\\\/]/gi;
            var isSplChar = re.test(yourInput);
            if (isSplChar) {
                var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;'"<>\{\}\[\]\\\/]/gi, '');
                $(this).val(no_spl_char);
            }
        });
    }

    $(".custom-positive-integer").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $(document).on('click', '.select2-check-all', function (e) {
        const select_box = $(this).data('select_box');

        if ($(this).is(':checked')) {
            $(`${select_box} > option`).prop("selected", "selected");
        } else {
            $(`${select_box} > option`).removeAttr("selected");
        }
        $(select_box).trigger("change");
    });
});
