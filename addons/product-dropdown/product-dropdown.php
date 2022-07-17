<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_PRODUCT_DROPDOWN {
    
    private $hidden_fields = array();
    /*
    * Construct function
    */
    public function __construct() {
        add_action( 'wpcf7_init', array($this, 'add_shortcodes') );
        add_action( 'admin_init', array( $this, 'tag_generator' ) );
        add_filter( 'wpcf7_validate_uacf7_product_dropdown', array($this, 'wpcf7_product_dropdown_validation_filter'), 10, 2 );
        add_filter( 'wpcf7_validate_uacf7_product_dropdown*', array($this,'wpcf7_product_dropdown_validation_filter'), 10, 2 );
        add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_script' ) ); 
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_wpd_frontend_script' ) );       
    }
    
    public function admin_enqueue_script() { 

        wp_enqueue_script( 'uacf7-product-dropdown', UACF7_ADDONS . '/product-dropdown/assets/admin-script.js', array('jquery'), null, true );
    }
    public function enqueue_wpd_frontend_script() {
        wp_enqueue_style( 'uacf7-wpd-style', UACF7_ADDONS . '/product-dropdown/assets/css/wpd-style.css' ); 

        wp_enqueue_script( 'uacf7-wpd-script', UACF7_ADDONS . '/product-dropdown/assets/js/wpd-script.js', array('jquery'), null, true );
    }

    
      /*
    * Form tag
    */
    public function add_shortcodes() {
        
        wpcf7_add_form_tag( array( 'uacf7_product_dropdown', 'uacf7_product_dropdown*'),
        array( $this, 'tag_handler_callback' ), array( 'name-attr' => true ) );
    }
    
    public function tag_handler_callback( $tag ) {
        
        if ( empty( $tag->name ) ) {
            return '';
        }

        $validation_error = wpcf7_get_validation_error( $tag->name );

        $class = wpcf7_form_controls_class( $tag->type );

        if ( $validation_error ) {
            $class .= ' wpcf7-not-valid';
        }

        $atts = array();

        $atts['class'] = $tag->get_class_option( $class );
        $atts['id'] = $tag->get_id_option();
        $atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

        if ( $tag->is_required() ) {
            $atts['aria-required'] = 'true';
        }

        $atts['aria-invalid'] = $validation_error ? 'true' : 'false';

        $multiple = $tag->has_option( 'multiple' );

        if ( $tag->has_option( 'size' ) ) {
            $size = $tag->get_option( 'size', 'int', true );

            if ( $size ) {
                $atts['size'] = $size;
            } elseif ( $multiple ) {
                $atts['size'] = 4;
            } else {
                $atts['size'] = 1;
            }
        }

        if ( $data = (array) $tag->get_data_option() ) {
            $tag->values = array_merge( $tag->values, array_values( $data ) );
        }

        $values = $tag->values;

        $default_choice = $tag->get_default_option( null, array(
            'multiple' => $multiple,
        ) );

        $hangover = wpcf7_get_hangover( $tag->name );
        
        if( $tag->has_option( 'product_by:id' ) ) {
            
            $product_by = 'id';
            
        }elseif( $tag->has_option( 'product_by:category' ) ){
            
            $product_by = 'category';
            
        }else {
            $product_by = '';
        }
        
        $args = apply_filters( 'uacf7_product_dropdown_query', array(
             'post_type'      => 'product',
             'posts_per_page' => -1,
             'post_status'    => 'publish',
        ), $values, $product_by );
                
        $products = new WP_Query($args);
        
        if($tag->has_option( 'layout:grid' )){ // Grid Layout
            global  $woocommerce;
            if ( $multiple ) {
                $multiple = "checkbox";
                
            }else{
                $multiple = "radio";
            }
            $html = '';
            while ( $products->have_posts() ) {
                $products->the_post();
                if ( $hangover ) {
                    $selected = in_array( get_the_title(), (array) $hangover, true );
                } else {
                    $selected = in_array( get_the_title(), (array) $default_choice, true );
                }
                $item_atts = array(
                    'value' => get_the_title(), 
                    'id' => 'for_'.get_the_id(), 
                    'product-id' => get_the_id(),
                    'type' => $multiple,
                    'name' => $tag->name . ( $multiple ? '[]' : '' ),
                );

                $item_atts = wpcf7_format_atts( $item_atts );

                $label = get_the_title(); 
                $product = wc_get_product( get_the_id() );
                
                if($product->get_sale_price() != ''){
                    $sale_price = get_woocommerce_currency_symbol().' '.$product->get_sale_price();
                }elseif($product->get_price() !=''){
                    $sale_price = get_woocommerce_currency_symbol().' '.$product->get_price();
                }else{
                    $sale_price = get_woocommerce_currency_symbol().' '.$product->get_regular_price();
                }
                if($product->get_regular_price()){
                    $regular_price = get_woocommerce_currency_symbol().' '.$product->get_regular_price();
                }else{
                    $regular_price = '';
                }
               
                $price = '<del aria-hidden="true"> '.$sale_price.'</del> <ins><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol"></span>'.$regular_price.'</bdi></span></ins>'; 
                $html .= sprintf(' <div class="single-product-grid"> 
                                <div class="s-product-img"> 
                                    <div class="img-absulate">
                                    <img src="'.get_the_post_thumbnail_url().'">
                                        <label for="for_'.get_the_id().'" class="absulate-hover">
                                            <input %1$s>
                                        </label>
                                    </div>
                                </div>
                                <div class="s-product-content">
                                    <h5>%2$s</h5>
                                    <span class="price">%3$s</span>
                                </div> 
                            </div>',$item_atts, esc_html( $label ), $price );
            }
            wp_reset_postdata(); 
            if ( $multiple ) {
                $atts['multiple'] = apply_filters('uacf7_multiple_attribute','');;
            }
 
            $html = sprintf(
                '<div class="product-grid %1$s">%2$s</div>%3$s',
                sanitize_html_class( $tag->name ), $html, $validation_error
            );
             
        }else{ // Dropdown Layout
            $html = '<option>-Select-</option>';
            while ( $products->have_posts() ) {
                $products->the_post();
                
                if ( $hangover ) {
                    $selected = in_array( get_the_title(), (array) $hangover, true );
                } else {
                    $selected = in_array( get_the_title(), (array) $default_choice, true );
                }

                $item_atts = array(
                    'value' => get_the_title(),
                    'selected' => $selected ? 'selected' : '',
                    'product-id' => get_the_id(),
                );

                $item_atts = wpcf7_format_atts( $item_atts );

                $label = get_the_title();

                $html .= sprintf( '<option %1$s>%2$s</option>',
                    $item_atts, esc_html( $label ) );
            }
            wp_reset_postdata();
            
            if ( $multiple ) {
                $atts['multiple'] = apply_filters('uacf7_multiple_attribute','');;
            }

            $atts['name'] = $tag->name . ( $multiple ? '[]' : '' );

            $atts = wpcf7_format_atts( $atts );

            $html = sprintf(
                '<span class="wpcf7-form-control-wrap %1$s"><select %2$s>%3$s</select>%4$s</span>',
                sanitize_html_class( $tag->name ), $atts, $html, $validation_error
            );
        }
        return $html;
    }
    
    
    public function wpcf7_product_dropdown_validation_filter( $result, $tag ) {
        $name = $tag->name;

        if ( isset( $_POST[$name] )
        and is_array( $_POST[$name] ) ) {
            foreach ( $_POST[$name] as $key => $value ) {
                if ( '' === $value ) {
                    unset( $_POST[$name][$key] );
                }
            }
        }

        $empty = ! isset( $_POST[$name] ) || empty( $_POST[$name] ) && '0' !== $_POST[$name];

        if ( $tag->is_required() and $empty ) {
            $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
        }

        return $result;
    }

    /*
    * Generate tag - conditional
    */
    public function tag_generator() {
        if (! function_exists( 'wpcf7_add_tag_generator'))
            return;

        wpcf7_add_tag_generator('uacf7_product_dropdown',
            __('Product Dropdown', 'ultimate-addons-cf7'),
            'uacf7-tg-pane-product-dropdown',
            array($this, 'tg_pane_product_dropdown')
        );

    }
    
    static function tg_pane_product_dropdown( $contact_form, $args = '' ) {
        $args = wp_parse_args( $args, array() );
        $uacf7_field_type = 'uacf7_product_dropdown';
        ?>
        <div class="control-box">
            <fieldset>                
                <table class="form-table">
                   <tbody>
                        <tr>
                            <th scope="row">Field type</th>
                            <td>
                                <fieldset>
                                <legend class="screen-reader-text">Field type</legend>
                                <label><input type="checkbox" name="required" value="on"> Required field</label>
                                </fieldset>
                            </td>
                        </tr>
                        
                        <?php ob_start(); ?>
                        <tr>
                            <th scope="row"></th>
                            <td><label for="tag-generator-panel-select-multiple"><input id="tag-generator-panel-select-multiple" type="checkbox" disabled> Allow multiple selections <a style="color:red" target="_blank" href="https://cf7addons.com/preview/pro">(Pro)</a></label></td>
                        </tr>
                        <?php $multiple_attr = ob_get_clean(); ?>
                        
                        <?php 
                        /*
                        * Tag generator field after field type
                        */
                        echo apply_filters('uacf7_tag_generator_multiple_select_field', $multiple_attr);
                        ?>
                        
                        <tr>
                            <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'ultimate-addons-cf7' ) ); ?></label></th>
                            <td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
                        </tr>
                        
                        <?php ob_start(); ?>
                        <tr>
                            <th scope="row"><label for="product_by">Show Product By</label></th>
                            <td>
                                <label for="byID"><input id="byID" name="product_by" class="" type="radio" value="id" checked> Product ID</label>
                                
                                <label for="byCategory"><input id="byCategory" name="product_by" class="" type="radio" value="category"> Category</label>
                            </td>
                        </tr>
                        <?php 
                        $product_by = ob_get_clean();
                        echo apply_filters('uacf7_tag_generator_product_by_field',$product_by);
                        ?>
                        
                       
                       
                        <?php ob_start(); ?>
                        <tr class="tag-generator-panel-product-id">
                            <th scope="row"><label for="tag-generator-panel-product-id">Product ID</label></th>
                            <td>
                                <textarea class="values" name="" id="tag-generator-panel-product-id" cols="30" rows="10" disabled></textarea> One ID per line. <a style="color:red" target="_blank" href="https://cf7addons.com/preview/pro">(Pro)</a>
                            </td>
                        </tr>
                        <?php 
                        $product_id_html = ob_get_clean(); 
                        /*
                        * Tag generator field after name attribute.
                        */
                        echo apply_filters('uacf7_tag_generator_product_id_field',$product_id_html);
                        ?>
                        
                        <?php ob_start(); ?>
                        <tr class="tag-generator-panel-product-category">   
                           <th><label for="tag-generator-panel-product-category">Product category</label></th>                     
                            <td>
                            <?php
                            $taxonomies = get_terms( array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => false
                            ) );

                            if ( !empty(array_filter($taxonomies)) ) :
                                $output = '<select id="tag-generator-panel-product-category">';
                                $output .= '<option value="">All</option>';
                                foreach( $taxonomies as $category ) {
                                    $output.= '<option value="">'. esc_html( $category->name ) .'</option>';
                                }
                                $output.='</select> <a style="color:red" target="_blank" href="https://cf7addons.com/preview/pro">(Pro)</a>';

                                echo $output;

                            endif;
                            ?>
                            </td>
                        </tr>
                        <?php 
                        $product_dropdown_html = ob_get_clean();

                        /*
                        * Tag generator field after name attribute.
                        */
                        echo apply_filters('uacf7_tag_generator_product_category_field',$product_dropdown_html);
                       ?>

                        <?php ob_start(); ?>
                        <tr>
                            <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-layout' ); ?>"><?php echo esc_html( __( 'Select Layout Style', 'ultimate-addons-cf7' ) ); ?></label></th> 
                            <td>
                                <label for="layoutDropdown"><input id="layoutDropdown" name="layout" class="option" type="radio" value="dropdown" checked> Dropdown</label>

                                <label for="layoutGrid"><input id="layoutGrid" name="layout" class="option" type="radio" disabled value="grid"> Grid</label>

                                Allow multiple Layout Style <a style="color:red" target="_blank" href="https://cf7addons.com/preview/pro">(Pro)</a>
                            </td> 
                            
                        </tr>
                        <?php 
                        
                        $select_layout_style = ob_get_clean();

                        echo apply_filters('uacf7_tag_generator_product_layout_style_by_field', $select_layout_style);
                        ?>

                        <tr>
                            <th scope="row"><label for="tag-generator-panel-text-class">Class attribute</label></th>
                            <td><input type="text" name="class" class="classvalue oneline option" id="tag-generator-panel-text-class"></td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
        </div>

        <div class="insert-box">
            <input type="text" name="<?php echo esc_attr($uacf7_field_type); ?>" class="tag code" readonly="readonly" onfocus="this.select()" />

            <div class="submitbox">
                <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'ultimate-addons-cf7' ) ); ?>" />
            </div>
        </div>
        <?php
    }
    
}
new UACF7_PRODUCT_DROPDOWN();
