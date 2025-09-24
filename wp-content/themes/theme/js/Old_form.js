
jQuery(document).ready(function($) {

    function emailValidate(elem){
        var filter = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/i;
        return filter.test(elem);
    }
    function dateValidate(elem) {
        var filter = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
        return filter.test(elem);
    }
    $('.close-popup').on('click', function() {
        $('.merci-popup').removeAttr('style');
    });
    $('form.form input[type=text]').on('click', function() {
        $(this).removeClass('error');
    });
    $('form.form input[name=radio]').on('click', function() {
        $('.form-item__radio label').removeClass('error');
    });
    $('form.form').on('submit',function() {

        var sendObj = {action: 'sendForm'}
        var canSend = true;
        var type = $('[name=radio-text]:checked').val();
        $('form.form input[type=text]').each(function() {

            var inpName = $(this).attr('name');
            var inpValue = $(this).val();
            if (inpName != 'entreprises' && inpName != 'associations' && inpName != 'parent' && inpName != 'associations2' && inpName != 'entreprises2') {
                // if (inpValue == '') {
                if (inpValue.length<2) {

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
            if (societe.length<2) {
            // if (societe == '') {
                canSend = false;
                $('[name="entreprises"]').addClass('error');
            } else {
                $('[name="entreprises"]').removeClass('error');
            }

            if (societe2.length<2) {
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
            if (societe.length<2) {
                canSend = false;
                $('[name="associations"]').addClass('error');
            } else {
                $('[name="associations"]').removeClass('error');
            }
            if (societe2.length<2) {
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
          if (societe.length<2) {
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
            $.post(templateUrl+'/643b4d77-ec22-4855-9386-662e2949d990.php',sendObj, function(complete) {
                $('.merci-popup').css({'z-index' : 5, 'visibility' : 'visible' ,'opacity' : 1});
            });
            return false;
        } else {
            console.log('i cant');
            console.log(sendObj['intitule']);
            return false;

        }


    });

    $('#menu-item-47 > a, #menu-item-41 > a').on('click', function(e){
        e.preventDefault();
    });

    $('form.add-event input,form.add-event textarea').on('focus',function() {
        $(this).removeClass('error');
    });
    $('.selectric').on('click', function () {
        $(this).removeClass('error');
    });
    $('[name=event]').on('click', function(){
        $('.input-block-wrapper__info .error').removeClass('error');
    });
    $('#file-upload').change(function() {
        $("#file-name").text(this.files[0].name);
        $('.input-block-wrapper__image .error').removeClass('error');
    });
    $('form.add-event').on('submit', function(e) {
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
        }  else if (form_type == 'e') {
            entreprise = $('[name=entreprise]').val();
            if (entreprise.length<2) {
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

        $('.input-block-wrapper__info input').each(function() {
            nom = $(this).attr('name');
            valeur = $(this).val();
            if (valeur.length<2 && (nom == 'event_date' || nom == 'event_name')) {
                $(this).addClass('error');
                canSend = false;
            } else if (nom == 'date' && !dateValidate(valeur)) {
                $(this).addClass('error');
                canSend = false;
            } else {
                if (type_event == 'digital') {
                    if (nom == 'url' && valeur.length<2) {
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
        if($('#file-upload').val() == ""){
            fileError = true;
        } else {
            if($('#file-upload')[0].files[0] !== undefined){
                var file = $('#file-upload')[0].files[0];
                var fileType = file.type;
                var match = ['image/jpeg', 'image/png', 'image/jpg'];
                if((fileType != match[0]) && (fileType != match[1]) && (fileType != match[2])){
                    fileError = true;
                }
            } else {
                fileError = true;
            }
        }
        if(fileError){
            $('.input-block-wrapper__image input').addClass('error');
            canSend = false;
        }

        var descr = $('textarea[name=description]').val();
        if (descr.length<2 || descr.length > 250) {
            $('textarea[name=description]').addClass('error');
            canSend = false;
        }

        //Autorisation communication
        var autorise_communication =$('[name=autorise_communication]:checked').val();
        if(autorise_communication != '1'){
            $('.input-block-wrapper__autorise-communication input').addClass('error');
            canSend = false;
        }

        //Secteur
        var secteurs = [];
        if(form_type == 'a'){
            for(var i = 1; i <= 12; i++){
                //console.log($('[name=sa_'+i+']').val());
                var sa_check = $('[name=sa_'+i+']:checked').val();
                if(sa_check == 'sa_'+i){
                    secteurs.push(i);
                }
            }
            if(secteurs == 0){  
                $('.input-block-wrapper__i-am .selectBox select').addClass('error');
               //TODO $('textarea[name=description]').addClass('error');
                canSend = false;
            }
        }

        if (canSend) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: templateUrl+'/35a9e40e-1de1-45d0-b524-55e43be22227.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function(response){ 
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
            $('.merci-popup').css({'z-index' : 5, 'visibility' : 'visible' ,'opacity' : 1});
            return false;//Garder false pour le message et sinon recharge la page
        } else {
            return false;
        }
    });



    $(document).on('click','.fab-click', function (e) {
        id = $(this).closest('.action-block').attr('id');
        e.preventDefault();
        FB.ui({
            method: 'share',
            href: window.location.href+'?action='+id,
        }, function(response){

        });
    });

    $(document).on('click','.twi-click', function (e) {
        closest = $(this).closest('.action-block')
        e.preventDefault();
        permalink = $(this).attr('data-permalink');
        text = $(this).attr('data-text');
        url = encodeURI("http://twitter.com/share?hashtags=GivingTuesdayFR&url="+permalink+"&text="+text+"");

        window.open(url, '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');
    });
    /* Block phone click and hover on mobile */
    $('.aff-block a').on('click', function(e) {
        if ($(window).width() > 767) {
            e.preventDefault();
        }
    });

});