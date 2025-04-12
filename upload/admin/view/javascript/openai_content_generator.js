$(document).ready(function() {
    $('.button-generate-content').on('click', function() {
        var product_id = getURLVar('product_id');
        var field = $(this).data('field');
        var button = $(this);
        
        if (!product_id) {
            alert('Please save the product first to get its ID');
            return;
        }

        $.ajax({
            url: 'index.php?route=extension/module/openai_content_generator/generateProductContent&user_token=' + getURLVar('user_token'),
            type: 'GET',
            data: {
                product_id: product_id,
                field: field
            },
            dataType: 'json',
            beforeSend: function() {
                button.button('loading');
            },
            complete: function() {
                button.button('reset');
            },
            success: function(json) {
                if (json['success']) {
                    switch (field) {
                        case 'name':
                            $('#input-name1').val(json['data']['content']);
                            break;
                        case 'title':
                            $('#input-meta-title1').val(json['data']['content']);
                            break;
                        case 'model':
                            $('#input-model').val(json['data']['content']);
                            break;
                        case 'description':
                            $('#input-description1').val(json['data']['content']);
                            break;
                    }
                    alert('Content generated successfully!');
                } else {
                    alert(json['error']);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
}); 