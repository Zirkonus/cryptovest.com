$(document).ready(function () {
    // created by Artem
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('#token').attr('data')}});
    // preloader
    $('.datepicker').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
    jQuery.ajaxSetup({
      beforeSend: function() {
         $('#loadingDiv').show();
      },
      complete: function(){
         $('#loadingDiv').hide();
      },
      success: function() {}
    });
// validations settings
        $("#register-form").validate({
              rules: {
                name: "required",
                email: {
                  required: true,
                  email: true
                },
                // mobile: {
                //     digits: true
                // }
            },
        })
        // $("#ico-information").validate({
        //       rules: {
        //         iconame: "required",
        //         description: "required",
        //         website: "required",
        //         industry: "required",
        //         whitepaper: "required",
        //         selectPlatform: "required",
        //         selectCoinName: "required",
        //         shortCoinName: "required",
        //         totalsupply: "required",
        //         // icoavatar: {
        //         //     required: true,
        //         //     extension: "jpeg|png"
        //         // },
        //         numberofcoin: {
        //             required: true,
        //             digits: true
        //         },
        //         startdate: {
        //             required: true,
        //             date: true
        //         },
        //         enddate: {
        //             required: true,
        //             date: true
        //         }
        //     },
        // })
        // $('input[name^="icoavatar"]').each(function () {
        //     $(this).rules('add', {
        //         required: true,
        //         accept: "image/jpeg, image/pjpeg"
        //     })
        // })
// transition to next tab

var buyerId = '';
var icoId = '';

    var step = $('.wizard-block .wizard li:first-child');
    var nextTab = function (selector) {
        if (typeof selector == 'string') {
            $(selector).closest(".hide-this-submit-block").removeClass("active-block");
            $(selector).closest(".hide-this-submit-block").next(".hide-this-submit-block").addClass("active-block");
            step = step.next('li');
            step.addClass("active-step");
        } else {
            $(this).closest(".hide-this-submit-block").removeClass("active-block");
            $(this).closest(".hide-this-submit-block").next(".hide-this-submit-block").addClass("active-block");
            step = step.next('li');
            step.addClass("active-step");
        }

    };

    $('select option').each(function( index ) {
        if($( this ).attr("data-other") == 'other') {
            $( this ).remove();
        };
    });

    $("#selectIndustry").on("change", function() {
        if ($("#selectIndustry").val() == 'null'){
            $('.my-industry').show();
            $('#myIndustry').focus();
        } else {
            $('.my-industry').hide();
        }
    });
    $("#selectPlatform").on("change", function() {
        if ($("#selectPlatform").val() == 'null'){
            $('.my-platform').show();
            $('#myPlatform').focus();
        } else {
            $('.my-platform').hide();
        }
    });

// transition to previous tab 
    var previousTab = function () {
        $(this).closest(".hide-this-submit-block").removeClass("active-block");
        $(this).closest(".hide-this-submit-block").prev(".hide-this-submit-block").addClass("active-block");
        step.removeClass("active-step");
        step = step.prev('li');
        // console.log(step)         
    };

    $(".previous-tab").on("click", previousTab);
    $(".next-tab").on("click", nextTab);


    var postTab1 = function (e) {
        e.preventDefault();
        // var response = grecaptcha.getResponse();
        var sendObj = {};

        sendObj.name = $('#yourName').val();
        sendObj.companyName = $('#companyName').val();
        sendObj.email = $('#yourMail').val();
        sendObj.phone = $('#yourPhone').val();
        if ($('#register-form').valid()) {
            // if(response.length == 0) {
            //     alert('captcha')
            // } else {
                $.post("/_ico/get-buyer-data", sendObj, function (data) {
                var parsedData = JSON.parse(data);
                buyerId = parsedData.buyerId;
                console.log(parsedData)
                if (parsedData.status === "success") {
                    nextTab('#firstTab');
                }else if(parsedData.status === "error"){
                     var errorData = parsedData.message;
                }
                }).fail(function (response) {
                    alert('Error: ' + response.responseText);
                });
            // }
                
        }            
        
    };

    $('#register-form').on("submit", postTab1);

    var informationSocials = [];
    var secondTabId = null;
    var friendlyUrl = function(str){
        str = str.trim().toLowerCase();
        str = str.replace(/\s+/g, ' ');
        str = str.replace(/\s/g, '-');
        str = str.replace(/[^A-Za-z0-9\-]/gim, '');
        return str;
    };

    $('#informationFile').on("change", function() {
        var screen = $(this)[0].files[0];
        $('.add-file-block .upload-text').html(screen.name);
    });


    var postTab2 = function (e) {
        e.preventDefault();
        var sendObj = {};

        var title = $('#icoName').val();
        sendObj.title = title;
        sendObj.short_description = $('#description').val();
        sendObj.friendly_url = friendlyUrl(title);        
        sendObj.money_id = $('#selectCoinName').val();
        sendObj.short_money_id = $('#shortCoinName').val();
        sendObj.total_supply = $('#totalSupply').val();
        sendObj.number_coins = $('#numberOfCoins').val();
        sendObj.data_start = $('#startDate').val();
        sendObj.data_end = $('#endDate').val();
        sendObj.link_website = $('#website').val();
        sendObj.link_whitepaper = $('#whitepaper').val();
        sendObj.image = $('#informationFile')[0].files[0];
        sendObj.links_array = informationSocials;
        var fdSendObj = new FormData();

        if ($('#selectIndustry').val() == 'null') {
            sendObj.ico_category = null;
            sendObj.other_category = $('#myIndustry').val();
        } else {
            sendObj.other_category = null;
            sendObj.ico_category = $('#selectIndustry').val()
        }
        if ($('#selectPlatform').val() == 'null') {
            sendObj.ico_platform = null;
            sendObj.other_platform = $('#myPlatform').val();
        } else {
            sendObj.other_platform = null;
            sendObj.ico_platform = $('#selectPlatform').val();
        }


        fdSendObj.append('title', sendObj.title);
        fdSendObj.append('short_description', sendObj.short_description);
        fdSendObj.append('friendly_url', sendObj.friendly_url);
        fdSendObj.append('ico_category', sendObj.ico_category);
        fdSendObj.append('ico_platform', sendObj.ico_platform);
        fdSendObj.append('other_category', sendObj.other_category);
        fdSendObj.append('other_platform', sendObj.other_platform);
        fdSendObj.append('money_id', sendObj.money_id);
        fdSendObj.append('short_money_id', sendObj.short_money_id);
        fdSendObj.append('total_supply', sendObj.total_supply);
        fdSendObj.append('number_coins', sendObj.number_coins);
        fdSendObj.append('data_start', sendObj.data_start);
        fdSendObj.append('data_end', sendObj.data_end);
        fdSendObj.append('link_website', sendObj.link_website);
        fdSendObj.append('link_whitepaper', sendObj.link_whitepaper);
        fdSendObj.append('image', sendObj.image);
        fdSendObj.append('links_array', JSON.stringify(sendObj.links_array));
        fdSendObj.append('buyer_id', buyerId)
        // console.log(fdSendObj);
        // console.log(fdSendObj.has('image'));
       
    if ($('#ico-information').valid()) {
        $.ajax({
               url : '/_ico/get-info',
               type : 'POST',
               data : fdSendObj,
               processData: false,  // tell jQuery not to process the data
               contentType: false,  // tell jQuery not to set contentType
               success : function(data) {
                    var parsedData = JSON.parse(data);
                    console.log(parsedData)
                    icoId = parsedData.icoId;
                    if (parsedData.status === "success") {
                        nextTab('#secondTab');
                    }else if(parsedData.status === "error"){
                        var errorData = parsedData.message;
                    }
               }
        });
    }
        
    }
    $('#ico-information').on("submit", postTab2);

    // ICO project id get from step2
    // var icoId = '';
    var postTab3 = function (e) {
        e.preventDefault();
        // if(typeof memberInformation !== 'undefined' && memberInformation.length > 0){
            var members = {
                members : memberInformation,
                ico_id : icoId
            };
            $.post("/_ico/get-members", members, function (data) {
                var parsedData = JSON.parse(data);
                if (parsedData.status === "success") {
                    nextTab('#thirdTab');
                }else if(parsedData.status === "error"){
                    var errorData = parsedData.message;
                }

            }).fail(function (response) {
            });
        // }else{
        //     alert("Please add at least one member");
        // }
    };
    $('#thirdTab').on("click", postTab3);

    var renderLink = function (linksArray, listId, deleteCls, deleteFunc) {
        var toRender = '';
        var delcls = '.' + deleteCls;
        if (linksArray.length) {
            $.each(linksArray, function (index, value) {
                toRender += "<li id = " + index + ">" +
                    "<span class = 'link-img'>";
                if (value.network == 'twitter') {
                    toRender += "<img src='"+public_path+"/images/Twitter_Color.png'></span>";
                } else if (value.network == 'linkedin') {
                    toRender += "<img src='"+public_path+"/images/LinkedIN_Color.png'></span>";
                } else if (value.network == 'facebook') {
                    toRender += "<img src='"+public_path+"/images/Facebook_Color.png'></span>";
                } else if (value.network == 'slack') {
                    toRender += "<img src='"+public_path+"/images/slack_47017.png'></span>";
                } else if (value.network == 'instagram') {
                    toRender += "<img src='"+public_path+"/images/instagram.png'></span>";
                } else if (value.network == 'telegram') {
                    toRender += "<img src='"+public_path+"/images/telegram.png'></span>";
                } else if (value.network == 'youtube') {
                    toRender += "<img src='"+public_path+"/images/Youtube.png'></span>";
                } 
                toRender += "<span class='link-url'>" + value.networkLink +
                    "<span class='" + deleteCls + " fa fa-times'></span>";

                $(listId).html(toRender);
            });
        } else {
            $(listId).html('');
        }

        $(delcls).on("click", deleteFunc);
    }

    var deleteLink = function () {
        var elementId = +$(this).closest("li").attr('id');
        informationSocials.splice(elementId, 1);
        renderLink(informationSocials, "#socialsLinksList", 'delete-link', deleteLink);
    }


    var addSocials = function (e) {
        e.preventDefault();
        var oneSocial = {};
        oneSocial.network = $("#social").val();
        oneSocial.networkLink = $("#socialLink").val();
        if (oneSocial.networkLink) {
            informationSocials.push(oneSocial);
            $("#socialLink").val('');
        }
        renderLink(informationSocials, "#socialsLinksList", 'delete-link', deleteLink);
    }

    $("#addLinkButton").on("click", addSocials);


// Add Your Team Members tab
    var memberSocialsLinks = [];
    var memberInformation = [];

    var memberDeleteLink = function () {
        var elementId = +$(this).closest("li").attr('id');
        memberSocialsLinks.splice(elementId, 1);
        renderLink(memberSocialsLinks, "#memberSocialList", 'member-delete-link', memberDeleteLink);
    }

    var addMemberSocials = function (e) {
        e.preventDefault();
        var oneSocial = {};
        oneSocial.network = $("#memberSocial").val();
        oneSocial.networkLink = $("#memberSocialLink").val();
        if (oneSocial.networkLink && (!memberSocialsLinks[0] || memberSocialsLinks[0].network != oneSocial.network) && memberSocialsLinks.length < 2) {
            memberSocialsLinks.push(oneSocial);
            $("#memberSocialLink").val('');
        }
        renderLink(memberSocialsLinks, "#memberSocialList", 'member-delete-link', memberDeleteLink);
    }

    var renderMember = function () {
        var toRender = '';
        if (memberInformation.length) {
            $.each(memberInformation, function (index, value) {
                toRender += "<tr id = " + index + ">" +
                    "<td>" + value.fullName + "</td>" +
                    "<td>" + value.position + "</td>" +
                    "<td><span>";
                if (value.twitter && value.linkedin) {
                    toRender += "<img src='"+public_path+"/images/Twitter_Color.png'></span>";
                    toRender += "<img src='"+public_path+"/images/LinkedIN_Color.png'></span>";
                } else if (value.linkedin) {
                    toRender += "<img src='"+public_path+"/images/LinkedIN_Color.png'></span>";
                } else if (value.twitter) {
                    toRender += "<img src='"+public_path+"/images/Twitter_Color.png'></span>";
                }
                toRender += "</td>" +
                    "<td><span class='delete-link member-delete fa fa-times'></span></td>" +
                    "</tr>";

                $('#memberTableList').html(toRender);
            });
        } else {
            $('#memberTableList').html('');
        }
        $('.member-delete').on("click", deleteMember);
    }

    var deleteMember = function () {
        var elementId = +$(this).closest("tr").attr('id');
        memberInformation.splice(elementId, 1);
        renderMember();
    }

    $("#addMemberLinkButton").on("click", addMemberSocials);

    var addMember = function (e) {
        e.preventDefault();
        var oneMember = {};
        oneMember.fullName = $("#memberFullName").val();
        oneMember.position = $("#memberPosition").val();

        for (var i = 0; i < memberSocialsLinks.length; i++) {
            if (memberSocialsLinks[i].network == 'twitter') {
                oneMember.twitter = memberSocialsLinks[i].networkLink;
            } else if (memberSocialsLinks[i].network == 'linkedin') {
                oneMember.linkedin = memberSocialsLinks[i].networkLink;
            }
        }
        if (oneMember.fullName && oneMember.position/* && memberSocialsLinks.length*/) {
            memberInformation.push(oneMember);
            memberSocialsLinks = [];
            $("#memberFullName").val('');
            $("#memberPosition").val('');
            renderLink(memberSocialsLinks, "#memberSocialList", 'member-delete-link', memberDeleteLink);
        }
        renderMember();
    }

    $('#addMember').on("click", addMember);


// change medal
    var medalValue = 'normal';
    var paymentData = '';
    var changedPayment = '';

    var renderPayment = function() {
        $('.medal-silver .price-value').html(changedPayment.options.silver);
        $('.medal-silver .btc').html(' ' + changedPayment.shortName.toUpperCase());
        $('.medal-gold .price-value').html(changedPayment.options.gold);
        $('.medal-gold .btc').html(' ' + changedPayment.shortName.toUpperCase());
        $('.basic-listing').html(changedPayment.options.normal + ' '+ changedPayment.shortName.toUpperCase());
        $('.total-price .item-price').html(changedPayment.options.normal + ' '+ changedPayment.shortName.toUpperCase());
        
    }

    $('input[type=radio][name=paymentType]').change(function() {
        $('.main-summary-list .changed-medal').remove();
        $('.check').hide();
        $('.medal-silver').removeClass("active");
        $('.medal-gold').removeClass("active");
        medalValue = 'normal';
        if (this.value == 'bitcoin') {
            changedPayment = paymentData.bitcoin;            
        }
        else if (this.value == 'ethereum') {
            changedPayment = paymentData.ethereum;
        }
        renderPayment();
    });



    function getPaymentData() {       
        
            $.post("/_ico/get-payment-types", function (data) {
            paymentData = JSON.parse(data);
            changedPayment = paymentData.bitcoin;
            renderPayment();
            }).fail(function (response) {
                alert('Error: ' + response.responseText);
            });      
    };
    getPaymentData();



    
    $('.medal').on("click", function () {
        var medalGoldPrice = changedPayment.options.gold;
        var medalSilverPrice = changedPayment.options.silver;
        var basicPrice = changedPayment.options.normal;
        var shortCoinName = changedPayment.shortName;
        if ($(this).hasClass('medal-silver')) {
            if (!($('.check-silver').css('display') == 'none' )) {
                $('.check').hide();
                medalValue = 'normal';
                $('.main-summary-list .changed-medal').remove();
                $('.summary-list.total-price .item-price').html(basicPrice + ' ' + shortCoinName.toUpperCase());
            } else {
                $('.main-summary-list .changed-medal').remove();
                $('.check').hide();
                $('.check-silver').show();
                medalValue = 'silver';
                var elLi = $('<li />', {
                    "class": 'changed-medal',
                });
                var medalName = $('<span />', {
                    "class": 'summary-text',
                    text: "Silver medal"
                });
                var price = $('<span />', {
                    "class": 'item-price',
                    text: medalSilverPrice + ' ' + shortCoinName.toUpperCase()
                });
                $('.main-summary-list').append(elLi.append(medalName).append(price));
                $('.summary-list.total-price .item-price').html(+(basicPrice + medalSilverPrice).toFixed(7) + ' ' + shortCoinName.toUpperCase());
            }

        } else {
            if (!($('.check-gold').css('display') == 'none' )) {
                $('.check').hide();
                medalValue = 'normal';
                $('.main-summary-list .changed-medal').remove();
                $('.summary-list.total-price .item-price').html(basicPrice + ' ' + shortCoinName.toUpperCase());
            } else {
                $('.main-summary-list .changed-medal').remove();
                $('.check').hide();
                $('.check-gold').show();
                medalValue = 'gold';
                var elLi = $('<li />', {
                    "class": 'changed-medal',
                });
                var medalName = $('<span />', {
                    "class": 'summary-text',
                    text: "Gold medal"
                });
                var price = $('<span />', {
                    "class": 'item-price',
                    text: medalGoldPrice + ' ' + shortCoinName.toUpperCase()
                });
                $('.main-summary-list').append(elLi.append(medalName).append(price));
                $('.summary-list.total-price .item-price').html(+(basicPrice + medalGoldPrice).toFixed(7) + ' ' + shortCoinName.toUpperCase());
            }
        }
        if (medalValue == 'gold') {
            $('.medal-silver').removeClass("active");
            $('.medal-gold').addClass("active");
        } else if (medalValue == 'silver') {
            $('.medal-gold').removeClass("active");
            $('.medal-silver').addClass("active");
        } else {
            $('.medal-silver').removeClass("active");
            $('.medal-gold').removeClass("active");
        }

    });

    // copy link to clipboard    
   $('#copyLink').on("click", function () {   
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($('#paymentLinkInput').val()).select();
        document.execCommand("copy");
        $temp.remove();
   });
    
    var postTab4 = function (e) {
        e.preventDefault();
        var objToSend = {};
        if (medalValue == 'gold') {
            objToSend.total_coast = +(+changedPayment.options.normal + +changedPayment.options.gold).toFixed(7); 
        } else if (medalValue == 'silver') {
            objToSend.total_coast = +(+changedPayment.options.normal + +changedPayment.options.silver).toFixed(7); 
        } else if (medalValue == 'normal') {
            objToSend.total_coast = +changedPayment.options.normal.toFixed(7);
        }
        objToSend.buyer_id = buyerId;
        objToSend.ico_id = icoId;
        objToSend.payment_type_id = changedPayment.priceId;
        objToSend.payment_option = medalValue;
        
            
                $.post("/_ico/get-deal", objToSend, function (data) {
                var parsedData = JSON.parse(data);
                if (parsedData.status === "success") {
                    $('#paymentLinkInput').val(changedPayment.link);
                    $('.total-price-confirm').html(objToSend.total_coast + ' ' + changedPayment.shortName.toUpperCase());
                    nextTab('#fourTab');
                }else if(parsedData.status === "error"){
                    var errorData = parsedData.message;
                }

                }).fail(function (response) {
                    alert('Error: ' + response.responseText);
                });
                    
    };
    $('#fourTab').on("click", postTab4);

    $('#uploadScreen').on("change", function() {
        $('.upload-screenshot').hide();
        var screen = $(this)[0].files[0];
        $('.file-info .file-name').html(screen.name);
        $('.file-info').show();
    });

    $('.delete-file').on('click', function(){
        $('.upload-screenshot').show();
        document.getElementById("uploadScreen").value = "";
        $('.file-info').hide();
    })


    var postTab5 = function (e) {
        e.preventDefault();
            var fdSendObj = new FormData();
            var screen = $('#uploadScreen')[0].files[0];
            fdSendObj.append('screenshot', screen);
            $.ajax({
               url : '/_ico/upload-screenshot',
               type : 'POST',
               data : fdSendObj,
               processData: false,  // tell jQuery not to process the data
               contentType: false,  // tell jQuery not to set contentType
               success : function(data) {
                    var parsedData = JSON.parse(data);
                    if (parsedData.status === "success") {
                        $.post("/_ico/send-buyer-email", function (data) {
                            nextTab('#fifthTab');
                        });
                    } else if(parsedData.status === "error"){
                        var errorData = parsedData.message;
                        console.log(errorData);
                    }
               }
        });
            
        
    };
    $('#fifthTab').on("click", postTab5);


// end of ready function
})
