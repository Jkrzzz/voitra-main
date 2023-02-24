$(document).ready(function () {
    function copy(text, target) {
        $(target).append("<div class='tip' id='copied_tip'>コピーしました</div>");
        let input = document.createElement('input');
        input.setAttribute('value', text);
        document.body.appendChild(input);
        input.select();
        let result = document.execCommand('copy');
        document.body.removeChild(input)
        return result;
    }
    $('.copy-coupon-code').click(function() {
        const copy_coupon_code = $(this)
        const text = $(this).attr('data-copy')
        setTimeout(function() {
            $(copy_coupon_code).tooltip('dispose');
        }, 2000);
        $(copy_coupon_code).tooltip('show')
        let input = document.createElement('input');
        input.setAttribute('value', text);
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input)
    })
    var max_height = 0;
    $('.coupon-quantity').each(function(){
        if(max_height < $(this).height()){
            max_height = $(this).height();
        }
    })
    $('.coupon-quantity').css('height', `${max_height}px`)

});
