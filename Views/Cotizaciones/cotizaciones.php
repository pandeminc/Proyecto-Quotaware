<?php 
    headerAdmin($data); 
    //getModal('modalProductos',$data);
?>
  <div id="divModal"></div>
  <main class="app-content">    
      <div class="app-title">
        <div>
            <h1><i class="fa fa-shopping-bag"></i> <?= $data['page_title'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/cotizaciones"><?= $data['page_title'] ?></a></li> <!--direccionar a vista cotizaciones -->
        </ul>
      </div>
        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableCotizaciones">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Fecha</th>
                          <th>Monto</th>
                          <th>Nota</th>
                          <th>Estado Cotización</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </main>
<?php footerAdmin($data); ?>