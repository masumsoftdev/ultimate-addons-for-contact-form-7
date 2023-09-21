<?php
defined( 'ABSPATH' ) || exit;

/**
 * Template for the Form Generator AI tags.
 *
 * @package   UACF7
 * @subpackage Form Generator AI
 * @since     1.0.0
 * @Author:  Sydur Rahman
 */ 

 ob_clean();
 echo '<label> Your name  
     [text* your-name autocomplete:name] </label>
 <label> Your email 
 [email* your-email autocomplete:email] </label>
 <label> Subject 
     [text* your-subject] </label> 
 <label> Your message (optional) 
     [textarea your-message] </label>  
 [submit "Submit"] '; 
 return ob_get_clean();