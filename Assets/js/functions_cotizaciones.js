let tableCotizaciones;
let rowTable;
let divLoading = document.querySelector("#divLoading");
tableCotizaciones = $('#tableCotizaciones').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/Cotizaciones/getCotizaciones",
        "dataSrc":""
    },
    "columns":[
        {"data":"idpedido"},
        {"data":"fecha"},
        {"data":"monto"},
        {"data":"nota"},
        {"data":"estadotipo"},
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
                "columns": [0,1,2,3,4]
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

function fntEditInfo(element,idpedido){
    rowTable = element.parentNode.parentNode.parentNode;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Cotizaciones/getCotizacion/'+idpedido; 
    divLoading.style.display = "flex";
    request.open("POST",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector('#divModal').innerHTML = objData.html;
                $('#modalFormCotizacion').modal('show');
                $('select').selectpicker();
                fntUpdateInfo();
            }else{
                swal("Error", objData, "error");
            }
            divLoading.style.display = "none";
            return false;
        }
    }
}

function fntUpdateInfo(){
    let formUpdateCotizacion = document.querySelector("#formUpdateCotizacion");
    formUpdateCotizacion.onsubmit = function(e){
        e.preventDefault();
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Cotizaciones/setCotizacion/'; 
        divLoading.style.display = "flex";
        let formData = new FormData(formUpdateCotizacion);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState != 4 ) return;
            if(request.status == 200){
                let objData = JSON.parse(request.responseText);
                //console.log(request.responseText);
                if(objData.status){
                    swal("", objData.msg, "success");
                    $('#modalFormCotizacion').modal('hide');
                    rowTable.cells[4].textContent = document.querySelector("#listEstado").value;
                }else{
                    swal("Error", objData.msg, "error");
                }
                divLoading.style.display = "none";
                return false;

            }
        }

    }
}