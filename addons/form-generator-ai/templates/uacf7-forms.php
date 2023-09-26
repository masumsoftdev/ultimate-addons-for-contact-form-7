<?php  
defined( 'ABSPATH' ) || exit;

/**
 * Template for the Form Generator AI Form.
 *
 * @package   UACF7
 * @subpackage Form Generator AI
 * @since     1.0.0
 * @Author:  Sydur Rahman
 */

 switch ($uacf7_default[1]) {

    case "multistep":
$form = '[uacf7_step_start uacf7_step_start-901 "Step One"]
<label> Your name
    [text* your-name] </label> 
<label> Your email
    [email* your-email] </label>
[uacf7_step_end]
[uacf7_step_start uacf7_step_start-902 "Step Two"]
<label> Subject
    [text* your-subject] </label> 
<label> Do you need an appointment?
    [select* menu-663 include_blank "Yes" "No"] </label> 
[uacf7_step_end]
[uacf7_step_start uacf7_step_start-903 "Step Three"]
<label> Your message (optional)
    [textarea your-message] </label> 
[submit "Submit"]
[uacf7_step_end]'; 
        break;
    
    case "booking":
$form =  '<label> Your name
[text* your-name] </label> 
<label> Your email
[email* your-email] </label> 
<!------ Booking Code Start ------>
<label> Booking Date
    [uacf7_booking_form_date* uacf7_booking_form_date-397] </label> 
<label> Booking Time
    [uacf7_booking_form_time* uacf7_booking_form_time-84] </label>
<!------ Booking Code End ------> 
<label> Your message (optional)
[textarea your-message] </label> 
[submit "Submit"]';
        break;

    case "conditional":
$form =  '<h4>Condition for Field Type: <strong>Text</strong></h4>
Write name <strong>"John Doe"</strong> or <strong>"Abul Mia"</strong> to test it out 
<label> Your Name
 </label> 
[conditional namefield]
<label> Is your Father name Jonathan Doe?
[select menu-655 include_blank "Yes" "No"] </label>
<div class="clear"></div>
[/conditional] 
<hr /> 
<h4>Condition for Field Type: <strong>Dropdown</strong></h4>
Select <strong>"Yes"</strong> or <strong>"No"</strong> to test it out 
<label> Do you have any Physical Address?
[select* menu-654 include_blank "Yes" "No"] </label> 
[conditional address]
<label> Insert Your Address
 </label>
<div class="clear"></div>
[/conditional] 
[conditional email]
<label> Insert Your Alternate E-mail
[email your-email] </label>
<div class="clear"></div>
[/conditional] 
<hr /> 
<h4>Condition for Field Type: <strong>Radio Buttons</strong></h4>
Select <strong>"Option Two"</strong> or <strong>"Option Three"</strong> to test it out 
<label>Choose your preference</label>
[radio radio-269 use_label_element default:1 "Option One" "Option Two" "Option Three"]
<div class="clear"></div>
[conditional radio]
<label> Why did you select option two?
 </label>
<div class="clear"></div>
[/conditional] 
[conditional radio-two]
<label> Why did you select option three?
 </label>
<div class="clear"></div>
[/conditional] 
<hr /> 
<h4>Condition for Field Type: <strong>Checkboxes</strong></h4>
Select <strong>"Option Two"</strong> or <strong>"Option Three"</strong> to test it out 
<label>Choose your preference</label>
[checkbox checkbox-266 use_label_element "Option One" "Option Two" "Option Three"]
<div class="clear"></div>
[conditional checkbox]
<label> Why did you select option two?
 </label>
<div class="clear"></div>
[/conditional] 
[conditional checkbox-two]
<label> Why did you select option three?
 </label>
<div class="clear"></div>
[/conditional] 
<hr /> 
<label> Insert Your E-mail
[email* your-email-two] </label> 
[submit "Submit"]';
        break; 

    case "subscription":
$form =  '<label> First Name:
    [text* first-name placeholder "John"] </label> 
    <label> Last Name:
    [text* last-name placeholder "Doe"] </label> 
    <label> Email Address:
    [email* email-address placeholder "johndoe@example.com"] </label> 
    <label> Phone Number:
    [tel tel-number placeholder "+1234567890"] </label> 
    <label> Address:
    [textarea address placeholder "123 Main St, City, Country"] </label> 
    <label> Subscription Plan:
    [select subscription-plan "Basic" "Premium" "Gold"] </label> 
    <label> Terms and Conditions:
    [acceptance acceptance-terms] I accept the terms and conditions. [/acceptance] </label> 
    [submit "Subscribe Now"]';
        break; 

    case "blog":
$form =  '<label> Post Title
[uacf7_post_title* post_title] </label> 
<label> Post Content
[uacf7_post_content* post_content] </label> 
<label> Post Thumbnail
 [uacf7_post_thumbnail* post_thumbnail limit:2mb filetypes:jpg|jpeg|png]<br><small>We have enabled all file support. For demo purpose, on this form, please upload jpg, jpeg or png only.</small></label> 
<label> Post Category (You can select multiple)
[uacf7_post_taxonomy* post-taxonomy-351 tax:category multiple] </label> 
<label> Author Name
[text* authorname] </label> 
<label> Author Bio
[textarea* authorbio] </label> 
<label> Author Facebook URL
[url* facebookurl] </label> 
<label> Author Twitter URL
[url* twitterurl] </label> 
<label> Your Email
[email* email-892]<br><small>This field will not be published. This is for further communication purpose.</small> </label> 
[submit "Submit"]';
        break; 

    case "feedback":
$form =  '<label> Your Name
[text* your-name] 
</label> 
<label> Your Email
[email* your-email] 
</label> 
<label> Feedback Topic
[select feedback-topic "Product" "Service" "Website" "Other"]
</label> 
<label> Your Feedback
[textarea* your-feedback] 
</label> 
[submit "Submit Feedback"]';
        break; 
        
    case "application":
$form =  '<label> Full Name
[text* full-name] 
</label> 
<label> Email Address
[email* your-email] 
</label> 
<label> Phone Number
[tel tel-number]
</label> 
<label> Position Applied For
[select position "Software Developer" "Designer" "Marketing" "Sales" "Other"]
</label> 
<label> Cover Letter
[textarea cover-letter] 
</label> 
<label> Upload Resume
[file resume-file filetypes:pdf|doc|docx limit:2mb]
</label> 
[submit "Submit Application"] ';
        break;   

    case "inquiry":
$form =  '<label> Your Name (required)
[text* your-name] 
</label> 
<label> Your Email (required)
[email* your-email] 
</label> 
<label> Subject
[text your-subject] 
</label> 
<label> Your Inquiry
[textarea your-inquiry] 
</label> 
[submit "Send Inquiry"]';
        break;   

    case "survey":
$form =  '<label> Your Name (required)
[text* your-name] 
</label> 
<label> Your Email (required)
[email* your-email] 
</label> 
<label> How did you hear about us?
[radio hear-about-us "Search Engine" "Friend or Colleague" "Social Media" "Advertisement" "Other"]
</label> 
<label> Rate our services (1 being poor, 5 being excellent)
[radio service-rating "1" "2" "3" "4" "5"]
</label> 
<label> What services or products are you most interested in?
[checkbox services-use "Product A" "Service B" "Service C" "Product D" "None of the above"]
</label> 
<label> Any suggestions for us to improve?
[textarea suggestions] 
</label> 
[submit "Submit Survey"]';
        break;   
        
    case "address":
$form =  '<label> First Name
[text* first-name placeholder "John"]
</label> 
<label> Last Name
[text* last-name placeholder "Doe"]
</label> 
<label> Street Address
[text* street-address placeholder "123 Main St"]
</label> 
<label> City
[text* city placeholder "New York"]
</label> 
<label> State/Province
[text* state placeholder "NY"]
</label> 
<label> Postal Code
[text* postal-code placeholder "12345"]
</label> 
<label> Country
[text* country placeholder "USA"]
</label> 
<label> Phone Number
[tel* phone-number placeholder "+1 234 567 8901"]
</label> 
<label> Email Address
[email* email-address placeholder "john.doe@example.com"]
</label> 
[submit "Submit"]';
        break;   
        
    case "event":
$form =  '<label> Full Name
[text* full-name placeholder "John Doe"]
</label> 
<label> Email Address
[email* email-address placeholder "john.doe@example.com"]
</label> 
<label> Phone Number
[tel* phone-number placeholder "+1 234 567 8901"]
</label> 
<label> Number of Attendees
[number* number-of-attendees min:1 placeholder "1"]
</label> 
<label> Event Date Preference
[date* event-date]
</label> 
<label> Dietary Preferences (if any)
[textarea dietary-preferences]
</label> 
<label> Any Special Requirements?
[textarea special-requirements]
</label> 
<label> Event Selection
[select event-selection "Workshop A" "Workshop B" "Seminar X" "Seminar Y"]
</label> 
[submit "Register"]';
        break;   

    case "newsletter":
$form =  '<label> Full Name
[text* full-name placeholder "John Doe"]
</label> 
<label> Email Address
[email* email-address placeholder "john.doe@example.com"]
</label> 
<label> Preferred Topics (Optional)
[checkbox preferred-topics "Technology" "Science" "Arts" "Travel"]
</label> 
[submit "Subscribe"]';
        break;   
        
    case "donation":
$form =  '<label> Full Name
[text* full-name placeholder "Jane Smith"]
</label> 
<label> Email Address
[email* email-address placeholder "jane.smith@example.com"]
</label> 
<label> Phone Number (Optional)
[tel tel-number placeholder "+1 234 567 8901"]
</label> 
<label> Donation Amount
[select donation-amount "Choose an amount" "10" "25" "50" "100" "Other"]
</label> 
<label> Specify Other Amount (if selected above)
[number other-amount placeholder "$"]
</label> 
<label> Message (Optional)
[textarea message placeholder "Your message or dedication..."]
</label> 
[submit "Donate Now"]';
        break;   

    case "product-review":
$form =  '<label> Your Name
[text* your-name placeholder "Jane Smith"]
</label> 
<label> Your Email
[email* your-email placeholder "jane.smith@example.com"]
</label> 
<label> Product SKU or ID
[text product-id placeholder "12345678"]
</label> 
<label> Purchase Date
[date purchase-date]
</label> 
<label> Overall Rating
[select rating "5 - Excellent" "4 - Very Good" "3 - Average" "2 - Not Good" "1 - Poor"]
</label> 
<label> Your Review Title
[text review-title placeholder "A quick summary of your thoughts"]
</label> 
<label> Detailed Review
[textarea detailed-review placeholder "What did you like or dislike?"]
</label> 
<label> Product Image 
[file product-image filetypes:jpg|jpeg|png limit:2mb]
</label> 
<label> Would you purchase this product again?
[checkbox purchase-again "Yes"]
</label> 
[submit "Submit Your Review"]';
        break;   
        
    case "service-booking":
$form =  '<label> Your Name
[text* your-name placeholder "John Doe"]
</label> 
<label> Your Email
[email* your-email placeholder "john.doe@example.com"]
</label> 
<label> Contact Number
[tel* your-phone placeholder "+1 234 567 8910"]
</label> 
<label> Preferred Date of Service
[date* service-date]
</label> 
<label> Type of Service Required
[select service-type "Cleaning" "Maintenance" "Consultation" "Repair" "Other"]
</label> 
<label> Preferred Time Slot
[select time-slot "09:00 AM - 11:00 AM" "11:00 AM - 01:00 PM" "01:00 PM - 03:00 PM" "03:00 PM - 05:00 PM"]
</label> 
<label> Address for Service
[textarea service-address placeholder "123 Main St, City, ZIP"]
</label> 
<label> Additional Instructions or Requirements
[textarea instructions placeholder "Any additional information or specific requirements"]
</label> 
[submit "Book Your Service"]';
        break;   
        
    case "appointment-form":
$form =  '<label> Full Name
[text* full-name placeholder "Jane Smith"]
</label> 
<label> Email Address
[email* email-address placeholder "jane.smith@example.com"]
</label> 
<label> Phone Number
[tel* phone-number placeholder "+1 234 567 8910"]
</label> 
<label> Preferred Date of Appointment
[date* appointment-date]
</label> 
<label> Preferred Time Slot
[select time-slot "09:00 AM - 10:00 AM" "10:00 AM - 11:00 AM" "11:00 AM - 12:00 PM" "01:00 PM - 02:00 PM" "02:00 PM - 03:00 PM"]
</label> 
<label> Reason for Appointment
[textarea reason placeholder "Describe the reason for your appointment"]
</label> 
<label> Do you have any specific doctor in mind?
[select doctor-choice "Any Available" "Dr. John Doe" "Dr. Jane Smith" "Dr. Richard Roe"]
</label> 
<label> Additional Notes
[textarea additional-notes placeholder "Any additional information or specific needs"]
</label> 
[submit "Schedule Appointment"]';
        break;   
         
    case "rating":
$form =  '<label> Name
[text* name placeholder "John Doe"]
</label> 
<label> Email Address
[email* email-address placeholder "john.doe@example.com"]
</label> 
<label> Rate Our Service 
[radio rating "Excellent" "Good" "Average" "Below Average" "Poor"]
</label> 
<label> Comments or Feedback
[textarea feedback placeholder "Please share your feedback"]
</label> 
[submit "Submit Rating"]';
        break;   
        
    default:
        $form = "Sorry, we couldn't find a matching form for the keyword ".$uacf7_default[1].". Please try another keyword or consult the Form Generator AI for assistance.";
        break;
}

ob_clean(); 
echo $form;
return ob_get_clean();
?>