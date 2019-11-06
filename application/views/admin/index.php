<div class="row">
  <div class="col-lg-12"> 
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar log hari ini
        <!-- <a href="<?= base_url('sekolah/cctv'); ?>" class="btn btn-success btn-sm pull-right ml-1">Pantau CCTV</a>    -->
        <?php if ($this->session->userdata('flatform') == 'Android'):  ?> 
        <a target="_blank" rel="alternate" href="android-app://com.hikvision.hikconnect" class="btn btn-success btn-sm pull-right ml-1">Pantau CCTV</a>
        <?php else: ?>
          <a target="_blank" href="https://sgpauth.hik-connect.com/signIn?from=c17392dc2e6c405a931b&r=4952932725966710270&returnUrl=http%3A%2F%2Fwww.hik-connect.com%2Fdevices%2Fpage&host=www.hik-connect.com" class="btn btn-success btn-sm pull-right ml-1">Pantau CCTV</a>
        <?php endif; ?>
        <action android:name="android.intent.action.VIEW" />
       <button id="refresh" class="btn btn-primary btn-sm pull-right"><i class="icon-refresh"></i> Refresh table</button>   
      </div>

      <input type="hidden" id="base_url" value="<?= base_url('guru') ?>">
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        
        <div class="table-responsive-sm">
          <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama sekolah</th>
                <th width="130px">Jam</th>
                <th>Kelas</th>
                <th>Guru</th>
                <th>Status</th>
                <th>keterangan</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>  
        </div>
        
      </div>
      <div class="card-footer">
         <span><i class="icon-check text-success"></i> Guru masuk</span> <br>
        <span><i class="icon-close text-danger"></i> Guru tidak masuk</span> <br>
        <span><i class="icon-clock text-warning"></i> Guru terlambat masuk kelas</span>
      </div>
    </form>
    </div>
  </div>
</div>

<script>
  $(function() {
    let table = $('#appTable').DataTable( {
      "ajax"  : '<?= base_url('panel/data'); ?>',
      "order" : [[2, 'desc' ]],
      "responsive": true,
      "columns": [
        {
          "data"    : null,
          "width"   : "50px",
          "sClass"  : "text-center",
          "orderable": false
        },
        { "data"    : "sekolah" },
        { "data"    : "jadwal" },
        { "data"    : "kelas" },
        { "data"    : "guru" },
        { "data"    : "status" },
        { "data"    : "keterangan" },
      ]
    });

    table.on( 'order.dt search.dt', function() {
       table.column(0, { search : 'applied', order:'applied'}).nodes().
        each( function(cell, i) {
          cell.innerHTML = i+1;
        });
    }).draw();  

    $('#refresh').click(refresh_table)
  })
</script>