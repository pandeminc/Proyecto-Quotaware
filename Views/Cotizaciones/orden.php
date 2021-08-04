<?php headerAdmin($data); ?>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-file-text-o"></i> <?= $data['page_title'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href=" <?= base_url(); ?>/cotizaciones"> Cotizaciones</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <?php 
                if(empty($data['arrCotizacion'])){
            ?>
           <p>Datos no encontrados </p>
            <?php }else{
                $cliente = $data['arrCotizacion']['cliente'];
                $orden = $data['arrCotizacion']['orden'];
                $detalle = $data['arrCotizacion']['detalle'];
            ?>  
            <section id="sCotizacion"class="invoice">
              <div class="row mb-4">
                <div class="col-6">
                  <h2 class="page-header"><img src="<?= media(); ?>/empresa/images/logo_empresa.png" ></h2>
                </div>
                <div class="col-6">
                  <h5 class="text-right">Fecha: <?= $orden['fecha'] ?></h5>
                </div>
              </div>
              <div class="row invoice-info">
                <div class="col-4">
                  <address><strong><?= NOMBRE_EMPESA; ?></strong><br>
                  <?= DIRECCION; ?><br>
                  <?= TELEMPRESA; ?><br>
                  <?= EMAIL_EMPRESA; ?><br>
                  <?= WEB_EMPRESA; ?>
                </address>
                </div>
                <div class="col-4">
                  <address><strong><?= $cliente['nombres'].' '.$cliente['apellidos'] ?></strong><br>
                  <b>Tel: </b> <?= $cliente['telefono'] ?><br>
                  <b>Email: </b> <?= $cliente['email_user'] ?> <br>
                  <b>Dir: </b> <?= $cliente['direccion'] ?><br>
                  <b>Razón Social: </b> <?= $cliente['nit'] ?><br>
                  <b>Rubro: </b> <?= $cliente['nombrefiscal'] ?><br>
                  <b>Ciudad: </b> <?= $cliente['direccionfiscal'] ?><br>

                </address>
                </div>
                <div class="col-4"><b>Nro Cotización: </b><?= $orden['idpedido'] ?></br>
                  <b>Estado: </b> <?= $orden['estadotipo'] ?><br>
                  <b>Monto: </b> <?= SMONEY.' '. formatMoney($orden['monto']) ?><br>
                  <b>Nota: </b> <?= $orden['nota'] ?>

                </div>
              </div>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Descripción</th>
                        <th class="text-right">Precio</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-right">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $subtotal = 0;
                            
                            if(count($detalle) > 0){
                                foreach ($detalle as $producto){
                                    $subtotal += $producto['cantidad'] * $producto['precio'];
                        ?>
                      <tr>
                        <td><?= $producto['producto'] ?></td>
                        <td class="text-right"><?= SMONEY.' '. formatMoney($producto['precio']) ?></td>
                        <td class="text-center"><?= $producto['cantidad'] ?></td>
                        <td class="text-right"><?= SMONEY.' '. formatMoney($producto['cantidad'] * $producto['precio']) ?></td>
                      </tr>
                       <?php 
                            }
                        }

                       ?>             

                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Monto Total:</th>
                        <td class="text-right"><?= SMONEY.' '. formatMoney($subtotal) ?></td>
                    </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="row d-print-none mt-2">
                <div class="col-12 text-right"><a class="btn btn-primary" href="javascript:window.print('#sCotizacion');" ><i class="fa fa-print"></i> Imprimir</a></div>
              </div>
            </section>
            <p>Términos y Condiciones: Al validar este documento, usted acepta todas las siguientes condiciones: Los servicios prestados tienen una garantía de tres meses. Los valores señalados son valores Netos no incluyen IVA. Los valores serán considerados validos en un plazo MAXIMO de 15 días a partir de la fecha de entrega de esta cotización. El pago por nuestros servicios deberá ser anticipado
                al menos en un 50% antes de comenzar los trabajos. Plazo de funcionamiento total de la pagina web con todas sus funcionalidades es de 30 días hábiles, desde el momento del pago.</p>
            <p>En espera que la presente cotización cumpla con lo solicitado, le saluda muy atentamente.</p>
            <?php }  ?>
          </div>
        </div>
      </div>
    </main>
<?php footerAdmin($data); ?>    