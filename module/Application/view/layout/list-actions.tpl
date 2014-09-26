<script>

$( "a[id|='list-remove']" ).on( 'click', function( event ){
    event.preventDefault();
    bootbox.dialog({
        message: "{t}Are you shure you want to delete selected object?{/t}",
        title: "{t}Are you shure?{/t}",
        buttons: {
            danger: {
                label: "{t}Remove{/t}",
                className: "btn-danger",
                callback: function() { 
                    window.location = $( event.delegateTarget ).attr( "href" );
                }
            },
            main: {
                label: "{t}Cancel{/t}",
                className: "btn-default",
            }
        }
    });
});

</script>