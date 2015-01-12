jQuery(function() {				
	// *********************************
	// FUNCION PARA CALCULAR EL IMC
	// *********************************
	function calcularIMC( peso , altura , sistema_metrico){
		
		// ******************
		// SISTEMA METRICO
		// ******************
		if ( sistema_metrico == "Metrico" || sistema_metrico == "metric" ) {
			var altura = altura / 100;
			var imc = peso / ( altura * altura );
			if(!imc){
				imc = "Datos inv&aacute;lidos";
			} 
			else{
				imc = Math.round(imc*100)/100;
			}
		}
		// ******************
		
		// ******************
		// SISTEMA IMPERIAL
		// ******************
		else if (sistema_metrico == "Imperial") {
			var imc = ( peso / ( altura * altura ) ) * 703;
			
			if(!imc){
				imc = "Datos inv&aacute;lidos";
			} 
			else{
				imc = Math.round(imc*100)/100;
			}
		}
		// ******************
						
		// ***********************
		// AGREGA EL RESULTADO 
		// ***********************
		jQuery("#resultadoimc").html(imc);
		// ***********************
		
		// *********************************
		// QUITA CUALQUIER CLASE PRESENTE 
		// *********************************
		jQuery("#SuIMC").removeClass();
		// *********************************
		
		// ***************************************************************
		// AGREGA LAS CLASE DE COLOR DEPENDIENDO DEL RESULTADO
		// ***************************************************************
		if ( imc < 16 || imc >= 30 ) {
			jQuery("#SuIMC").addClass("rojo");
		}	
		
		else if ( (imc >= 16 && imc < 18.5) || (imc > 25 && imc < 30) ) {
			jQuery("#SuIMC").addClass("amarillo");
		}
		
		else if ( imc >= 18.5 && imc <= 25 ) {
			jQuery("#SuIMC").addClass("verde");
		}
		// ***************************************************************
	}
	// ***************************************************************
	
	// *********************************************************************
	// LIMITA LOS DECIMALES EN LAS CASILLAS DE PESO Y ESTATURA
	// *********************************************************************
	jQuery("#peso").maskMoney({thousands:',', decimal:'.', allowZero: false, });
	jQuery("#altura").maskMoney({thousands:',', decimal:'.', allowZero: false, });
	// *********************************************************************


	// *********************************************************************
	// TOMA CONTROL DEL FORMULARIO
	// *********************************************************************
	jQuery( "#CalculoIMC" ).submit(function( event ) {
		event.preventDefault();
		
		calcularIMC( jQuery('#peso').val() , jQuery('#altura').val() , jQuery('#sistema_metrico').val()  ); 
		jQuery('#IMC').show();
		jQuery('#Tabla_IMC').show();
		jQuery('#SuIMC').show();
	});					
	// *********************************************************************
	
});
