//****************************************************************************
// Alert message functions
//*

$( 'document' ).ready( function(){
    // A good percentage of pages will have message boxes - this activates them all
    $(".alert-message").alert();
    $( ".alert" ).alert();
    
    $( ".have-tooltip" ).tooltip( { html: true, delay: { show: 300, hide: 100  } } );
});


//****************************************************************************
// Chosen Functions
//****************************************************************************

$( 'document' ).ready( function(){

    $(".chzn-select").each( function( index ){
        $( this ).chosen();
        chosenFixWidth( $( this ) );
    });
                            
    $(".chzn-select-deselect").each( function( index ) {
        $( this ).chosen( { allow_single_deselect:true } );
        cosenFixWidth( $( this ) );
     });
});
                                                    
//See https://github.com/harvesthq/chosen/issues/92 for:
function chosenFixWidth( obj, force ) {
    if( ( force != undefined && force == true ) || obj.attr( 'chzn-fix-width' ) === '1' ) {
        czn_id = "#" + obj.attr( "id" ) + "_chzn";
        width = parseInt( obj.css( "width" ) );
                                    
        if( $( czn_id ).length == 0 )
        czn_id = czn_id.replace( /\-/g, "_" );

        $( czn_id ).css( "width", width + "px" );
    }
}

// clear a chosen dropdown
function chosenClear( id ) {
    $( id ).html( "" ).val( "" );
    $( id ).trigger( "liszt:updated" );
}

//clear a chosen dropdown with a placeholder
function chosenClear( id, ph ) {
    $( id ).html( ph ).val( "" );
    $( id ).trigger( "liszt:updated" );
}

// set a chosen dropdown
function chosenSet( id, options, value ) {
    $( id ).html( options );

    if( value != undefined )
    $( id ).val( value );

    $( id ).trigger( "liszt:updated" );
}
                                    
                                    