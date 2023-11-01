

jQuery(document).ready(function($){


  var forms  = $(".wpcf7");
  var signs = [];

  forms.each(function(k, form){

    var formId = $(this).find('input[name="_wpcf7"]').val();


      $(form).find("#signature-pad").each(function(i, wrap){

        var data;
          
          var canvas = $(wrap).find('canvas').get(0);

          var signaturePad = new SignaturePad(canvas, {
              backgroundColor: 'rgb(255, 255, 255)' 
          });

          signs[k+'-'+i] = signaturePad;
          signs[k+'-'+i].addEventListener('endStroke', function(e){
              data = signaturePad.toDataURL('image/png');

              control_div.css('display', 'block');
              confirm_message.text('');
            
          });


            /** Convert Canvas to Image */

          var convertButton = $('.uacf7-form-'+formId).find("#convertButton");
          var signature_canvas = $('.uacf7-form-'+formId).find("#signature-canvas");
          var confirm_message = $('.uacf7-form-'+formId).find("#confirm_message");
          var existing_img = $('.uacf7-form-'+formId).find('.control_div').find('.uploadedImage');
          var fileInput = $('.uacf7-form-'+formId).find('#img_id_special'); 
          var clearButton = $('.uacf7-form-'+formId).find("#clear-button");
          var control_div = $('.uacf7-form-'+formId).find(".control_div"); 

          canvas.style.border= "1px solid #ddd";
          canvas.style.cursor = "crosshair";

          $(convertButton).click(function (e){
                e.preventDefault();
                confirm_message.text('Signature Confirmed');
                confirm_message.css({'color':'#46B450', 'font-weight': '500'});
            
                signature_canvas.css('background-color', '#fff');
                
                    const image = new Image();
            
                    image.src = data;
            
                    image.setAttribute('class', 'uploadedImage');
                    // image.class = 'uploadedImage_'+formId;
            
                    // image.style = 'display:none';
            
                    document.body.appendChild(image);
            
                    
                    /** This need to be appened to get it's property: by Masum */
            
                    const imagePreview = document.querySelectorAll('.uploadedImage_'+formId);
                
                    const dataUrl = imagePreview.src;
                    const blob = dataURLtoBlob(dataUrl);
                  
                    const fileName = 'signature.jpg';
                    const file = new File([blob], fileName);
                  
                    const fileList = new DataTransfer();
                    fileList.items.add(file);
                  
                    fileInput.prop("files", fileList.files);
                    
                  
                  function dataURLtoBlob(dataUrl) {
            
                      const parts = dataUrl.split(';base64,');
            
                      const contentType = parts[0].split(':')[1];
            
                      const raw = window.atob(parts[1]);
            
                      const rawLength = raw.length;
                    
                      const uint8Array = new Uint8Array(rawLength);
            
                      for (let i = 0; i < rawLength; ++i) {
                        uint8Array[i] = raw.charCodeAt(i);
                      }
                    
                      return new Blob([uint8Array], { type: contentType });
                    }   
                    
                
                
              });   
              
              
              // Clear Canvas

                clearButton.click(function (e) {
                    e.preventDefault();
                      
                    $('#img_id_special').val('');

           
                    signaturePad.clear();
                    signs = [];
                  
                    confirm_message.text('Please sign first and confirm your signature before form submission');
                    confirm_message.css({'color': '#FFB900', 'font-weight': '500'});       
                    control_div.css('display', 'none');
                    existing_img.remove();


              });


              // /** Make Empty the Signature Art Board after Form Submission */

                $('.uacf7-form-'+formId).find('.wpcf7-submit').click(function (){
                  signaturePad.clear();
                  signs = [];
                  confirm_message.text('');
                });

                /** Preventing file system opening */

                $('.uacf7-form-'+formId).find('#img_id_special').click(function (e){
                  e.preventDefault();
                });

              }); 
              

      }); 

  });




function resizeCanvas( canvas ) {
  const ratio =  Math.max(window.devicePixelRatio || 1, 1);
  canvas.width = canvas.offsetWidth * ratio;
  canvas.height = canvas.offsetHeight * ratio;
  canvas.getContext("2d").scale(ratio, ratio);
}







































// ;(function ($) {

//   var forms = $('.wpcf7-form');

//   forms.each(function(){

//     var formId = $(this).find('input[name="_wpcf7"]').val();


//   /** Making Canvas */
//   const canvas = $('.uacf7-form-'+formId).find("#signature-canvas")[0];

//   const ctx = canvas.getContext('2d');

//   const clearButton = $('.uacf7-form-'+formId).find("#clear-button");

//   const confirm_button = $('.uacf7-form-'+formId).find("#convertButton");

//   const control_sec = $('.uacf7-form-'+formId).find(".control_div"); 
//   control_sec.css('display', 'none');

//   let isDrawing = false;
  

//   $(document).ready(function() {

//     $.ajax({
//         url: signature_obj.ajaxurl,
//         type: 'POST',
//         data: {form_id : formId, action: 'uacf7_signature'},
//         success: function(response) {

//           canvas.width = response.width ? response.width : '300';
//           canvas.height = response.height ? response.height : '100';

//         }
//     });
//   });




//   // Use mouseX and mouseY to draw
  
//   canvas.style.border= "1px solid #ddd";
//   canvas.style.cursor = "crosshair";
//   ctx.lineWidth = 2;
//   ctx.strokeStyle = "#000000";
//   ctx.fillStyle = "#ffffff";
//   ctx.lineCap = 'round';




  
//   // Function to disable scrolling
//   function disableScroll() {
//     document.body.style.overflow = 'hidden';
//   }

//   // Function to enable scrolling
//   function enableScroll() {
//     document.body.style.overflow = 'auto';
//   }


//   function startDrawing(e) {

//       disableScroll();

//       isClicked = true;
//       isDrawing = true;
  
//       let rect = canvas.getBoundingClientRect();
//       let scaleX = canvas.width / rect.width;
//       let scaleY = canvas.height / rect.height;
  
//       let offsetX = rect.left;
//       let offsetY = rect.top;
  
//       let clientX, clientY;
  
//       if (e.touches && e.touches.length) {
//           clientX = e.touches[0].clientX;
//           clientY = e.touches[0].clientY;
//       } else {
//           clientX = e.clientX;
//           clientY = e.clientY;
//       }
  
//       let x = (clientX - offsetX) * scaleX;
//       let y = (clientY - offsetY) * scaleY;
  
//       ctx.beginPath();
//       ctx.moveTo(x, y);
  
//       if (isDrawing) {
//           const control_sec = document.querySelector('.uacf7-form-' + formId + ' .control_div');
//           control_sec.style.display = 'block';
//       }
//   }
  
//   function draw(e) {

//       if (!isDrawing) return;

//       let rect = canvas.getBoundingClientRect();
//       let scaleX = canvas.width / rect.width;
//       let scaleY = canvas.height / rect.height;
  
//       let offsetX = rect.left;
//       let offsetY = rect.top;
  
//       let clientX, clientY;
  
//       if (e.touches && e.touches.length) {
//           clientX = e.touches[0].clientX;
//           clientY = e.touches[0].clientY;
//       } else {
//           clientX = e.clientX;
//           clientY = e.clientY;
//       }
  
    

//       let x = (clientX - offsetX) * scaleX;
//       let y = (clientY - offsetY) * scaleY;

  
//       ctx.lineTo(x, y);
//       ctx.stroke();
//   }
  
//   function stopDrawing() {
//     enableScroll();
//     isDrawing = false;
//     ctx.closePath();
//   }




//   function clearCanvas() {
//       // e.preventDefault();
//       ctx.clearRect(0, 0, canvas.width, canvas.height);
//       const fileInput = $('.uacf7-form-'+formId).find('#img_id_special'); //Clearing the value of file input 
//       fileInput.value = null;
//       const confirm_message = $('.uacf7-form-'+formId).find("#confirm_message");
//       confirm_message.text('Please sign first and confirm your signature before form submission');
//       confirm_message.css({'color': '#FFB900', 'font-weight': '500'});
//       const control_div = $('.uacf7-form-'+formId).find(".control_div"); 
//       control_div.css('display', 'none');

//   }



//   // Event listeners
//   canvas.addEventListener("mousedown", startDrawing);
//   canvas.addEventListener("touchstart", startDrawing);
//   canvas.addEventListener("mousemove", draw);
//   canvas.addEventListener("touchmove", draw);
//   canvas.addEventListener("mouseup", stopDrawing);
//   canvas.addEventListener("mouseout", stopDrawing);
//   canvas.addEventListener("touchend", stopDrawing);

//   // clearButton.addEventListener("click", clearCanvas);

//   clearButton.click(function (e) {
//     e.preventDefault();
//     clearCanvas();
//     var existing_img = $('.uacf7-form-'+formId).find('.control_div').find('#uploadedImage');
//     existing_img.remove();
//   });


//   /** Convert Canvas to Image */

//   const convertButton = $('.uacf7-form-'+formId).find("#convertButton");
//   const signature_canvas = $('.uacf7-form-'+formId).find("#signature-canvas");
//   const confirm_message = $('.uacf7-form-'+formId).find("#confirm_message");

//   $(convertButton).click(function (e){
//     e.preventDefault();
//     confirm_message.text('Signature Confirmed');
//     confirm_message.css({'color':'#46B450', 'font-weight': '500'});

//     signature_canvas.css('background-color', '#fff');

//     const imageDataURL = signature_canvas[0].toDataURL("image/png");

    
//         const image = new Image();

//         image.src = imageDataURL;

//         image.id = 'uploadedImage_'+formId;

//         image.style = 'display:none';

//         document.body.appendChild(image);

        
//         /** This need to be appened to get it's property: by Masum */

//         const imagePreview = document.getElementById('uploadedImage_'+formId);
    
//         const fileInput = $('.uacf7-form-'+formId).find("#img_id_special");

//         const dataUrl = imagePreview.src;
//         const blob = dataURLtoBlob(dataUrl);
      
//         const fileName = 'signature.jpg';
//         const file = new File([blob], fileName);
      
//         const fileList = new DataTransfer();
//         fileList.items.add(file);
      
//         fileInput.prop("files", fileList.files);
        
      
//       function dataURLtoBlob(dataUrl) {

//           const parts = dataUrl.split(';base64,');

//           const contentType = parts[0].split(':')[1];

//           const raw = window.atob(parts[1]);

//           const rawLength = raw.length;
        
//           const uint8Array = new Uint8Array(rawLength);

//           for (let i = 0; i < rawLength; ++i) {
//             uint8Array[i] = raw.charCodeAt(i);
//           }
        
//           return new Blob([uint8Array], { type: contentType });
//         }       
    
//   });


// /** Make Empty the Signature Art Board after Form Submission */

//   $('.uacf7-form-'+formId).find('.wpcf7-submit').click(function (){
//     const canvas = $('.uacf7-form-'+formId).find("#signature-canvas")[0];
//     const ctx = canvas.getContext("2d");
//     ctx.clearRect(0, 0, canvas.width, canvas.height);
//     confirm_message.text('');
//   });

//   /** Preventing file system opening */

//   $('.uacf7-form-'+formId).find('#img_id_special').click(function (e){
//     e.preventDefault();
//   });

// }); 

// })(jQuery);
