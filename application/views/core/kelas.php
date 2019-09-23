<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar kelas 
        <button class="btn btn-success btn-sm pull-right" onclick="tambah()">Tambah kelas</button>
      </div>
      <input type="hidden" id="base_url" value="<?= base_url('kelas') ?>">
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Tingkat</th>
              <th>Nama</th>
              <th>Aksi</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <button type="button" id="btn-edit-hapus" class="btn btn-primary btn-sm">Hapus</button>
        <button type="button" id="btn-edit-pilih" class="btn btn-danger btn-sm pull-right">Pilih Semua</button>
      </div>
    </form>
    </div>
  </div>
</div>

<script>
  $(function() {
    let table = $('#appTable').DataTable( {
      "ajax" : '<?= base_url('kelas/data'); ?>',
      "order" : [[2,'asc']],
      "columns" : [
        {
          "data"    : null,
          "width"   : "50px",
          "sClass"  : "text-center",
          "orderable": false
        },
        { "data" : "tingkat" },
        { "data" : "nama" },
        { "data" : "aksi",
          "orderable" : false,
          "width": "50px"
        },
        { "data"    : "check",
          "orderable": false,
          "width"   : "10px", 
        }
      ]
    });
    
    table.on( 'order.dt search.dt', function() {
      table.column(0, { search : 'applied', order:'applied'}).nodes().
       each( function(cell, i) {
         cell.innerHTML = i+1;
       });
    }).draw();  

  })
</script>