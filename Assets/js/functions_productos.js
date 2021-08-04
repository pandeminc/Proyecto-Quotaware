let tableProductos;
let divLoading = document.querySelector("#divLoading");
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});

window.addEventListener('load', function(){
    tableProductos = $('#tableProductos').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Productos/getProductos",
            "dataSrc":""
        },
        "columns":[
            {"data":"idproducto"},
            {"data":"codigo"},
            {"data":"nombre"},
            {"data":"precio"},
            {"data":"options"}
        ],
        "columnDefs": [
                        //{ 'className': "textcenter", "targets": [3] },
                        //{ 'className': "textright", "targets": [3] },
                        //{ 'className': "textcenter", "targets": [5] },
                      ],

        'dom': 'lBfrtip',
        'buttons': [ // botones para exportar
            /*{
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success"
            }*/,{
                "extend": "pdfHtml5", // boton para exportar a PDF
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions":{
                    "columns": [0,1,2,3]
                }// para mostrar las columnas que queremos
            },/*{
                "extend": "csvHtml5", // boton para copiar la tabla
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info"
            }*/
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

    if(document.querySelector("#formProductos")){
        let formProductos = document.querySelector("#formProductos");
        formProductos.onsubmit = function(e){
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombre').value;
            let intCodigo = document.querySelector('#txtCodigo').value;
            let strPrecio = document.querySelector('#txtPrecio').value;
            if(strNombre == '' || intCodigo == '' || strPrecio == '' )
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
            if(intCodigo.length < 4){// validar codigo
                swal("Atención", "El código debe ser mayor que 4 dígitos." , "error");
                return false;
            }
            divLoading.style.display = "flex";
            tinyMCE.triggerSave();
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Productos/setProducto'; 
            let formData = new FormData(formProductos);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    //console.log(request.responseText);
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("", objData, "success");
                        document.querySelector('#idProducto').value = objData.idproducto;
                        tableProductos.api().ajax.reload();
                    }else{
                        swal("Error", objData, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }

        }
    }

}, false);

tinymce.init({
	selector: '#txtDescripcion',
	width: "100%",
    height: 300,    
    statubar: true,
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
});

function openModal()
{
    //rowTable = "";
    document.querySelector('#idProducto').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Producto o Servicio";
    document.querySelector("#formProductos").reset();
    $('#modalFormProductos').modal('show');

}