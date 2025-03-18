var __app = {
    urlbase: null,
    init: function () {
        __app.urlbase = ($('body').attr('data-urlbase')) ? $('body').attr('data-urlbase').trim('/') + '/' : '/';
    },
    urlTo: function (url) {
        return __app.urlbase + url;
    },
    validarRespuesta: function (respuesta) {
        if ((respuesta && !respuesta.codigo) || respuesta.codigo < 0) {
            respuesta = false;
        }
        return respuesta;
    },
    parsearRespuesta: function (respuesta) {
        var datos = __app.validarRespuesta(respuesta);
        if (datos) {
            return datos.datos;
        } else {
            return false;
        }
    },
    detenerEvento: function (e) {
        if (e) {
            if (e.preventDefault) {
                e.preventDefault();
            }
            if (e.stopPropagation) {
                e.stopPropagation();
            }
            if (!!e.returnValue) {
                e.returnValue = false;
            }
        }
        return;
    },
    get: function (url, data) {
        var ajax = __app.getObjectAjax(url, data, "GET");
        return $.extend({ajax: ajax}, __app.methods);
    },
    post: function (url, data) {
        var ajax = __app.getObjectAjax(url, data, "POST");
        return $.extend({ajax: ajax}, __app.methods);
    },
    methods: {
        beforeSend: function (callback) {
            this.ajax.beforeSend = callback;
            return this;
        },
        complete: function (callback) {
            this.ajax.complete = callback;
            return this;
        },
        success: function (callback) {
            this.ajax.success = callback;
            return this;
        },
        error: function (callback) {
            this.ajax.error = callback;
            return this;
        },
        send: function () {
            __app.ajax(this.ajax);

           /*  __app.ajax = function (args) {
                var ajax = {};
                ajax.url = (__app.urlbase + args.url);
                ajax.type = args.type ? args.type : "POST";
                ajax.dataType = args.dataType ? args.dataType : "json";
                ajax.beforeSend = args.beforeSend;
                ajax.complete = args.complete;
                ajax.success = args.success;
                ajax.error = args.error;
            
                // Detectar si args.data contiene un File o Blob
                let containsFile = false;
                if (args.data instanceof FormData) {
                    ajax.data = args.data; // Si ya es FormData, se usa directamente
                    containsFile = true;
                } else if (typeof args.data === "object" && args.data !== null) {
                    for (let key in args.data) {
                        if (args.data[key] instanceof File || args.data[key] instanceof Blob) {
                            containsFile = true;
                            break;
                        }
                    }
                }
            
                // Si hay un archivo, usar FormData
                if (containsFile) {
                    let formData = new FormData();
                    for (let key in args.data) {
                        formData.append(key, args.data[key]);
                    }
                    ajax.data = formData;
                    ajax.processData = false;
                    ajax.contentType = false;
                } else {
                    ajax.data = args.data; // Enviar datos normalmente si no hay archivos
                }
            
                $.ajax(ajax);
            }; */
        }
    },
    getObjectAjax: function (url, data, method) {
        var ajax = new Object();
        ajax.url = url;
        ajax.data = data;
        ajax.type = method;
        return ajax;
    },
    ajax: function (args) {
        /* var ajax = new Object();
        ajax.url = (__app.urlbase + args.url);
        ajax.type = (args.type) ? args.type : "POST";
        ajax.data = (args.data);
        ajax.dataType = (args.dataType) ? args.dataType : "json";
        ajax.beforeSend = args.beforeSend;
        ajax.complete = args.complete;
        ajax.success = args.success;
        ajax.error = args.error;
        $.ajax(ajax); */


        var ajax = {};
                ajax.url = (__app.urlbase + args.url);
                ajax.type = args.type ? args.type : "POST";
                ajax.dataType = args.dataType ? args.dataType : "json";
                ajax.beforeSend = args.beforeSend;
                ajax.complete = args.complete;
                ajax.success = args.success;
                ajax.error = args.error;
            
                // Detectar si args.data contiene un File o Blob
                let containsFile = false;
                if (args.data instanceof FormData) {
                    ajax.data = args.data; // Si ya es FormData, se usa directamente
                    containsFile = true;
                } else if (typeof args.data === "object" && args.data !== null) {
                    for (let key in args.data) {
                        if (args.data[key] instanceof File || args.data[key] instanceof Blob) {
                            containsFile = true;
                            break;
                        }
                    }
                }
            
                // Si hay un archivo, usar FormData
                if (containsFile) {
                    let formData = new FormData();
                    for (let key in args.data) {
                        formData.append(key, args.data[key]);
                    }
                    ajax.data = formData;
                    ajax.processData = false;
                    ajax.contentType = false;
                } else {
                    ajax.data = args.data; // Enviar datos normalmente si no hay archivos
                }
            
                $.ajax(ajax);
    },
};
$(__app.init());