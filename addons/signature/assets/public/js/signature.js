
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

 convertButton.addEventListener("click", () => {


     const imageDataURL = signature_canvas.toDataURL("image/png");

 
     const image = new Image();
     image.src = imageDataURL;


     var img_id_special = document.querySelector('#img_id_special');
    //  document.body.appendChild(image);
     document.body.appendChild(image);

 });

















/** Handlilng Input Field & Attribute the Signature as Image*/
var img_id_special = document.querySelector('#img_id_special');

img_id_special.addEventListener('click', function (e) {
    // e.preventDefault();
    // alert();

    // this.src = 'img/s.png';
});