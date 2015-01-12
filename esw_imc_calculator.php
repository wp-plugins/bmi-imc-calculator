<?php
/*
Plugin Name: IMC Calculator
Plugin URI: http://estoesweb.com
Description: A simple calculator to determine a person IMC
Version: 1.1
Author: Carlos Carmona
Author URI: http://estoesweb.com
License: GPL2
*/

if (!defined('ESW_PLUGIN_NAME'))
    define('ESW_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('ESW_PLUGIN_URL'))
    define('ESW_PLUGIN_URL', WP_PLUGIN_URL . '/' . ESW_PLUGIN_NAME);

if (!defined('ESW_VERSION_KEY'))
    define('ESW_VERSION_KEY', 'myplugin_version');

if (!defined('ESW_VERSION_NUM'))
    define('ESW_VERSION_NUM', '1.1');

add_option(ESW_VERSION_KEY, ESW_VERSION_NUM);

if ( ! defined( 'ABSPATH' ) ) exit;

// ************************************
// STYLES Y SCRIPTS
// ************************************
add_action( 'wp_enqueue_scripts', 'esw_imccalculator_frontend_scripts_and_styles' );
function esw_imccalculator_frontend_scripts_and_styles() {
    if ( !is_admin() ) {	    
	    wp_register_style( 'esw_imc_style' , ESW_PLUGIN_URL . '/includes/css/style.css' );
	    wp_register_style( 'esw_imc_table' , ESW_PLUGIN_URL . '/includes/css/table.css' );
	    wp_register_style( 'esw_fontello' , ESW_PLUGIN_URL . '/includes/css/fontello.css' , array() , ESW_VERSION_NUM , 'all' );
	   
	    wp_register_script('esw_maskMoney' , ESW_PLUGIN_URL . '/includes/js/jquery.maskMoney.js' , array('jquery'), '1.0.0', true );
	    wp_register_script('esw_imc' , ESW_PLUGIN_URL . '/includes/js/imc.js' , array('esw_maskMoney'), '1.0.0', true );
		}
		
	}
// ************************************

// ************************************
// ARCHIVOS DE TRADUCCION
// ************************************
add_action('init', 'esw_action_init');
function esw_action_init() {
	load_plugin_textdomain('esw_imc_calculator',false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
// ************************************

// ************************************
// FUNCION QUE MUESTRA LA CALCULADORA
// ************************************
add_action( 'mostrar_bmi_calculator', 'mostrar_bmi_calculator' );
function mostrar_bmi_calculator( $atts ) { 
	$idioma = get_bloginfo('language');	
	
	extract($atts);
	
	//********************************
	// Carga el estilo y script
	//********************************
	wp_enqueue_script( 'esw_maskMoney' );
	wp_enqueue_script( 'esw_imc' );
	
	wp_enqueue_style( 'esw_imc_style' );
	wp_enqueue_style( 'esw_fontello' );
	
	if (!$hide_styles)
		wp_enqueue_style( 'esw_imc_table' );
	
	if ( $system_type == "Metrico" || $system_type == "metric" ):
		$peso = "KG";
		$altura = "CM";
	elseif ( $system_type == "Imperial" ):
		$peso = "LB";
		$altura = "IN";
	endif; ?> 

	<style>
		<?php if ($hide_table): ?>
			#Tabla_IMC {display:none};
		<?php endif; ?>
		
		<?php if (!$hide_header): ?>
			.TituloSeccion {background:transparent url("<?php echo ESW_PLUGIN_URL ?>/includes/images/header_background_1.png") no-repeat scroll 0px 0px; background-size: 100%; height:100px;} 
			.TituloSeccion h4 {color:#FFF !important;padding: 10px;}
		<?php endif; ?>
	</style>
	

	<?php if ($is_shortcode): ?>
	<div class="TituloSeccion" id="SeccionIMC">
		<span>
			<h4>
				<?php if ( !empty( $section_title ) )
					echo $section_title; ?>
			</h4>
		</span>
	</div>
	<?php endif; ?>
		
	<form id="CalculoIMC">
		<input name="sistema_metrico" id="sistema_metrico" type="hidden" value="<?php echo $system_type ?>" >
		
		<i class="icon-gauge"></i>
		<input name="peso" id="peso" type="text" min="1" step="any" placeholder="<?php _e('Peso', 'esw_imc_calculator'); ?>" maxlength="6"  required>
		<label for="peso"><?php echo $peso ?></label>
		
		<br>
		
		<i class="icon-text-height"></i>
		<input name="altura" id="altura" type="text" min="1" step="1" placeholder="<?php _e('Altura', 'esw_imc_calculator'); ?>" maxlength="6" required>
		<label for="altura"><?php echo $altura ?></label>
		
		<br>
		
		<input type="submit" class="calcular" value="<?php _e('Calcular', 'esw_imc_calculator'); ?>"/>
		
		<div id="IMC">
			<div id="SuIMC" style="display:none;">
				<p id="resultado_imc"><?php _e('Su IMC:', 'esw_imc_calculator'); ?> <span id="resultadoimc"></span></p>
			</div>
			
			<table id="Tabla_IMC">
				<col width="50%">
				<col width="50%">
				
				<thead>
					<tr>
						<th><?php _e('Rango IMC', 'esw_imc_calculator'); ?></th>
						<th><?php _e('Categoría', 'esw_imc_calculator'); ?></th>
					</tr>
				</thead>
				
				<tbody>						
					<tr class="rojo">
						<td><?php _e('Menor que 16', 'esw_imc_calculator'); ?></td>
						<td><?php _e('Delgadez severa', 'esw_imc_calculator'); ?></td>
					</tr>
					<tr class="amarillo">
						<td><?php _e('De 16 a 18,5', 'esw_imc_calculator'); ?>:</td>
						<td><?php _e('Delgadez moderada', 'esw_imc_calculator'); ?></td>
					
					</tr>
					<tr class="verde">
						<td><?php _e('De 18,5 a 25', 'esw_imc_calculator'); ?></td> 
						<td><?php _e('Peso normal', 'esw_imc_calculator'); ?></td>
					</tr>

					<tr class="amarillo">
						<td><?php _e('De 25 a 30', 'esw_imc_calculator'); ?></td>
						<td><?php _e('Sobrepeso', 'esw_imc_calculator'); ?></td>
					</tr>
					<tr class="rojo">
						<td><?php _e('De 30 a 35', 'esw_imc_calculator'); ?></td> 
						<td><?php _e('Obesidad Grado I', 'esw_imc_calculator'); ?></td>
					</tr>
					<tr class="rojo-1">
						<td><?php _e('De 35 a 40', 'esw_imc_calculator'); ?>:</td>
						<td><?php _e('Obesidad Grado II', 'esw_imc_calculator'); ?></td>
					</tr>
					<tr class="rojo-2">
						<td><?php _e('Más de 40', 'esw_imc_calculator'); ?></td>
						<td><?php _e('Obesidad Grado III', 'esw_imc_calculator'); ?></td>
					</tr>
				</tbody>
				<?php if (!$ocultar_footer): ?>
				<tfoot>
					<tr>
						<td colspan="2">
							<a <?php if ($idioma == "es-ES"): ?>href="http://es.wikipedia.org/wiki/%C3%8Dndice_de_masa_corporal" <?php else: ?> href="http://es.wikipedia.org/wiki/%C3%8Dndice_de_masa_corporal" <?php endif; ?> target="_blank"><?php _e('Ver más información relacionada', 'esw_imc_calculator'); ?></a>
						</td>
					</tr>
				</tfoot>
				<?php endif; ?>
			</table>
		</div>
	</form>
<?php 
}
// ************************************

// ************************************
// SHORTCODE
// ************************************
add_shortcode("bmi_calculator", "bmi_calculator");
function bmi_calculator( $atts, $content = null ) {
	$atts = shortcode_atts(
				array(
			        'hide_table' 			=> false,
					'system_type' 			=> 'metric',
					'hide_header'			=> false,
					'hide_styles'			=> false,
					'hide_footer'			=> false,
					'section_title'			=> "",
					'is_shortcode'			=> true
				), 
				
				$atts 
			);
		
	do_action( "mostrar_bmi_calculator" , $atts );
}

// ************************************


// ************************************
// CREA EL WIDGET
// ************************************
class IMC_Calculator_wydget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'IMC_Calculator_wydget', // Base ID
			__( 'IMC Calculator', 'esw_imc_calculator' ), // Name
			array( 'description' => __( 'Calculadora para determinar el IMC de un paciente', 'esw_imc_calculator' ), ) // Args
		);
	}
	
	public function widget( $args, $instance ) {   
		$ocultar_tabla 			= $instance['ocultar_tabla'];
		$sistema_metrico		= $instance['select_medidas'];
		$ocultar_header 		= $instance['ocultar_header'];
		$ocultar_estilos_tabla 	= $instance['ocultar_estilos_tabla'];
		$ocultar_footer			= $instance['ocultar_footer'];

		$atts = array(
			"hide_table" 	=> $ocultar_tabla,
			"hide_header"	=> $ocultar_header,
			"system_type"	=> $sistema_metrico,
			"hide_styles"	=> $ocultar_estilos_tabla,
			"hide_footer"	=> $ocultar_footer
		);
	   
		/* CONTENEDOR */
		echo $args['before_widget']; ?>
		
		<?php if (!$hide_header): ?>
		<style>				
			.TituloSeccion {background:transparent url("<?php echo ESW_PLUGIN_URL ?>/includes/images/header_background_1.png") no-repeat scroll 0px 0px; background-size: 100%; height:100px;} 
			.TituloSeccion h4 {color:#FFF !important;padding: 10px;}
		</style>
		<?php endif; ?>
	
		<div class="TituloSeccion" id="SeccionIMC">
			<span>
				<?php
				if ( ! empty( $instance['title'] ) )
					echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];	
				?>
			</span>
		</div>

		<?php 
		do_action( "mostrar_bmi_calculator" , $atts );
			
		echo $args['after_widget'];
	}
	
	public function form( $instance ) {
     	// Check values
		if( $instance):
		    $title 	= esc_attr($instance['title']);
			$sistema_metrico 	= esc_attr($instance['select_medidas']); 
			$ocultar_tabla = esc_attr($instance['ocultar_tabla']); 
			$ocultar_header = esc_attr($instance['ocultar_header']); 
			$ocultar_estilos_tabla = esc_attr($instance['ocultar_estilos_tabla']); ;
			$ocultar_footer = esc_attr($instance['ocultar_footer']); ;

		else:
		    $title = '';
		    $sistema_metrico = '';
		    $ocultar_tabla = '';
		    $ocultar_header = '';
		    $ocultar_estilos_tabla = '';
		    $ocultar_footer = '';
		endif;
		?>
		<!-- *********** -->
		<!-- TITULO -->		
		<!-- *********** -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titulo', 'esw_imc_calculator'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<!-- *********** -->
		
		<!-- ******************* -->
		<!-- SISTEMA METRICO -->		
		<!-- ******************* -->
		<p>
			<label for="<?php echo $this->get_field_id('select_medidas'); ?>"><?php _e('Utilizar medidas', 'esw_imc_calculator'); ?></label>
			<select name="<?php echo $this->get_field_name('select_medidas'); ?>" id="<?php echo $this->get_field_id('select_medidas'); ?>" class="widefat">
				<?php
				$options = array('Metrico', 'Imperial');
				
				foreach ($options as $option) {
					echo '<option value="' . $option . '" id="' . $option . '"', $peso == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				?>
			</select>
			<span style="font-size:10px;"><?php _e('<strong>Métrico:</strong> Se usan Centímetros y Kilogramos' , 'esw_imc_calculator'); ?></span>
			<br />
			<span style="font-size:10px;"><?php _e('<strong>Imperial:</strong> Se usan Pulgadas y Libras' , 'esw_imc_calculator'); ?></span>
		</p>
		<!-- ******************* -->

		<hr>
		
		<!-- ******************************* -->
		<!-- DISENO - MOSTRAR HEADER -->		
		<!-- ******************************* -->
		<h3><?php _e('Estilos y Diseño', 'esw_imc_calculator'); ?></h3>
		
		<!-- ******************************* -->
		<!-- OCULTAR HEADER -->		
		<!-- ******************************* -->
		<p>
			<input id="<?php echo $this->get_field_id('ocultar_header'); ?>" name="<?php echo $this->get_field_name('ocultar_header'); ?>" type="checkbox" value="1" <?php checked( '1', $ocultar_header ); ?> />
			<label for="<?php echo $this->get_field_id('ocultar_header'); ?>"><?php _e('Ocultar Header', 'esw_imc_calculator'); ?></label>
		</p>
		
		<!-- ******************************* -->
		<!-- OCULTAR TABLA RESULTADOS -->		
		<!-- ******************************* -->
		<p>
			<input id="<?php echo $this->get_field_id('ocultar_tabla'); ?>" name="<?php echo $this->get_field_name('ocultar_tabla'); ?>" type="checkbox" value="1" <?php checked( '1', $ocultar_tabla ); ?> />
			<label for="<?php echo $this->get_field_id('ocultar_tabla'); ?>"><?php _e('Ocultar Tabla', 'esw_imc_calculator'); ?></label>
		</p>
		<!-- ******************************* -->
		
		<!-- ******************************* -->
		<!-- OCULTAR ESTILOS Y COLORES DE TABLA -->		
		<!-- ******************************* -->
		<p>
			<input id="<?php echo $this->get_field_id('ocultar_estilos_tabla'); ?>" name="<?php echo $this->get_field_name('ocultar_estilos_tabla'); ?>" type="checkbox" value="1" <?php checked( '1', $ocultar_estilos_tabla ); ?> />
			<label for="<?php echo $this->get_field_id('ocultar_estilos_tabla'); ?>"><?php _e('Ocultar Colores de la tabla', 'esw_imc_calculator'); ?></label>
		</p>
		<!-- ******************************* -->
		
		<!-- ******************************* -->
		<!-- OCULTAR FOOTER -->		
		<!-- ******************************* -->
		<p>
			<input id="<?php echo $this->get_field_id('ocultar_footer'); ?>" name="<?php echo $this->get_field_name('ocultar_footer'); ?>" type="checkbox" value="1" <?php checked( '1', $ocultar_footer ); ?> />
			<label for="<?php echo $this->get_field_id('ocultar_footer'); ?>"><?php _e('Ocultar Footer', 'esw_imc_calculator'); ?></label>
		</p>
		<!-- ******************************* -->
		
		
	<?php 
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] 			= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['select_medidas'] = strip_tags($new_instance['select_medidas']);
		$instance['ocultar_tabla'] 	= strip_tags($new_instance['ocultar_tabla']);
		$instance['ocultar_header'] = strip_tags($new_instance['ocultar_header']);
		$instance['ocultar_estilos_tabla'] = strip_tags($new_instance['ocultar_estilos_tabla']);
		$instance['ocultar_footer'] = strip_tags($new_instance['ocultar_footer']);
				
		return $instance;
	}		
}
// ************************************

// ************************************
// LLAMADO PARA REGISTRAR EL WIDGET
// ************************************
add_action( 'widgets_init', 'register_foo_widget' );
function register_foo_widget() {
    register_widget( 'IMC_Calculator_wydget' );
}
// ************************************
?>