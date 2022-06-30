function isArabic(element){
    var arabic_name = $(element).val();
    var arabic = /[\u0600-\u06FF]/;
    if(arabic_name && !arabic.test(arabic_name)){
        $(element).val('');
        $(element).focus();
        $(element).next().text('Enter Name in Arabic')
    } else {
        $(element).next().text('');
    }
}