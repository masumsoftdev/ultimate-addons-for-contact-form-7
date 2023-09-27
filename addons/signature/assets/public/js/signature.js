
/** Making Canvas */
const canvas = document.getElementById("signature-canvas");
const ctx = canvas.getContext("2d");
const clearButton = document.getElementById("clear-button");

let isDrawing = false;

// Set up the canvas
canvas.width = 500;
canvas.height = 150;
canvas.style.border= "1px solid #000";
canvas.style.cursor = "crosshair";
ctx.lineWidth = 1;
ctx.strokeStyle = "#000";

function startDrawing(e) {
    isDrawing = true;
    ctx.beginPath();
    ctx.moveTo(e.clientX - canvas.getBoundingClientRect().left, e.clientY - canvas.getBoundingClientRect().top);
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

 convertButton.addEventListener("click", (e) => {

    e.preventDefault();
     const imageDataURL = signature_canvas.toDataURL("image/png");

 
     const image = new Image();
     image.src = imageDataURL;
     image.id = 'uploadedImage'


     var img_id_special = document.querySelector('#img_id_special');
     document.body.appendChild(image);

     console.log(image)


    const imageUrl = document.getElementById('uploadedImage').src;
  
    // const fileInput = document.getElementById('img_id_special');
  
    // fetch(imageUrl)
    //   .then(response => response.blob())
    //   .then(blob => {
    //     const fileName = imageUrl.substring(imageUrl.lastIndexOf('/') + 1);
    //     const file = new File([blob], fileName, { type: blob.type });
  
    //     const fileList = new DataTransfer();
    //     fileList.items.add(file);
  
    //     fileInput.files = fileList.files;
        
    //     fileInput.dispatchEvent(new Event('change'));
    //   })
    //   .catch(error => {
    //     console.error(error);
    //   });



   
        const imagePreview = document.getElementById('uploadedImage');
        const fileInput = document.getElementById('img_id_special');
      
        // Create a Blob from the data URL of the image
        const dataUrl = imagePreview.src;
        const blob = dataURLtoBlob(dataUrl);
      
        // Create a File object from the Blob
        const fileName = 'image.jpg'; // You can set the desired file name
        const file = new File([blob], fileName);
      
        // Create a FileList with the File object
        const fileList = new DataTransfer();
        fileList.items.add(file);
      
        // Set the FileList to the file input
        fileInput.files = fileList.files;
      
      
      // Function to convert a data URL to a Blob
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