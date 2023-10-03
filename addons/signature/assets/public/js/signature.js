
;(function ($) {

  var forms = $('.wpcf7-form');

  forms.each(function(){

    var formId = $(this).find('input[name="_wpcf7"]').val();

    console.log(formId)


/** Making Canvas */
const canvas = document.getElementById("signature-canvas");
const ctx = canvas.getContext("2d");
const clearButton = document.getElementById("clear-button");



const confirm_button = document.getElementById("convertButton");
confirm_button.style.display = 'none';
clearButton.style.display = 'none';

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
        const confirm_button = document.getElementById("convertButton");
        confirm_button.style.display = 'inline-block';
        clearButton.style.display = 'inline-block';
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

function clearCanvas(e) {
    e.preventDefault();
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    const fileInput = document.getElementById('img_id_special'); //Clearing the value of file input 
    fileInput.value = null;
    const confirm_message = document.getElementById("confirm_message");
    confirm_message.textContent = 'please sign first and confirm your signature before submission';
    confirm_message.style.color = 'black';

}

// Event listeners
canvas.addEventListener("mousedown", startDrawing);
canvas.addEventListener("mousemove", draw);
canvas.addEventListener("mouseup", stopDrawing);
canvas.addEventListener("mouseout", stopDrawing);

clearButton.addEventListener("click", clearCanvas);





/** Convert Canvas to Image */

 const convertButton = document.getElementById("convertButton");
 const signature_canvas = document.getElementById("signature-canvas");
 const confirm_message = document.getElementById("confirm_message");

 convertButton.addEventListener("click", (e) => {
    confirm_message.textContent = 'signature confirmed';
    confirm_message.style.color = 'green';
    e.preventDefault();
     const imageDataURL = signature_canvas.toDataURL("image/png");

 
        const image = new Image();
        image.src = imageDataURL;
        image.id = 'uploadedImage';
        image.style = 'display:none';
        image.style = 'display:none';
        
        document.body.appendChild(image);

   

        const imagePreview = document.getElementById('uploadedImage');
        const fileInput = document.getElementById('img_id_special');
      
        const dataUrl = imagePreview.src;
        const blob = dataURLtoBlob(dataUrl);
      
        const fileName = 'signature.jpg';
        const file = new File([blob], fileName);
      
        const fileList = new DataTransfer();
        fileList.items.add(file);
      
        fileInput.files = fileList.files;
      
      
      function dataURLtoBlob(dataURL) {
        const parts = dataURL.split(';base64,');
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
