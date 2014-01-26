(function ($) {
    $.fn.fadeShowreel = function (options) {
        var settings = $.extend({
            cont: this,
            item: $('.item', this),
            s: 4000,
            durata: 4000,
            n: '',
            animaTesto: false,
            show: {
                'opacity': 1
            },
            hide: {
                'opacity': 0
            },
            initImg: {
                'width': '105%'
            },
            endImg: {
                'width': '100%'
            },
            arrayImg: [
                [{
                    'width': '105%'
                }, {
                    'width': '105%'
                }],
                [{
                    'width': '105%'
                }, {
                    'width': '105%'
                }],
                [{
                    'width': '105%'
                }, {
                    'width': '105%'
                }],
                [{
                    'width': '105%'
                }, {
                    'width': '105%'
                }],
                [{
                    'width': '105%'
                }, {
                    'width': '105%'
                }]
            ],
            spImg: 3000,
            distTxt: 50,
            spTxt: 5000,
            spFade: 500,
            initTxt_x: [],
            fixedTxt_x: 650,
            fixedTxt_y: 30,
            txtAlign: 'right',
            mask: true
        }, options);
        return this.each(function () {
            var action;
            var i = 0;
            var loop = 0;
            var item = settings.item;
            settings.n = item.size();
            var first = item.eq(0);
            var last = item.eq(settings.n - 1);
            var curr;
            var prev;
            var interval;
            item.each(function (i, el) {
                var n = '' + $(el).find('p').attr('rel');
                var mt = n.match(/(\d+)\D+(\d+)/);
                var x = settings.fixedTxt_x;
                var y = settings.fixedTxt_y;
                var align = settings.txtAlign;
                if (mt) {
                    x = parseInt(mt[1], 10);
                    y = parseInt(mt[2], 10);
                }
                settings.initTxt_x.push(x);
                $(el).find('p').css({
                    'top': y + 'px',
                    align: x + 'px'
                });
                $(el).find('img').css(settings.arrayImg[i][0]);
                $(el).css('z-index', i + 1).find('p').css('top', $(el).find('p').attr('rel') + 'px');
            });
            settings.mask === true ? $(settings.cont).prepend('<div class="mask"></div>') : null;

            function action(t) {
                curr = item.eq(t);
                prev = item.eq(t - 1);
                endTxt = parseInt(settings.initTxt_x[i]) + settings.distTxt + 'px';
                if (i < settings.n) {
                    curr.find('img').animate(settings.arrayImg[loop][1], settings.spImg, 'linear');
                    curr.animate(settings.show, settings.spFade, 'linear', function () {
                        if (i > 0) {
                            prev.find('img').stop();
                            prev.find('p').stop();
                        }
                    });
                    if (settings.animaTesto === true) {
                        curr.find('p').animate({
                            'left': endTxt
                        }, settings.spTxt, 'linear');
                    }
                    i++;
                } else {
                    for (j = 0; j < settings.n - 1; j++) {
                        if (j === 0) {
                            item.eq(j).find('p').css('left', settings.initTxt_x[j] + 'px');
                            item.eq(j).find('img').css(settings.arrayImg[j][0]);
                        } else {
                            item.eq(j).css(settings.hide).find('p').css('left', settings.initTxt_x[j] + 'px');
                            item.eq(j).find('img').css(settings.arrayImg[j][0]);
                        }
                    }
                    last.animate(settings.hide, settings.spFade, 'linear', function () {
                        last.find('img').stop().css(settings.arrayImg[(settings.n - 1)][0]);
                        last.find('p').stop().css('left', settings.initTxt_x[(settings.n - 1)] + 'px');
                    });
                    endTxt = parseInt(settings.initTxt_x[0]) + settings.distTxt + 'px';
                    if (settings.animaTesto === true) {
                        first.find('p').animate({
                            'left': endTxt
                        }, settings.spTxt, 'linear');
                    }
                    first.find('img').animate(settings.arrayImg[0][1], settings.spImg, 'linear');
                    i = 1;
                }
                if (loop < settings.n - 1) {
                    loop = loop + 1;
                } else {
                    loop = 0;
                }
                interval = setTimeout(function () {
                    action(i)
                }, settings.durata);
            };
            settings.cont.css('visibility', 'visible');
            settings.n > 1 ? action(i) : settings.item.css(settings.show);
        });
    };
})(jQuery);