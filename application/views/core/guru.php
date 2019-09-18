<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar guru 
        <button class="btn btn-success btn-sm pull-right" onclick="tambah()">Tambah guru</button>
      </div>
      <input type="hidden" id="base_url" value="<?= base_url('guru') ?>">
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>#</th>
              <th>NIP</th>
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


<div class="modal fade" id="modal-hapus" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus guru</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <strong>Peringatan</strong>
        Data guru yang dipilih akan dihapus beserta dengan data yang berelasi dengan sekolah.
        <br /><br />
        Apakah anda yakin untuk menghapus data guru ?
      </div>
      <div class="modal-footer">
        <button type="button" id="btn-hapus" class="btn btn-danger btn-sm">Hapus</button>
        <a href="#" class="btn btn-primary btn-sm" data-dismiss="modal">Tutup</a>
      </div>
    </div>
  </div>
</div>


<script>
  $(function() {
    let table = $('#appTable').DataTable( {
      "ajax"  : '<?= base_url('guru/data'); ?>',
      "order" : [[2, 'asc' ]],
      "columns": [
        {
          "data"    : null,
          "width"   : "50px",
          "sClass"  : "text-center",
          "orderable": false
        },
        { "data"    : "nip" },
        { "data"    : "nama" },
        { "data"    : "aksi","orderable": false },
        { "data"    : "check","orderable": false }
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