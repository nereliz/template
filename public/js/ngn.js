//****************************************************************************
// Alert message functions
//*


$( 'document' ).ready( function(){
    // A good percentage of pages will have message boxes - this activates them all
    $(".alert-message").alert();
    $( ".alert" ).alert();
    
    $( ".have-tooltip" ).tooltip( { html: true, delay: { show: 300, hide: 100  } } );
    
    $( "input:radio.radio-inline" ).each( function( item ){   
          var parent = $( this ).parent();
          if( parent.is( 'label' ) && !parent.hasClass( "radio-inline" ) )
              parent.addClass( "radio-inline" );
    });
    
    $( "input:radio.radio" ).each( function( item ){
        var parent = $( this ).parent();
        if( parent.parent().is( 'div' ) && !parent.parent().hasClass( "radio" ) ) {
            parent.parent().append( '<div class="radio"><labe>' + parent.html() + '</label></dv>' );
            parent.remove();
        }
    });
    
    $( "input:checkbox.checkbox-inline" ).each( function( item ){   
          var parent = $( this ).parent();
          if( parent.is( 'label' ) && !parent.hasClass( "checkbox-inline" ) )
              parent.addClass( "checkbox-inline" );
    });
    
    $( "input:checkbox.checkbox" ).each( function( item ){
        var parent = $( this ).parent();
        if( parent.parent().is( 'div' ) && !parent.parent().hasClass( "checkbox" ) ) {
            parent.parent().append( '<div class="checkbox"><labe>' + parent.html() + '</label></dv>' );
            parent.remove();
        }
    });
    
    $( "select.asm-select" ).asmSelect({
      sortable: true,
      animate: true,
      addItemTarget: 'bottom',
      removeLabel: '<span class="glyphicon glyphicon-trash"></span>'
    });
    
    $( "select.chosen" ).each( function( item ){
        if( $( this ).is( ":visible" ) )
          $( this ).chosen();
        else
          $( this ).chosen({width: "100\%"});
    });
    
    $( ".with-popover" ).each( function( item ){
        $( this ).popover();
    });
    
    
});

function genPassword(n){
  if( n === undefined ) n = 16;
  
  var value = "";
  for( i=0; i<n; i++ )
    value += "abcdefhjmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWYXZ". charAt( Math.floor( Math.random() * 53 ) );
  
  return value;
}


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


/* Set the defaults for DataTables initialisation */
$.extend( true, $.fn.dataTable.defaults, {
"sDom": "<'row'<'col-6'l><'col-6'f>r>t<'row'<'col-6'i><'col-6'p>>",
"sPaginationType": "bootstrap",
"oLanguage": {
"sLengthMenu": "_MENU_ records per page"
}
} );
/* Default class modification */
$.extend( $.fn.dataTableExt.oStdClasses, {
"sWrapper": "dataTables_wrapper form-inline input-small"
} );
/* API method to get paging information */
$.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
{
return {
"iStart": oSettings._iDisplayStart,
"iEnd": oSettings.fnDisplayEnd(),
"iLength": oSettings._iDisplayLength,
"iTotal": oSettings.fnRecordsTotal(),
"iFilteredTotal": oSettings.fnRecordsDisplay(),
"iPage": oSettings._iDisplayLength === -1 ?
0 : Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
"iTotalPages": oSettings._iDisplayLength === -1 ?
0 : Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
};
};
/* Bootstrap style pagination control */
$.extend( $.fn.dataTableExt.oPagination, {
"bootstrap": {
"fnInit": function( oSettings, nPaging, fnDraw ) {
var oLang = oSettings.oLanguage.oPaginate;
var fnClickHandler = function ( e ) {
e.preventDefault();
if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
fnDraw( oSettings );
}
};
$(nPaging).append(
'<ul class="pagination">'+
'<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
'<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
'</ul>'
);
var els = $('a', nPaging);
$(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
$(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
},
"fnUpdate": function ( oSettings, fnDraw ) {
var iListLength = 5;
var oPaging = oSettings.oInstance.fnPagingInfo();
var an = oSettings.aanFeatures.p;
var i, ien, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);
if ( oPaging.iTotalPages < iListLength) {
iStart = 1;
iEnd = oPaging.iTotalPages;
}
else if ( oPaging.iPage <= iHalf ) {
iStart = 1;
iEnd = iListLength;
} else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
iStart = oPaging.iTotalPages - iListLength + 1;
iEnd = oPaging.iTotalPages;
} else {
iStart = oPaging.iPage - iHalf + 1;
iEnd = iStart + iListLength - 1;
}
for ( i=0, ien=an.length ; i<ien ; i++ ) {
// Remove the middle elements
$('li:gt(0)', an[i]).filter(':not(:last)').remove();
// Add the new list items and their event handlers
for ( j=iStart ; j<=iEnd ; j++ ) {
sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
$('<li '+sClass+'><a href="#">'+j+'</a></li>')
.insertBefore( $('li:last', an[i])[0] )
.bind('click', function (e) {
e.preventDefault();
oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
fnDraw( oSettings );
} );
}
// Add / remove disabled classes from the static elements
if ( oPaging.iPage === 0 ) {
$('li:first', an[i]).addClass('disabled');
} else {
$('li:first', an[i]).removeClass('disabled');
}
if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
$('li:last', an[i]).addClass('disabled');
} else {
$('li:last', an[i]).removeClass('disabled');
}
}
}
}
} );
/*
* TableTools Bootstrap compatibility
* Required TableTools 2.1+
*/
if ( $.fn.DataTable.TableTools ) {
// Set the classes that TableTools uses to something suitable for Bootstrap
$.extend( true, $.fn.DataTable.TableTools.classes, {
"container": "DTTT btn-group",
"buttons": {
"normal": "btn",
"disabled": "disabled"
},
"collection": {
"container": "DTTT_dropdown dropdown-menu",
"buttons": {
"normal": "",
"disabled": "disabled"
}
},
"print": {
"info": "DTTT_print_info modal"
},
"select": {
"row": "active"
}
} );
// Have the collection use a bootstrap compatible dropdown
$.extend( true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
"collection": {
"container": "ul",
"button": "li",
"liner": "a"
}
} );
}