$(document).ready(function () {
    $('#myShare').click(function () {
        
        jQuery.ajax({
            async: true,
            timeout: 6000,
            dataType: 'json',
            type: 'get',
            // data: {
            //     'currentUrl':window.location.href,
            //     'product_id':product_id
            // },
            url: '/customer/ajax',
            success: function (data, textStatus) {
                // console.log(data);
                if (data.loginStatus == false) {
                    window.location.href = "/customer/account/login";
                } else {
                    
                    var shareurl = $('#divShareProduct').data('shareurl') + '&share_uid=' + data.uid;
                    var html = '<div>';
                        html += '<div><input name="" value="'+shareurl+'" /></div>';
                        html += '</div>';
                    layer.open({
                        type: 1, 
                        area: ['500px', '300px'],
                        content: html 
                    });
                }   

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) { }
        });

    })
});


