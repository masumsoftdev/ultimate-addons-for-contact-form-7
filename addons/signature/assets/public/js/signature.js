jQuery(document).ready(function($){

  var forms  = $(".wpcf7");
  var signs = [];

  forms.each(function(k, form){

    
    var formId = $(this).find('input[name="_wpcf7"]').val();

    var convertButton    = $('.uacf7-form-'+formId).find(".convertButton");
    var signature_canvas = $('.uacf7-form-'+formId).find(".signature-canvas");
    var confirm_message  = $('.uacf7-form-'+formId).find(".confirm_message");
    var fileInput        = $('.uacf7-form-'+formId).find('.img_id_special');
        fileInput.css('display', 'none');
    var clearButton = $('.uacf7-form-'+formId).find(".clear-button");
    var control_div = $('.uacf7-form-'+formId).find(".control_div");
    var data = [];
    var pad_bg_color = fileInput.attr('bg-color');
    var pen_color    = fileInput.attr('pen-color');


      $(form).find(".signature-pad").each(function(i, wrap){


          var canvas = $(wrap).find('canvas').get(0);
          var signaturePad = new SignaturePad(canvas, {
            includeBackgroundColor: true,
            backgroundColor : pad_bg_color,
            penColor: pen_color,
          });

        
            signs[k+'-'+i] = signaturePad;
            signs[k+'-'+i].addEventListener('endStroke', function(e){
                data = signaturePad.toDataURL('image/png');

                var field_id = $(wrap).attr('data-field-name');

                var input_id = $('input[name="'+field_id+'"]');

                const image = new Image();
        
                image.src = data;
                image.setAttribute('class', 'uacf7-Uacf7UploadedImageForSign');
                image.setAttribute('data-field-name', field_id);

                document.body.appendChild(image);
                const imagePreview = document.querySelector('img[data-field-name="'+field_id+'"]');
            
                const dataUrl = imagePreview.src;

                console.log(dataUrl)
                const blob    = dataURLtoBlob(dataUrl);
              
                const fileName = 'signature'+field_id+'.jpg';
                const file     = new File([blob], fileName);
              
                const fileList = new DataTransfer();
                fileList.items.add(file);
                input_id.prop("files", fileList.files);

                image.remove();

              
                
              
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




                control_div.css('display', 'block');
                confirm_message.text('');
              
            });

            canvas.style.cursor = "crosshair";

            
          
          }); 



           // Clear Canvas

           clearButton.click(function (e) {
            e.preventDefault();
              
            fileInput.val('');
            signaturePad.clear();
            signs = [];
          
            confirm_message.text(uacf7_sign_obj.message_notice);
            confirm_message.css({'color': '#FFB900', 'font-weight': '500'});       
            control_div.css('display', 'none');
            $('.Uacf7UploadedImageForSign_'+formId).remove();

            });

            
            // /** Make Empty the Signature Art Board after Form Submission */

            $('.uacf7-form-'+formId).find('.wpcf7-submit').click(function (){
              signaturePad.clear();
              signs = [];
              confirm_message.text('');
            });

            /** Preventing file system opening */

            $('.uacf7-form-'+formId).find('.img_id_special').click(function (e){
              e.preventDefault();
            });

            
            

            

      }); 

  });









