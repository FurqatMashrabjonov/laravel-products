$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

var BaseRecord = {
    top9: 1,
    search: '',

    more: function () {
        var ajaxSetting = {
            method: 'get',
            url: './',
            data: {
                top9: this.top9,
                search: this.search,
            },
            success: function (data) {
                $('.row.products_row').html(data.table);
            },
        };
        $.ajax(ajaxSetting);
    },

    removeone: function (id) {
        var ajaxSetting = {
            method: 'post',
            url: './clearone',
            data: {
                id: id,
            },
            success: function (data) {
                BaseRecord.cart();
            },
        };
        $.ajax(ajaxSetting);
    },

    cart: function () {
        var ajaxSetting = {
            method: 'get',
            url: './cart',
            success: function (data) {
                $('.cart_items_list').html(data.table);
                $('.listbuttonremove').click(function () {
                    BaseRecord.removeone($(this).attr('id'));
                    return false;
                });
            },
        };
        $.ajax(ajaxSetting);
    },

    mailer: function (message, contact) {
        var ajaxSetting = {
            method: 'post',
            url: './mailer',
            data: {
                message: message,
                contact: contact,
            },
            success: function (data) {
                var data_json = JSON.parse(data.answer);
                if (data_json['mail']) $('.result_to_email').html('We sent a message to your email!!!');
            },

        };
        $.ajax(ajaxSetting);
    },

    clearone: function () {
        var ajaxSetting = {
            method: 'post',
            url: './clearall',
           // data: {
               // id: id,
           // },
            success: function (data) {
                BaseRecord.cart();
            },
        };
        $.ajax(ajaxSetting);
    },

};
