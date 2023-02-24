$(document).ready(function () {
    const dtToday = new Date();

    let month = dtToday.getMonth() + 1;
    let day = dtToday.getDate();
    let year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();

    const maxDate = year + '-' + month + '-' + day;

    // or instead:
    // var maxDate = dtToday.toISOString().substr(0, 10);
    $('#start_at').attr('min', maxDate);
    $('#end_at').attr('min', maxDate);

    $('#quantity').inputFilter(function(value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) > 0);});
    $('#discount_amount').inputFilter(function(value) {
        return /^\d*$/.test(value)&& (value === "" || parseInt(value) > 0);});

    $("textarea:disabled").height( $("textarea")[0].scrollHeight );
    $('[data-toggle="tooltip"]').tooltip()
});
