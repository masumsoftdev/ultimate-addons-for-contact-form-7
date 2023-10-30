
;(function ($) {

        var forms = $('.wpcf7-form');

        forms.each(function(){

          var formId = $(this).find('input[name="_wpcf7"]').val();
      

      /** Making Canvas */
      const canvas = $('.uacf7-form-'+formId).find("#signature-canvas")[0];

      const ctx = canvas.getContext('2d');

      const clearButton = $('.uacf7-form-'+formId).find("#clear-button");

      const confirm_button = $('.uacf7-form-'+formId).find("#convertButton");

      const control_sec = $('.uacf7-form-'+formId).find(".control_div"); 
      control_sec.css('display', 'none');

      let isDrawing = false;

      // Set up the canvas
      canvas.width = 500;
      canvas.height = 150;
      canvas.style.border= "1px solid #ddd";
      canvas.style.cursor = "crosshair";
      ctx.lineWidth = 1;
      ctx.strokeStyle = "#000";
      ctx.fillStyle = "#fff";


    

      function startDrawing(e) {
          isClicked = true;
          isDrawing = true;
          ctx.beginPath();
          ctx.moveTo(e.clientX - canvas.getBoundingClientRect().left, e.clientY - canvas.getBoundingClientRect().top);

          if(isDrawing == true){
              // const confirm_button = $('.uacf7-form-'+formId).find("#convertButton");   
              // confirm_button.css('display', 'inline-block');
              // clearButton.css('display', 'inline-block');
              const control_sec = $('.uacf7-form-'+formId).find(".control_div"); 
              control_sec.css('display', 'block');
          }
          
      }

      function draw(e) {
          if (!isDrawing) return;
          ctx.lineTo(e.clientX - canvas.getBoundingClientRect().left, e.clientY - canvas.getBoundingClientRect().top);
          ctx.stroke();
      }

      function stopDrawing() {
          isDrawing = false;
          ctx.closePath();
      }

      function clearCanvas() {
          // e.preventDefault();
          ctx.clearRect(0, 0, canvas.width, canvas.height);
          const fileInput = $('.uacf7-form-'+formId).find('#img_id_special'); //Clearing the value of file input 
          fileInput.value = null;
          const confirm_message = $('.uacf7-form-'+formId).find("#confirm_message");
          confirm_message.text('Please sign first and confirm your signature before form submission');
          confirm_message.css({'color': '#FFB900', 'font-weight': '500'});
          const control_div = $('.uacf7-form-'+formId).find(".control_div"); 
          control_div.css('display', 'none');

      }

      // Event listeners
      canvas.addEventListener("mousedown", startDrawing);
      canvas.addEventListener("mousemove", draw);
      canvas.addEventListener("mouseup", stopDrawing);
      canvas.addEventListener("mouseout", stopDrawing);

      // clearButton.addEventListener("click", clearCanvas);

      clearButton.click(function (e) {
        e.preventDefault();
        clearCanvas();
        var existing_img = $('.uacf7-form-'+formId).find('.control_div').find('#uploadedImage');
        existing_img.remove();
      });


      /** Convert Canvas to Image */

      const convertButton = $('.uacf7-form-'+formId).find("#convertButton");
      const signature_canvas = $('.uacf7-form-'+formId).find("#signature-canvas");
      const confirm_message = $('.uacf7-form-'+formId).find("#confirm_message");

      $(convertButton).click(function (e){
        e.preventDefault();
        confirm_message.text('Signature Confirmed');
        confirm_message.css({'color':'#46B450', 'font-weight': '500'});

        signature_canvas.css('background-color', '#fff');

        const imageDataURL = signature_canvas[0].toDataURL("image/png");

        
            const image = new Image();

            image.src = imageDataURL;

            image.id = 'uploadedImage_'+formId;

            image.style = 'display:none';

            document.body.appendChild(image);

            
            /** This need to be appened to get it's property: by Masum */

            const imagePreview = document.getElementById('uploadedImage_'+formId);
        
            const fileInput = $('.uacf7-form-'+formId).find("#img_id_special");

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


    /** Make Empty the Signature Art Board after Form Submission */

      $('.uacf7-form-'+formId).find('.wpcf7-submit').click(function (){
        const canvas = $('.uacf7-form-'+formId).find("#signature-canvas")[0];
        const ctx = canvas.getContext("2d");
        ctx.clearRect(0, 0, canvas.width, canvas.height);
      });

      /** Preventing file system opening */

      $('.uacf7-form-'+formId).find('#img_id_special').click(function (e){
        e.preventDefault();
      });
   
    }); 

  })(jQuery);
