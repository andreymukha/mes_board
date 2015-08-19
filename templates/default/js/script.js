/**
 * Created by Fly on 08.08.2015.
 */

$(document).ready(function () {
    var i = 1;
    var dropdowns = $("input.mes_image, input[type='checkbox'], input[type='radio'], select");
    dropdowns.styler();
    $('#add_img').click(function () {
        i++;
        $('<div class="img"><label for="add_mes_image' + i + '">Дополнительное изображение ' + i + '</label><input id="add_mes_image' + i + '" class="mes_image" name="additional_img[]" type="file" value=""/><br /></div>').fadeIn('slow').appendTo('.additional_images');
        $('#add_mes_image' + i).styler();
        if(i>=20){
            $(this).remove();
        }
        return false;
    });
});