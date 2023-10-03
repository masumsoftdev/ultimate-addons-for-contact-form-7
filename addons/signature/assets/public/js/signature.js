
;(function ($) {

  var forms = $('.wpcf7-form');

  forms.each(function(){

    var formId = $(this).find('input[name="_wpcf7"]').val();
    


/** Making Canvas */
const canvas = $('.uacf7-form-'+formId).find("#signature-canvas")[0];

const ctx = canvas.getContext('2d');

const clearButton = $('.uacf7-form-'+formId).find("#clear-button");

const confirm_button = $('.uacf7-form-'+formId).find("#convertButton");

// confirm_button.style.display = 'none';
// clearButton.style.display = 'none';

confirm_button.css('display', 'none');
clearButton.css('display', 'none');

let isDrawing = false;

// Set up the canvas
canvas.width = 500;
canvas.height = 150;
canvas.style.border= "1px solid #000";
canvas.style.cursor = "crosshair";
ctx.lineWidth = 1;
ctx.strokeStyle = "#000";
ctx.fillStyle = "#ffffff";




function startDrawing(e) {
    isClicked = true;
    isDrawing = true;
    ctx.beginPath();
    ctx.moveTo(e.clientX - canvas.getBoundingClientRect().left, e.clientY - canvas.getBoundingClientRect().top);

    if(isDrawing == true){
        const confirm_button = $('.uacf7-form-'+formId).find("#convertButton");
        // confirm_button.style.display = 'inline-block';
        // clearButton.style.display = 'inline-block';

        confirm_button.css('display', 'inline-block');
        clearButton.css('display', 'inline-block');
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
    confirm_message.text('please sign first and confirm your signature before submission');
    // confirm_message.style.color = 'black';
    confirm_message.css('color', 'black');

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
});





/** Convert Canvas to Image */

 const convertButton = $('.uacf7-form-'+formId).find("#convertButton");
 const signature_canvas = $('.uacf7-form-'+formId).find("#signature-canvas");
 const confirm_message = $('.uacf7-form-'+formId).find("#confirm_message");

$(convertButton).click(function (e){
  confirm_message.textContent = 'signature confirmed';
  // confirm_message.style.color = 'green';
  confirm_message.css('color', 'green');
  e.preventDefault();
   const imageDataURL = signature_canvas[0].toDataURL("image/png");


      const image = new Image();
      image.src = imageDataURL;
      image.id = 'uploadedImage';
      image.style = 'display:none';
      
      $('.uacf7-form-'+formId).append(image);

 

      const imagePreview = $('.uacf7-form-'+formId).find('#uploadedImage');
      const fileInput = $('.uacf7-form-'+formId).find('#img_id_special');
    
      const dataUrl = imagePreview.attr('src');

      const blob = dataURLtoBlob(dataUrl);

      console.log(blob)
    
      const fileName = 'signature.jpg';
      const file = new File([blob], fileName);
    
      const fileList = new DataTransfer();
      fileList.items.add(file);
    
      fileInput.files = fileList.files;
    
    
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

    document.addEventListener( 'wpcf7submit', function( event ) {
        const canvas = document.getElementById("signature-canvas");
        const ctx = canvas.getContext("2d");
        ctx.clearRect(0, 0, canvas.width, canvas.height);
      }, false );




      /** Click Tracking for Art Board */





   
    }); 

  })(jQuery);
