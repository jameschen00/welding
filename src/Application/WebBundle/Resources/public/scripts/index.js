var grayscaleImage = function (imgObj) {
    try {
        var canvas = document.createElement('canvas');
        var canvasContext = canvas.getContext('2d');
        var imgW = imgObj.width;
        var imgH = imgObj.height;
        canvas.width = imgW;
        canvas.height = imgH;
        canvasContext.drawImage(imgObj, 0, 0);
        var imgPixels = canvasContext.getImageData(0, 0, imgW, imgH);
        for (var y = 0; y < imgPixels.height; y++) {
            for (var x = 0; x < imgPixels.width; x++) {
                var i = (y * 4) * imgPixels.width + x * 4;
                var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
                imgPixels.data[i] = avg;
                imgPixels.data[i + 1] = avg;
                imgPixels.data[i + 2] = avg;
            }
        }
        canvasContext.putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);

        return canvas.toDataURL();
    } catch (e) {
        return null;
    }
}

var greyScale = function (el) {
    jQuery.each($(el), function () {
        if ($.browser.msie) {
            $(this).css('filter', 'progid:DXImageTransform.Microsoft.BasicImage(grayScale=1), alpha(opacity = 55)');
        } else {
            if ($(this).attr('src')) {
                var greySrc = grayscaleImage($(this).get(0));
                jQuery.data(this, 'color', $(this).attr('src'));
                jQuery.data(this, 'grey', greySrc);
                $(this).attr('src', greySrc);
                $(this).css({
                    'opacity': 0.55
                });
            }
        }
    });
    $(el).hover(function () {
        if ($(this).attr('src')) {
            if ($.browser.msie) {
                $(this).css('filter', 'alpha(opacity = 100)');
            } else {
                $(this).attr('src', jQuery.data(this, 'color'));
                $(this).css({
                    'opacity': 1
                });
            }
        }
    }, function () {
        if ($(this).attr('src')) {
            if ($.browser.msie) {
                $(this).css('filter', 'progid:DXImageTransform.Microsoft.BasicImage(grayScale=1), alpha(opacity = 55)');
            } else {
                $(this).attr('src', jQuery.data(this, 'grey'));
                $(this).css({
                    'opacity': 0.55
                });
            }
        }
    })
}

$(function () {
    greyScale($('.clients-list img'));
});