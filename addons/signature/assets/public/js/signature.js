const canvas = document.getElementById("signature-canvas");
const ctx = canvas.getContext("2d");
const clearButton = document.getElementById("clear-button");

let isDrawing = false;

// Set up the canvas
canvas.width = 300;
canvas.height = 150;
ctx.lineWidth = 2;
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

function clearCanvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

// Event listeners
canvas.addEventListener("mousedown", startDrawing);
canvas.addEventListener("mousemove", draw);
canvas.addEventListener("mouseup", stopDrawing);
canvas.addEventListener("mouseout", stopDrawing);

clearButton.addEventListener("click", clearCanvas);
