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
});


