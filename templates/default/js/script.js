/**
 * Created by Fly on 08.08.2015.
 */

$(document).ready(function () {
    var last_image = $('.additional_images div.img:last label').text();
    var i = last_image.match(/[0-9]+/);
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

    //Подключаем колорбокс
    function colorBoxGroup() {
        var colorBoxGroup = $('.group1');
        if ( colorBoxGroup.length ) {
            colorBoxGroup.colorbox({
                rel: 'group1',
                maxWidth: "100%",
                maxHeight: "100%"
            });
        }
    }

    //Подключаем карусель
    function JCarcusel() {
        $('.jcarousel').jcarousel({

        });
    }

    //Валидация добавления/редактирования объявления
    $('#add_message, #add_message')

        .on('init.field.fv', function(e, data) {
            var $parent = data.element.parents('.form-group'),
                $icon   = $parent.find('.form-control-feedback[data-fv-icon-for="' + data.field + '"]');
            $icon.on('click.clearing', function() {
                if ($icon.hasClass('glyphicon-remove')) {
                    data.fv.resetField(data.element);
                }
            });
        })

        .formValidation({
        live: 'enabled',
        framework: 'bootstrap',
        button: {
            selector: '#validateButton',
            disabled: 'disabled'
        },
        locale: 'ru_RU',
        message: 'Поле введено неверно',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            mes_title: {
                validators: {
                    notEmpty: {
                        message: "Это поле не может быть пустым"
                    },
                    stringLength: {
                        message: 'Заголовок слишком короткий',
                        min: 10
                    }
                }
            },
            mes_type:{
                validators:{
                    notEmpty:{
                        message: "Выберите тип объявления"
                    }
                }
            },
            mes_image:{
                validators:{
                    notEmpty:{
                        message: "Загрузите изображение"
                    },
                    file: {
                        extension: 'jpeg,jpg,png,gif',
                        type: 'image/jpeg,image/pjpeg,image/png,image/x-png,image/gif',
                        message: 'Неверный тип изображения, можно загружать только .jpg, .jpeg, .png, .gif'
                    }
                }
            },
            mes_categories:{
                validators:{
                    notEmpty:{
                        message: "Выберите категорию"
                    }
                }
            },
            mes_town:{
                validators:{
                    notEmpty:{
                        message: "Это поле не может быть пустым"
                    }
                }
            },
            mes_price:{
                validators:{
                    notEmpty:{
                        message: "Это поле не может быть пустым"
                    },
                    digits: {
                        message: 'В это поле можно вводить только цифры'
                    },
                    regexp: {
                        regexp: /^[^0]{1}/,
                        message: 'Цена не должна ровняться нулю или начинаться с нуля'
                    },
                    stringLength: {
                        message: 'Цена не может содержать только одну цифру',
                        min: 2
                    }
                }
            },
            mes_body:{
                validators:{
                    notEmpty:{
                        message: "Это поле не может быть пустым"
                    },
                    stringLength: {
                        message: 'Текст объявления слишком короткий',
                        min: 100
                    }
                }
            },
            capcha:{
                validators:{
                    notEmpty:{
                        message: "Это поле не может быть пустым"
                    }
                }
            }
        }
    });

    //Валидация регистрации
    $('#registration')

        .on('init.field.fv', function(e, data) {
            var $parent = data.element.parents('.form-group'),
                $icon   = $parent.find('.form-control-feedback[data-fv-icon-for="' + data.field + '"]');
            $icon.on('click.clearing', function() {
                if ($icon.hasClass('glyphicon-remove')) {
                    data.fv.resetField(data.element);
                }
            });
        })

        .formValidation({
            live: 'enabled',
            framework: 'bootstrap',
            button: {
                selector: '#reg_button',
                disabled: 'disabled'
            },
            locale: 'ru_RU',
            message: 'Поле введено неверно',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                reg_login: {
                    validators: {
                        notEmpty: {
                            message: "Это поле не может быть пустым"
                        },
                        stringLength: {
                            message: 'Логин должен быть не меньше 4х символов',
                            min: 4
                        }
                    }
                },
                reg_email: {
                    validators: {
                        notEmpty: {
                            message: "Это поле не может быть пустым"
                        },
                        emailAddress: {
                            message: 'Значение не является допустимым адресом электронной почты'
                        },
                        regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'Значение не является допустимым адресом электронной почты'
                        }
                    }
                },
                reg_name: {
                    validators: {
                        notEmpty: {
                            message: "Это поле не может быть пустым"
                        },
                        stringLength: {
                            message: 'Логин должен быть не меньше 2х символов',
                            min: 2
                        }
                    }
                },
                reg_password: {
                    validators: {
                        notEmpty: {
                            message: "Это поле не может быть пустым"
                        },
                        stringLength: {
                            message: 'Логин должен быть не меньше 6х символов',
                            min: 6
                        },
                        identical: {
                            field: 'reg_password_confirm',
                            message: 'Пароли должны быть одинаковы'
                        }
                    }
                },
                reg_password_confirm: {
                    validators: {
                        notEmpty: {
                            message: "Это поле не может быть пустым"
                        },
                        stringLength: {
                            message: 'Логин должен быть не меньше 6х символов',
                            min: 6
                        },
                        identical: {
                            field: 'reg_password',
                            message: 'Пароли должны быть одинаковы'
                        }
                    }
                }
            }
        });


    // Call functions
    $(function() {
        colorBoxGroup();
        JCarcusel();
    });
});