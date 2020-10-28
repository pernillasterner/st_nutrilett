<?php

namespace App;

class Ajax
{
    public function __construct()
    {
        //  Set global AJAX variable
        add_action( 'wp_head', [$this, 'set_ajax_url'] );

        add_action( 'wp_ajax_get_payment_method_form', [$this, 'get_payment_method_form'] );
        add_action( 'wp_ajax_nopriv_get_payment_method_form', [$this, 'get_payment_method_form'] );
        
        add_action( 'wp_ajax_get_acf_answers', [$this, 'get_acf_answers'] );
        add_action( 'wp_ajax_nopriv_get_acf_answers', [$this, 'get_acf_answers'] );
    }

    public function set_ajax_url()
    {
        echo sprintf( "<script type='text/javascript'>/* <![CDATA[ */window.ajaxURL = '%s';/* ]]> */</script>", admin_url( 'admin-ajax.php' ) );
    }

    public function get_acf_answers()
    {
        $settings = get_fields( 'product_chooser_settings' );
        $productChooserPage = '';
        if(isset($settings['result_screen']['link']['url'])) {
            $productChooserPage = $settings['result_screen']['link']['url'];
        }

        $questionID = isset( $_GET['post_id'] ) ? $_GET['post_id'] : null;
        $rows = get_field( 'answers', $questionID );        

        $result = '';
        foreach ( $rows as $key => $answer ) {
            $dataUrl = '';
            if ( $answer['answer_choice'] == 'group' ) {
              $dataUrl = $productChooserPage.'?result='.$answer['group']->ID;
            }

            $result .= '<div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" name="answers" data-nextstep="'.$answer['answer_choice'].'" data-url="'.$dataUrl.'" value="'.$answer['question']->ID.'" id="question-'.$answer['question']->ID.'-'.$key.'">
              <label class="custom-control-label" for="question-'.$answer['question']->ID.'-'.$key.'">'.$answer[ 'answer' ].'</label>
            </div>';
        }

        echo json_encode( array(
            'result' => $result
        ) );

        wp_die();
    }

    public function get_payment_method_form()
    {
        session_set_cookie_params( 172800, '/' );
        session_start();

        $paymentMethod = isset( $_GET['payment_method'] ) ? $_GET['payment_method'] : null;
        $_SESSION['payment_method'] = $paymentMethod;
        $html = null;

        if( strstr( $_SESSION['payment_method'], 'klarna' ) ) {

            ob_start();
            get_template_part( 'parts/shop/payments-selection' );
            $html = ob_get_contents();
            ob_end_clean();

        }

        header( 'Content-Type: text/json' );

        echo json_encode( array(
            'html' => $html,
        ) );	

        wp_die();
    }
}

new Ajax();