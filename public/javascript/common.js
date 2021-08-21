if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href )
}

$(function(){
    $(".date").datepicker({ dateFormat: 'yy-mm-dd' });
});
