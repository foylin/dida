/*
 * @Author: lin
 * @GitHub: https://github.com/foylin/dida
 * @Date: 2019-10-18 00:46:45
 * @Description: message
 */
$(document).ready(function () {
    new ClipboardJS('.btn-shareurl');

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
                    var html = '<div class="share-main">';
                        html += '<div class="share-input-group"><input id="input-shareurl" class="" name="" value="'+shareurl+'" />';
                        html += '<span class="share-input-group-button"><button class="btn-shareurl" data-clipboard-target="#input-shareurl">copy</button></span></div>';
                        html += '<p>Share this link. If your friends shop through it, you will get at least <span>10%</span> commission.</p>'
                        html += '</div>';
                    layer.open({
                        type: 1, 
                        area: ['500px', '200px'],
                        content: html 
                    });
                }   

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) { }
        });

    })

    $("#completed").click(function(){
        layer.confirm('Confirm product received ？', {
            btn: ['Yes','Cancel'] //按钮
          }, function(){
            // layer.msg('的确很重要', {icon: 1});
            var order_id = $('#order_id').val();
            jQuery.ajax({
                async: true,
                timeout: 6000,
                dataType: 'json',
                type: 'get',
                data: {
                    'order_id': order_id,
                    // 'product_id':product_id
                },
                url: '/customer/order/completed',
                success: function (data, textStatus) {
                    console.log(data);
                    if (data.status == 'success') {
                        window.location.reload();
                    } else {
                        
                    //     var shareurl = $('#divShareProduct').data('shareurl') + '&share_uid=' + data.uid;
                    //     var html = '<div class="share-main">';
                    //         html += '<div class="share-input-group"><input id="input-shareurl" class="" name="" value="'+shareurl+'" />';
                    //         html += '<span class="share-input-group-button"><button class="btn-shareurl" data-clipboard-target="#input-shareurl">copy</button></span></div>';
                    //         html += '<p>Share this link. If your friends shop through it, you will get at least <span>10%</span> commission.</p>'
                    //         html += '</div>';
                        layer.msg(data.msg);
                    }   
    
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) { }
            });
          }, function(){
            // layer.msg('也可以这样', {
            //   time: 20000, //20s后自动关闭
            //   btn: ['明白了', '知道了']
            // });
          });
    })
});


