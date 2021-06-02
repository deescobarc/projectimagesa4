class app_canvas {
    constructor(idCanvas,idImage, size) {
        this.idCanvas = idCanvas;
        this.canvas = document.getElementById(idCanvas);
        this.context = this.canvas.getContext( '2d');
        this.idImage = idImage;
        this.size = size;
    }
    loadPicture() {
        let imageObj = new Image();
        let imageReal = document.getElementById(this.idImage);
        let context = this.context;
        let canvas = this.canvas;
        let size = this.size;
        imageObj.src = imageReal.getAttribute('src');
        imageObj.onload = function () {
            // context.drawImage( imageObj, 0, 0 );
            debugger;
            let sourceWidth = imageObj.width;
            let sourceHeight = imageObj.height;
            let canvasWidth = 0;
            let canvasHeight = 0;

            //Se verifica si la altura o el ancho es mayor, para saber la orientación
            if(sourceHeight > sourceWidth){
                setSize(size.width, size.height);
                canvasWidth = size.width;
                canvasHeight = size.height;
            }else{
                setSize(size.height, size.width);
                canvasWidth = size.height;
                canvasHeight = size.width;
            }

            //Se verifica si la anchura o la altura son mayores al lienzo
            if(sourceHeight > canvasHeight || sourceWidth > canvasWidth ){
                context.drawImage( imageObj, 0, 0, sourceWidth, sourceHeight, 0, 0, canvasWidth, canvasHeight );
            }else{
                context.drawImage( imageObj, 0, 0, sourceWidth, sourceHeight );
            }

            this.style.display = 'none';

            function setSize(width, height){
                canvas.setAttribute('width', width + 'px');
                canvas.setAttribute('height', height + 'px');
            }
        }
    }

}

function init(){
    let a4 = {width: 796, height: 1123};
    let appCanvas = new app_canvas("canvas", 'imageLoad', a4);
    appCanvas.loadPicture();
}

export{
    init
}
