/**
 * Created by kliko on 10/8/15.
 */
app.controller('sizeController', function ($scope, sizeService) {
//    $scope.sizes =
    $scope.selectedSize = function (select) {
//        console.log(select);
        sizeService.getSizeColor(select)
            .then(function(response) {
                console.log(response.data);
                var priceText = 'incl. BTW: ' + response.data.price + ' / excl. BTW: ' + ((response.data.price / 1.21).toFixed(2));
                if(response.data.discount + 0) priceText = 'incl. BTW: ' + response.data.discount + ' / excl. BTW: ' + ((response.data.discount / 1.21).toFixed(2));
                if(response.data.colors.length) {
                    var colorsHTML = '<label style="font-size: 14px;">Select color:</label><div class="radio-size">',
                        colors = response.data.colors;
                    colors.forEach(function(elm) {
                        colorsHTML += '<div class="funkyradio-primary ' + (elm.color.toLowerCase() == '#ffffff' ? 'white' : '') + '"><input id="' + elm.id + '" type="radio" name="color_id" value="' + elm.id + '"><label for="' + elm.id + '" style="background:' + elm.color + '"></label></div>';
                    });
                    colorsHTML += '</div>';
                    $('#colors').html(colorsHTML);
                } else {
                    $('#colors').html('');
                }
                $('#priceHolder').text(priceText);
                $('#priceHolder').parent().removeClass('hidden');
            });
    };
});