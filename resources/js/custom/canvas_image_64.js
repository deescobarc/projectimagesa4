class app_canvas {
    constructor(idCanvas,idImage) {
        this.idCanvas = idCanvas;
        this.canvas = document.getElementById(idCanvas);
        this.context = this.canvas.getContext( '2d');
        this.idImage = idImage;
    }
    loadPicture() {
        let imageObj = new Image();
        imageObj.src = document.getElementById(this.idImage).getAttribute('src');
        let context = this.context;
        imageObj.onload = function () {
            context.drawImage( imageObj, 0, 0 );
        }
    }
}

function init(){
    let appCanvas = new app_canvas("canvas", 'imageLoad');
    appCanvas.loadPicture();
}

export{
    init
}
