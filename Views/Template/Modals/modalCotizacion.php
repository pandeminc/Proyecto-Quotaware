<div class="modal fade" id="modalFormCotizacion" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Actualizar Cotización</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

            <form id="formUpdateCotizacion" name="formUpdateCotizacion" class="form-horizontal">
              <input type="hidden" id="idpedido" name="idpedido" value="<?= $data['orden']['idpedido'] ?>" require=""> 
              <table class="table table-bordered">
                  <tbody>
                      <tr>
                          <td width="210">Nro. Cotización</td>
                          <td><?= $data['orden']['idpedido'] ?></td>
                      </tr>
                      <tr>
                          <td>Cliente:</td>
                          <td><?= $data['cliente']['nombres'].' '.$data['cliente']['apellidos'] ?></td>
                      </tr>
                      <tr>
                          <td>Nota:</td>
                          <td><?= $data['orden']['nota'] ?></td>
                      </tr>
                      <tr>
                          <td>Monto Total:</td>
                          <td><?= SMONEY.' '.$data['orden']['monto'] ?></td>
                      </tr>
                      <tr>
                          <td>Estado:</td>
                          <td>
                              <select name="listEstado" id="listEstado" class="form-control selectpicker" data-live.search="true" require="">
                                <?php
                                 
                                for ($i=0; $i < count(STATUS); $i++){
                                    $selected = "";
                                    if( STATUS[$i] == $data['orden']['estadotipo']){
                                        $selected = " selected ";
                                    }
                                ?>                                                    
                                 <option value="<?= STATUS[$i] ?>" <?= $selected ?> ><?= STATUS[$i] ?></option>
                                 <?php } ?>
                              </select>
                          </td>
                      </tr>

                  </tbody>
              </table>
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-info" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span>Actualizar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>

            </form>
      </div>
    </div>
  </div>
</div>