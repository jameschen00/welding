var order = {

};

/**
 * Cart
 */
order.cart = {
    queryUrl    : '/cart',
    ct          : null,
    delivery_ct : null,

    /**
     * Попап корзины
     */
    show : function(product_id) {
        var self = this;

        if (product_id) {
            $.ajax({
                type : 'post',
                url  : self.queryUrl + '/add/'+product_id,
                dataType : 'json',
                success : function(json) {
                    core.popup.show('popup-cart', self.queryUrl, {modal : true});
                    core.unblock();
                }
            });
        }  else {
            core.popup.show('popup-cart', self.queryUrl, {modal : true});
        }
    },

    /**
     * Инициализация
     */
    init : function() {
        this.ct = $('#cart');
        this.delivery_ct = $('[data-role="cart-delivery-block"]');

        var self = this;
        var selects = self.delivery_ct.find('select');
        selects.bind('change', function(){
            $(selects).find(':gt('+selects.index($(this))+')').attr('disabled', 'disabled').val(0);
            $(selects).find(':eq('+(selects.index($(this))+1)+')').removeAttr('disabled');
            self.calculate();
        });

        //для доставки на склад курьерской службы "Новая Почта" отображаем точку выдачи, иначе - адрес доставки
        self.delivery_ct.find('select[name="whs_id"]').parents('.control-group').hide();
        self.delivery_ct.find('select[name="dservice_id"]').bind('change', function() {
            if ($(this).val() == 9) {
                $('input[name="address_delivery"]').parents('.control-group').hide();
                $('select[name="whs_id"]').parents('.control-group').show();
            } else {
                $('input[name="address_delivery"]').parents('.control-group').show();
                $('select[name="whs_id"]').parents('.control-group').hide();
            }
        });
    },

    /**
     * Пересчет корзины
     */
    calculate : function() {
        var self = this;

        var params = {};
        params['dservice_id'] = $('#dservice_id').val();
        params['credit_id'] = $('select[name="credit_id"]').val();

        $(this.delivery_ct).find('select').each(function(){
            params[$(this).attr('name')] = $(this).val();
        });

        self.query('calculate', params, function(json) {
            self.updateInfo(json);
        }, 0);
    },

    /**
     * Пересчет стоимости товара в заказе
     */
    count : function(input, config) {
        var self = this;

        var product_id = parseInt($(input).attr('id').replace('count-',''));
        core.timeout('count',function(){
            var val = $(input).val(),
                count = val > 0 ? (val <= 9999 ? val : 9999) : 1;
            $(input).val(count);

            //запрос на сервер
            self.query('change', $.extend({product_id : product_id, count : count}, config || {}), function(json) {
                $(input).val(json.count);

                //пересчет
                self.calculate();
            }, 0);
        }, 300);
    },

    /**
     * Удаление товара с корзины
     * @param Integer product_id
     */
    remove : function(product_id, config) {
        var self = this;

        self.query('delete', $.extend({id : product_id},config || {}), function(json) {
            var tr = $('[data-role="product-'+product_id+'"]');
            tr.animate({opacity:0}, 250, function() {
                tr.remove();
                if (json.count == 0) {
                    $('#popup-cart').remove();
                }
                self.calculate();
            });
        }, 0);
    },

    /**
     * Обновление общей инфы по корзине
     * @param Object json
     */
    updateInfo : function(json) {
        var self = this;

        if (json.count > 0) {
            $('[data-role="total-count"]').text(json.count);
            $('[data-role="total-cost"]').text(json.total);
            //товары
            if (json.products) {
                $.each(json.products, function(key, product) {
                    $('[data-role="product-cost-'+product.id+'"]').text(product.cost);
                    $('[data-role="product-count-'+product.id+'"]').text(product.count);
                });
            }

            //сумма заказа
            $('[data-role="cart-total"]').text(json.total);

            //доставка
            $('[data-role="cart-delivery"]').show();
            $('[data-role="cart-delivery"]').find('span').html(json.delivery_price > 0 ? json.delivery_price+' грн' : 'Бесплатно');

            //управление способами доставки
            if (json.delivery) {
                for (i in json.delivery) {
                    core.select('select[name="'+i+'"]', json.delivery[i].options,  json.delivery[i].value);
                }
                delete json.delivery;
            }
        } else {
            $('#cart-total').text('');
            $('#cart-count').parent().parent().html('<p><strong>В Вашей корзине<br/>нет товаров</strong></p>');
        }
    },

    /**
     * Завершение заказа
     */
    send : function(form) {
        var self = this;

        if ($(form).validateForm()) {
            self.query('complete', $(form).serialize(), function(json) {
                $(self.complete_ct).html(json.html);

                $(self.ct).find('input, select, textarea').attr('disabled', 'disabled');
                $('.buy').hide();

                //окно завершения заказа
                core.popup.create('cart-complete', json.html, {cls : 'popup_complete'});
            }, 0);
        }
        return false;
    },

    /**
     * Запрос на сервер
     */
    query : function(action, params, callback, timeout) {
        var self = this;
        core.block();
        if (self.queryUrl) {
            core.timeout('query', function(){
                $.ajax({
                    type : 'post',
                    url  : self.queryUrl + '/' + action,
                    dataType : 'json',
                    data : params,
                    success : function(json) {
                        if (json.success == true && callback && callback.call) {
                            callback.call(self, json);
                        }
                        core.unblock();
                    }
                })
            }, (timeout == undefined ? 1000 : timeout));
        }
    }
};