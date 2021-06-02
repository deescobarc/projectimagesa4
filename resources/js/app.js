require('./bootstrap');

require('alpinejs');

try {
    window.canvas_image_64 = require('./custom/canvas_image_64');

    $(document).ready(function () {
        window.canvas_image_64.init();
    });

} catch (e) {
    console.error('Ha ocurrido un error en la carga de plugins. Reintentar nuevo.');
    console.log(e);
}
