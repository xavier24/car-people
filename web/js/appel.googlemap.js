( function ( $ ) {
	"use strict";

	// --- global vars
            var baseUrl = location.origin,
                villes,
                depart_lat ,
                depart_lng ,
                arrivee_lat ,
                arrivee_lng ,
                input_place,
                input_distance,
                input_consomme,
                input_carbu;
            var accentMap = {"á": "a", "é": "e", "è": "e", "ê": "e", "ë": "e", "ï": "i", "î": "i", "ö": "o", "ô": "o", "û": "u", "ü": "u" };
	// --- methods
            
            var normalize = function( term ) {
                var ret = "";
                for ( var i = 0; i < term.length; i++ ) {
                    ret += accentMap[ term.charAt(i) ] || term.charAt(i);
                }
                return ret;
            };
            
            var init = function(){
                if($('#ajouter_annonce')){ //AJOUTER ANNONCE
                    
                    maps();
                    ajouterMaps();
                }
            }
            
            var ajouterMaps = function(){
                
                $.ajax({
                    url:baseUrl+'/PFE-CodeIgniter/ajax/villes',
                    type:'POST',
                    success: function($data){
                        villes = $.parseJSON($data);

                        $( "#input_depart" ).autocomplete({
                            source: function( request, response ) {
                                var matcher = new RegExp( $.ui.autocomplete.escapeRegex( request.term ), "i" );
                                response( $.grep( villes, function( value ) {
                                    value = value.label || value.value || value;
                                    return matcher.test( value ) || matcher.test( normalize( value ) );
                                }) );
                            },
                            select: function (event, ui) {  $('#input_departID').val(ui.item.id);
                                                            $('#input_depart_lat').val(ui.item.lat);
                                                            $('#input_depart_lng').val(ui.item.lng);
                                                            depart_lat = ui.item.lat;
                                                            depart_lng = ui.item.lng;
                                                            maps();
                                                    }
                        });


                        $( "#input_arrivee" ).autocomplete({
                            source: function( request, response ) {
                                var matcher = new RegExp( $.ui.autocomplete.escapeRegex( request.term ), "i" );
                                response( $.grep( villes, function( value ) {
                                    value = value.label || value.value || value;
                                    return matcher.test( value ) || matcher.test( normalize( value ) );
                                }) );
                            },
                            select: function (event, ui) {  $('#input_arriveeID').val(ui.item.id);
                                                        $('#input_arrivee_lat').val(ui.item.lat);
                                                        $('#input_arrivee_lng').val(ui.item.lng);
                                                        arrivee_lat = ui.item.lat;
                                                        arrivee_lng = ui.item.lng;
                                                        maps();
                                                    }
                        });

                        $(document).on('click', ".input_etape" ,function(){
                            $(this).autocomplete({
                                source: function( request, response ) {
                                    var matcher = new RegExp( $.ui.autocomplete.escapeRegex( request.term ), "i" );
                                    response( $.grep( villes, function( value ) {
                                        value = value.label || value.value || value;
                                        return matcher.test( value ) || matcher.test( normalize( value ) );
                                    }) );
                                },
                                select: function (event, ui) {  $(this).parent().find('.input_etapeID').val(ui.item.id);
                                                            $(this).parent().find('.input_etape_lat').val(ui.item.lat);
                                                            $(this).parent().find('.input_etape_lng').val(ui.item.lng);
                                                            maps();
                                                        }
                            });
                        });

                    }
                });
                    
            }
                        
            var maps = function(){
            
                if(depart_lat && depart_lng && arrivee_lat && arrivee_lng){

                    var etape = $(".etape");
                    var etapes = new Array();
                    var Waypoints = true;
                    etape.each(function(){
                       if($(this).find('.input_etape').val() != ""){
                            var value = $(this).find('.input_etape').val();
                            var stop = false;
                            if($(this).find(".input_stop").is(':checked')){
                                stop = true;
                            }
                            etapes.push({location:value,stopover:stop});
                       }
                    });
                    if(etapes.length == 0){
                        Waypoints = false;
                    }
                    $("#map").googleMap();
                    $("#map").addWay({
                        start: [depart_lat, depart_lng], // Adresse postale du départ (obligatoire)
                        waypoints: etapes,
                        optimizeWaypoints: Waypoints,
                        end:  [arrivee_lat, arrivee_lng], // Coordonnées GPS ou adresse postale d'arrivée (obligatoire)
                        route : 'way', // ID du bloc dans lequel injecter le détail de l'itinéraire (optionnel)
                        langage : 'french' // Langue du détail de l'itinéraire (optionnel, en anglais)
                    }) ;
                    
                    calculPrix();
                }

            }
            
            var calculPrix = function(){
                var distance = input_distance.val();
                var consomme = input_consomme.val();
                var carbu = input_carbu.val();
                var places = parseInt(input_place.val())+1;
                if(places<3){
                    places = 3;
                }
                console.log(places);
                var calcPrix = distance/100000*consomme*carbu/places;
                var prix = Math.round(calcPrix);
                $("#prix").text(prix+"€");
                $("#input_prix").val(prix);
                $("#input_prix_conseil").val(prix);
            }
        
	$( function () {

            // --- onload routines
                depart_lat = $("#input_depart_lat").val();
                depart_lng = $("#input_depart_lng").val();
                arrivee_lat = $("#input_arrivee_lat").val();
                arrivee_lng = $("#input_arrivee_lng").val();
                input_distance = $("#input_distance");
                input_consomme = $("#input_consomme");    
                input_carbu = $("#input_carbu");
                input_place = $("#input_places");
             
            // --- events
                $("#recalculer_trajet").on('click',maps);    
                input_place.on("change",calculPrix);
                $("#recalculer_prix").on('click',calculPrix);
                input_distance.on('change',calculPrix); 
              
            // --- execute
                init();
                 
                
                
            // --- Appel function externe
            
            
        } );
        
}( jQuery ) );
 
    