jQuery(document).ready(function ($) {

    function emailValidate(elem) {
        var filter = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/i;
        return filter.test(elem);
    }
    function emailAdresseValidate(elem) {
        var filter = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        return filter.test(elem);
    }
    function dateValidate(elem) {
        var filter = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
        return filter.test(elem);
    }
    $('.close-popup').on('click', function () {
        $('.merci-popup').removeAttr('style');
    });
    $('form.form input[type=text]').on('click', function () {
        $(this).removeClass('error');
    });
    $('form.form input[name=radio]').on('click', function () {
        $('.form-item__radio label').removeClass('error');
    });
    $('.selectric').on('click', function () {
        $('.error_secteur').removeClass('error');
    });
    $('form.form').on('submit', function () {
        var sendObj = { action: 'sendForm' }
        var canSend = true;
        var type = $('[name=radio-text]:checked').val();
        $('form.form input[type=text]').each(function () {

            var inpName = $(this).attr('name');
            var inpValue = $(this).val();
            if (inpName != 'entreprises' && inpName != 'associations' && inpName != 'parent' && inpName != 'associations2' && inpName != 'entreprises2') {
                // if (inpValue == '') {
                if (inpValue.length < 2) {

                    canSend = false;
                    $(this).addClass('error');
                } else if (inpName == 'email' && !emailValidate(inpValue)) {
                    canSend = false;
                    $(this).addClass('error');
                } else {
                    sendObj[inpName] = inpValue;
                }
            }



        });
        sendObj['type'] = type;
        if (type == 'individus') {
            var societe = '-';
            var societe2 = '-';
        }
        else if (type == 'entreprises') {
            var societe = $('[name="entreprises"]').val();
            var societe2 = $('[name="entreprises2"]').val();
            if (societe.length < 2) {
                // if (societe == '') {
                canSend = false;
                $('[name="entreprises"]').addClass('error');
            } else {
                $('[name="entreprises"]').removeClass('error');
            }

            if (societe2.length < 2) {
                // if (societe == '') {
                canSend = false;
                $('[name="entreprises2"]').addClass('error');
            } else {
                $('[name="entreprises2"]').removeClass('error');
            }

        }
        else if (type == 'associations') {
            var societe = $('[name="associations"]').val();
            var societe2 = $('[name="associations2"]').val();
            // if (societe == '') {
            if (societe.length < 2) {
                canSend = false;
                $('[name="associations"]').addClass('error');
            } else {
                $('[name="associations"]').removeClass('error');
            }
            if (societe2.length < 2) {
                canSend = false;
                $('[name="associations2"]').addClass('error');
            } else {
                $('[name="associations2"]').removeClass('error');
            }
        }
        else if (type == 'parent') {
            var societe = $('[name="parent"]').val();
            var societe2 = '-';
            // if (societe == '') {
            if (societe.length < 2) {
                canSend = false;
                $('[name="parent"]').addClass('error');
                // societe = '-';
            }
            else {
                $('[name="parent"]').removeClass('error');
            }
        }

        sendObj['societe'] = societe;
        sendObj['intitule'] = societe2;
        var civilite = $('[name=radio]:checked').val();
        if (civilite == '' || civilite == undefined) {
            canSend = false;
            $('.form-item__radio label').addClass('error');
        } else {
            sendObj['civilite'] = civilite;
        }

        if (canSend) {
            console.log(templateUrl);
            console.log(sendObj);
            $.post(templateUrl + '/643b4d77-ec22-4855-9386-662e2949d990.php', sendObj, function (complete) {
                $('.merci-popup').css({ 'z-index': 5, 'visibility': 'visible', 'opacity': 1 });
            });
            return false;
        } else {
            console.log('i cant');
            console.log(sendObj['intitule']);
            return false;

        }


    });

    $('#menu-item-47 > a, #menu-item-41 > a').on('click', function (e) {
        e.preventDefault();
    });

    $('form.add-event input,form.add-event textarea').on('focus', function () {
        $(this).removeClass('error');
    });
    $('.selectric').on('click', function () {
        $(this).removeClass('error');
    });

    $('[name=event]').on('click', function () {
        $('.input-block-wrapper__info .error').removeClass('error');
    });
    $('#file-upload').change(function () {
        $("#file-name").text(this.files[0].name);
        $('.input-block-wrapper__image .error').removeClass('error');
    });
    $('form.add-event').on('submit', function (e) {
        var temp_value = $('#date1').val();
        var date = temp_value.split("/").reverse().join("-");
        $('#date1').val(date);
        var form_type = $('[name=form_type]:checked').val();
        canSend = true;
        if (form_type == 'a') {
            association = $('[name=association]').val();
            if (association.length < 2) {
                $('[name=association]').addClass('error');
                canSend = false;
            }
        } else if (form_type == 'e') {
            entreprise = $('[name=entreprise]').val();
            if (entreprise.length < 2) {
                $('[name=entreprise]').addClass('error');
                canSend = false;
            }
        }
        var type_event = $('[name=event]:checked').val();

        region = $('[name=region] option:selected').val();
        if (region == '') {
            if (type_event != 'digital') {
                $('[name=region]').closest('.selectric-wrapper').find('.selectric').addClass('error');
                canSend = false;
            }
        }

        $('.input-block-wrapper__info input').each(function () {
            nom = $(this).attr('name');
            valeur = $(this).val();
            if (valeur.length < 2 && (nom == 'event_date' || nom == 'event_name')) {
                $(this).addClass('error');
                canSend = false;
            } else if (nom == 'date' && !dateValidate(valeur)) {
                $(this).addClass('error');
                canSend = false;
            } else {
                if (type_event == 'digital') {
                    if (nom == 'url' && valeur.length < 2) {
                        $(this).addClass('error');
                        canSend = false;
                    }
                }/* else {
                    if (nom == 'region' && valeur.length<2) {
                        $(this).addClass('error');
                        canSend = false;
                    }
                }*/
            }
        });

        var fileError = false;
        if ($('#file-upload').val() == "") {
            fileError = true;
        } else {
            if ($('#file-upload')[0].files[0] !== undefined) {
                var file = $('#file-upload')[0].files[0];
                var fileType = file.type;
                var match = ['image/jpeg', 'image/png', 'image/jpg'];
                if ((fileType != match[0]) && (fileType != match[1]) && (fileType != match[2])) {
                    fileError = true;
                }
            } else {
                fileError = true;
            }
        }
        if (fileError) {
            $('.input-block-wrapper__image input').addClass('error');
            canSend = false;
        }

        var descr = $('textarea[name=description]').val();
        if (descr.length < 2 || descr.length > 250) {
            $('textarea[name=description]').addClass('error');
            canSend = false;
        }

        //Autorisation communication
        var autorise_communication = $('[name=autorise_communication]:checked').val();
        if (autorise_communication != '1') {
            $('.input-block-wrapper__autorise-communication input').addClass('error');
            canSend = false;
        }

        //Secteur
        var secteurs = [];
        if (form_type == 'a') {
            for (var i = 1; i <= 12; i++) {
                //console.log($('[name=sa_'+i+']').val());
                var sa_check = $('[name=sa_' + i + ']:checked').val();
                if (sa_check == 'sa_' + i) {
                    secteurs.push(i);
                }
            }
            if (secteurs == 0) {
                $('.input-block-wrapper__i-am .selectBox select').addClass('error');
                $('.error_secteur').addClass('error');
                canSend = false;
            }
        }

        if (canSend) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: templateUrl + '/35a9e40e-1de1-45d0-b524-55e43be22227.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    /*if(response.status == 1){
                        //OK
                        console.log('OK');
                    }else{
                        //KO
                        console.log('KO');
                    }*/
                }
            });
            $('form.add-event input[type=text],form.add-event textarea').val('');
            $('[name=form_type]').first().trigger('click');
            $('[name=gender]').first().trigger('click');
            $('[name=event]').first().trigger('click');
            $('[name=category]').first().trigger('click');
            $('[name=region]').closest('.selectric-wrapper').find('.selectric-items li').first().trigger('click');
            $('.merci-popup').css({ 'z-index': 5, 'visibility': 'visible', 'opacity': 1 });
            return false;//Garder false pour le message et sinon recharge la page
        } else {
            return false;
        }
    });



    $(document).on('click', '.fab-click', function (e) {
        id = $(this).closest('.action-block').attr('id');
        e.preventDefault();
        FB.ui({
            method: 'share',
            href: window.location.href + '?action=' + id,
        }, function (response) {

        });
    });

    $(document).on('click', '.twi-click', function (e) {
        closest = $(this).closest('.action-block')
        e.preventDefault();
        permalink = $(this).attr('data-permalink');
        text = $(this).attr('data-text');
        url = encodeURI("http://twitter.com/share?hashtags=GivingTuesdayFR&url=" + permalink + "&text=" + text + "");

        window.open(url, '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');
    });
    /* Block phone click and hover on mobile */
    $('.aff-block a').on('click', function (e) {
        if ($(window).width() > 767) {
            e.preventDefault();
        }
    });





    //Page Je publie mon action
    $('#region-select').selectric({
        onChange: function () {
            let vo = $(this).val();
            $('#region-select option[value="' + vo + '"]').attr("selected", "selected");
        },
    });
    $(".input-block-wrapper__i-am._i-am .input-wrapper > label").on("click", function (e) {
        $(".input-block-wrapper__i-am._i-am .input-wrapper > label").removeClass("checkedl");
        $(".input-block-wrapper__i-am input:radio[name=form_type]").attr("checked", false);
        $(this).addClass("checkedl");
        $(this).prev("input:radio[name=form_type]").attr("checked", true);
    });
    $(".input-block-wrapper__events input:radio").on("click", function (e) {
        $(".input-block-wrapper__events input:radio").attr("checked", false);
        $(".input-block-wrapper__events .event-label").removeClass("checkedl");
        $(this).next().addClass("checkedl");
        $(this).attr("checked", true);
    });
    $(".input-block-wrapper__category input:radio[name=category]").on("click", function (e) {
        $(".input-block-wrapper__category input:radio").attr("checked", false);
        $(".input-block-wrapper__category .category-label").removeClass("ttt");
        $(this).next().addClass("ttt");
        $(this).attr("checked", true);
    });
    $("body").on('click', '.close-answers', function (e) {
        e.preventDefault();
        $(".answer-block").removeClass("show");
    })
    $(".close-answers.show-answers").on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $("#add-action-form").offset().top - 50
        }, 1500);
    });
    var canSendForm = false;
    $(".show-answers.blue").on('click', function (e) {
        e.preventDefault();
        var temp_value = $('#date1').val();
        var date = temp_value.split("/").reverse().join("-");
        $('#date1').val(date);
        var form_type = $('[name=form_type]:checked').val();
        var canSend = true;
        if (form_type == 'a') {
            association = $('[name=association]').val();
            if (association.length < 2) {
                $('[name=association]').addClass('error');
                canSend = false;
            }
            if ($("#sa_checkboxes input:checkbox:checked").length < 1) {
                activ = $("#sa_checkboxes").addClass("error");
            }
        } else if (form_type == 'e') {
            entreprise = $('[name=entreprise]').val();
            if (entreprise.length < 2) {
                $('[name=entreprise]').addClass('error');
                canSend = false;
            }
        }
        var type_event = $('[name=event]:checked').val();

        region = $('[name=region] option:selected').val();
        if (region == '') {
            if (type_event != 'digital') {
                $('[name=region]').closest('.selectric-wrapper').find('.selectric').addClass('error');
                canSend = false;
            }

            if ($("input:text[name=nom]").val().length < 2) {
                $("input:text[name=nom]").addClass("error");
                canSend = false;
            }
            if ($("input:text[name=prenom]").val().length < 2) {
                $("input:text[name=prenom]").addClass("error");
                canSend = false;
            }
            if (!emailAdresseValidate($("input:text[name=email]").val())) {
                $("input:text[name=email]").addClass("error");
                canSend = false;
            }


            $('.input-block-wrapper__info input').each(function () {
                nom = $(this).attr('name');
                valeur = $(this).val();
                if (valeur.length < 2 && (nom == 'event_date' || nom == 'event_name')) {
                    $(this).addClass('error');
                    canSend = false;
                } else if (nom == 'date' && !dateValidate(valeur)) {
                    $(this).addClass('error');
                    canSend = false;
                } else {
                    if (type_event == 'digital') {
                        if (nom == 'url' && valeur.length < 2) {
                            $(this).addClass('error');
                            canSend = false;
                        }
                    } else {
                        if (nom == 'region' && valeur.length < 2) {
                            $(this).addClass('error');
                            canSend = false;
                        }
                    }
                }
            });

            var fileError = false;
            if ($('#file-upload').val() == "") {
                fileError = true;
            } else {
                if ($('#file-upload')[0].files[0] !== undefined) {
                    var file = $('#file-upload')[0].files[0];
                    var fileType = file.type;
                    var match = ['image/jpeg', 'image/png', 'image/jpg'];
                    if ((fileType != match[0]) && (fileType != match[1]) && (fileType != match[2])) {
                        fileError = true;
                    }
                } else {
                    fileError = true;
                }
            }
            if (fileError) {
                $('.input-block-wrapper__image input').addClass('error');
                canSend = false;
            }

            var descr = $('textarea[name=description]').val();
            if (descr.length < 2 || descr.length > 250) {
                $('textarea[name=description]').addClass('error');
                canSend = false;
            }

            //Autorisation communication
            var autorise_communication = $('[name=autorise_communication]:checked').val();
            // console.log('error....');
            if (autorise_communication != '1') {
                $('.input-block-wrapper__autorise-communication label').addClass('error');
                canSend = false;
            }

            //Secteur
            var secteurs = [];
            if (form_type == 'a') {
                for (var i = 1; i <= 12; i++) {
                    //console.log($('[name=sa_'+i+']').val());
                    var sa_check = $('[name=sec_' + i + ']:checked').val();
                    if (sa_check == 'sec_' + i) {
                        secteurs.push(i);
                    }
                }
                if (secteurs == 0) {
                    $('.input-block-wrapper__i-am .selectBox select').addClass('error');
                    //TODO $('textarea[name=description]').addClass('error');
                    canSend = false;
                }
            }


            if (canSend) {

                canSendForm = true;
                $(".answer-block").addClass("show");
                $(".answer-block .answer-content2").remove("show");
                let label = $(".input-block-wrapper__i-am._i-am .input-wrapper > input:radio[name=form_type]");

                label.each(function (i, e) {
                    if ($(this).attr("checked")) {
                        $(".answer__i-am label").removeClass("checkedl");
                        $(".answer__i-am label:eq(" + i + ")").addClass("checkedl");
                        let c = "";
                        switch (i) {
                            case 1:
                                c = '<div><strong>Nom de société :</strong><div> ' + $("input:text[name=association]").val() + '</div>';
                                let activ = $("#sa_checkboxes input:checkbox:checked"), v = [];
                                activ.each(function (i, val) {
                                    v.push($(this).parent().text());
                                })

                                c += '<div><strong>Secteur d\'activité:</strong><div> ' + v.join(" - ") + '</div>';
                                break;
                            case 2:
                                c = '<div><strong>Nom de l\’entreprise :</strong><div> ' + $("input:text[name=entreprise]").val() + '</div>';
                                c += '<div><strong>Intitulé de poste :</strong><div> ' + $("input:text[name=entreprises2]").val() + '</div>';
                                break;
                            case 3:
                                c = '<div><strong>Nom de l\'établissement :</strong><div> ' + $("input:text[name=parent]").val() + '</div>';
                                break;
                            default: c = "";

                        }

                        $(".input-answers").html(c);

                        if ($(".input-block-wrapper__gender input:radio[name=gender]:checked").val()) {
                            c = $(".input-block-wrapper__gender input:radio[name=gender]:checked").val().toUpperCase();
                        }

                        if ($(".input-block-wrapper__personal-data input:text[name=nom]").val()) {
                            c += '. ' + $(".input-block-wrapper__personal-data input:text[name=nom]").val();
                        }

                        if ($(".input-block-wrapper__personal-data input:text[name=prenom]").val()) {
                            c += ' ' + $(".input-block-wrapper__personal-data input:text[name=prenom]").val();
                        }

                        if ($(".input-block-wrapper__personal-data input:text[name=email]").val()) {
                            c += '<br><strong>Adresse: </strong>' + $(".input-block-wrapper__personal-data input:text[name=email]").val();
                        }
                        c = '<div ><strong>Votre nom : </strong>' + c + '</div>';
                        $(".answer__personal-data").html(c);
                        c = $(".input-block-wrapper__events input:radio[name=event]:checked").parent(".input-wrapper").html();
                        $(".answer__events .input-wrapper").html(c);
                        c = $(".input-block-wrapper__category input:radio[name=category]:checked").parent(".input-wrapper").html();

                        $(".answer__category .input-wrapper").html(c);
                        c = $(".__info input:text[name=event_name]").val();
                        $("input:text[name=event_name_answer]").val(c);

                        c = $(".__info input:text[name=event_date]").val();
                        $("input:text[name=event_date_answer]").val(c);

                        c = $(".__info input:text[name=url]").val();
                        $("input:text[name=url_answer]").val(c);

                        c = $(".__info textarea[name=description]").val();
                        $("textarea[name=description_answer]").val(c);

                    }

                })

            }
        }
    });
    $("form.add-action").on('change', 'input', function (e) {
        $('form.add-action input').removeClass("error");
        $('form.add-action #sa_checkboxes').removeClass("error");
        $('form.add-action textarea').removeClass("error");
        $('form.add-action .text-block').removeClass("error");

    });
    $("form.add-action").on('submit', function (e) {
        e.preventDefault();
        if (canSendForm) {
            $(".add-action .submit-action").html('<i class="fa fa-spinner" aria-hidden="true"></i>');
            $(".add-action .show-answers.close-answers").hide();

            // Start send mail
            let data1 = $('form').serialize();
            $.ajax({
                type: 'post',
                url: templateUrl + '/je-publie-mon-action-send.php',
                data: data1,
                success: function (response) {
                }
            });
            // End send mail

            $.ajax({
                type: 'POST',
                url: templateUrl + '/35a9e40e-1de1-45d0-b524-55e43be22228.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,

                success: function (response) {
                    if (response.status == 1) {
                        //OK
                        console.log('OK');
                    } else {
                        //KO
                        console.log('KO');
                    }
                    let res = '<a href="#" class="close-answers"><i class="fa fa-times" aria-hidden="true"></i></a>';

                    res += '<div class="reponse">Merci beaucoup pour votre participation ! Votre événement a bien été pris en compte et ajouté dans la liste des événements pour le #GivingTuesdayFr </div>';

                    $(".answer-block .answer-content2").addClass("show").html(res);
                    $(".add-action .submit-action").html('Je modifie mon évènement');
                    $(".add-action .show-answers.close-answers").show();
                }

            });

            $('form.add-action input[type=text],form.add-action textarea, form.add-action.file-name').val('');
            $('[name=form_type]').first().trigger('click');
            $('[name=gender]').first().trigger('click');
            $('[name=event]').first().trigger('click');
            $('[name=category]').first().trigger('click');
            $('[name=region]').closest('.selectric-wrapper').find('.selectric-items li').first().trigger('click');
            //$('.merci-popup').css({'z-index' : 5, 'visibility' : 'visible' ,'opacity' : 1});
            return false;//Garder false pour le message et sinon recharge la page
        } else {
            return false;
        }
    });
    //$("form.add-action").on('submit', function(e) {e.preventDefault();});
    // $('form.add-event').on('submit', function(e) {
    //     var temp_value = $('#date1').val();
    //     var date = temp_value.split("/").reverse().join("-");
    //     $('#date1').val(date);
    //     var form_type = $('[name=form_type]:checked').val();
    //     canSend = true;
    //     if (form_type == 'a') {
    //         association = $('[name=association]').val();
    //         if (association.length < 2) {
    //             $('[name=association]').addClass('error');
    //             canSend = false;
    //         }
    //     }  else if (form_type == 'e') {
    //         entreprise = $('[name=entreprise]').val();
    //         if (entreprise.length<2) {
    //             $('[name=entreprise]').addClass('error');
    //             canSend = false;
    //         }
    //     }
    //     var type_event = $('[name=event]:checked').val();

    //     region = $('[name=region] option:selected').val();
    //     if (region == '') {
    //         if (type_event != 'digital') {
    //             $('[name=region]').closest('.selectric-wrapper').find('.selectric').addClass('error');
    //             canSend = false;
    //         }
    //     }

    //     $('.input-block-wrapper__info input').each(function() {
    //         nom = $(this).attr('name');
    //         valeur = $(this).val();
    //         if (valeur.length<2 && (nom == 'event_date' || nom == 'event_name')) {
    //             $(this).addClass('error');
    //             canSend = false;
    //         } else if (nom == 'date' && !dateValidate(valeur)) {
    //             $(this).addClass('error');
    //             canSend = false;
    //         } else {
    //             if (type_event == 'digital') {
    //                 if (nom == 'url' && valeur.length<2) {
    //                     $(this).addClass('error');
    //                     canSend = false;
    //                 }
    //             }/* else {
    //                 if (nom == 'region' && valeur.length<2) {
    //                     $(this).addClass('error');
    //                     canSend = false;
    //                 }
    //             }*/
    //         }
    //     });

    //     var fileError = false;
    //     if($('#file-upload').val() == ""){
    //         fileError = true;
    //     } else {
    //         if($('#file-upload')[0].files[0] !== undefined){
    //             var file = $('#file-upload')[0].files[0];
    //             var fileType = file.type;
    //             var match = ['image/jpeg', 'image/png', 'image/jpg'];
    //             if((fileType != match[0]) && (fileType != match[1]) && (fileType != match[2])){
    //                 fileError = true;
    //             }
    //         } else {
    //             fileError = true;
    //         }
    //     }
    //     if(fileError){
    //         $('.input-block-wrapper__image input').addClass('error');
    //         canSend = false;
    //     }

    //     var descr = $('textarea[name=description]').val();
    //     if (descr.length<2 || descr.length > 250) {
    //         $('textarea[name=description]').addClass('error');
    //         canSend = false;
    //     }

    //     //Autorisation communication
    //     var autorise_communication =$('[name=autorise_communication]:checked').val();
    //     if(autorise_communication != '1'){
    //         $('.input-block-wrapper__autorise-communication input').addClass('error');
    //         canSend = false;
    //     }

    //     //Secteur
    //     var secteurs = [];
    //     if(form_type == 'a'){
    //         for(var i = 1; i <= 12; i++){
    //             //console.log($('[name=sa_'+i+']').val());
    //             var sa_check = $('[name=sa_'+i+']:checked').val();
    //             if(sa_check == 'sa_'+i){
    //                 secteurs.push(i);
    //             }
    //         }
    //         if(secteurs == 0){  
    //             $('.input-block-wrapper__i-am .selectBox select').addClass('error');
    //            //TODO $('textarea[name=description]').addClass('error');
    //             canSend = false;
    //         }
    //     }

    //     if (canSend) {
    //         e.preventDefault();
    //         $.ajax({
    //             type: 'POST',
    //             url: templateUrl+'/35a9e40e-1de1-45d0-b524-55e43be22227.php',
    //             data: new FormData(this),
    //             dataType: 'json',
    //             contentType: false,
    //             cache: false,
    //             processData:false,
    //             success: function(response){ 
    //                 /*if(response.status == 1){
    //                     //OK
    //                     console.log('OK');
    //                 }else{
    //                     //KO
    //                     console.log('KO');
    //                 }*/
    //             }
    //         });
    //         $('form.add-event input[type=text],form.add-event textarea').val('');
    //         $('[name=form_type]').first().trigger('click');
    //         $('[name=gender]').first().trigger('click');
    //         $('[name=event]').first().trigger('click');
    //         $('[name=category]').first().trigger('click');
    //         $('[name=region]').closest('.selectric-wrapper').find('.selectric-items li').first().trigger('click');
    //         $('.merci-popup').css({'z-index' : 5, 'visibility' : 'visible' ,'opacity' : 1});
    //         return false;//Garder false pour le message et sinon recharge la page
    //     } else {
    //         return false;
    //     }
    // });

});