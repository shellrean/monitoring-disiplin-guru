<div class="row">
  <div class="col-lg-12"> 
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar guru 
        <a href="<?= base_url('guru/upload') ?>" class="btn btn-success btn-sm pull-right ml-1">Upload guru</a>
        <button class="btn btn-success btn-sm pull-right" onclick="tambah()">Tambah guru</button>
      </div>
      <input type="hidden" id="base_url" value="<?= base_url('guru') ?>">
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        <div class="table-responsive-sm">
        <table class="table table-bordered table-striped table-sm" id="appTable" style="min-width: 620px">
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
      </div>
      <div class="card-footer">
        <button type="button" id="btn-edit-hapus" class="btn btn-primary btn-sm">Hapus</button>
        <button type="button" id="btn-edit-pilih" class="btn btn-danger btn-sm pull-right">Pilih Semua</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modal-tambah" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form-tambah" >
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah guru</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan"></div>
          <div class="form-group">
            <label>NIP</label>
            <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP">
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" id="tambah-simpan" class="btn btn-success">Tambah</button>
        </div>
    </div>
    </form>
  </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modal-edit" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form-edit" >
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit guru</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan-edit"></div>
          <div class="form-group">
            <input type="hidden" id="e-id" name="id">
            <label>NIP</label>
            <input type="text" class="form-control" id="e-nip" name="nip" placeholder="NIP">
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" id="e-nama" name="nama" placeholder="Nama">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" id="edit-simpan" class="btn btn-success">Simpan</button>
        </div>
    </div>
    </form>
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
        Data guru yang dipilih akan dihapus beserta dengan data yang berelasi dengan tabel guru.
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
  function tambah()
  {
    $('#nip').val('')
    $('#nama').val('')
    
    $('#form-pesan').html('');
    $('#modal-tambah').modal('show')
  }

  function edit(id)
  {
    Pace.restart();
    Pace.track(function () {
      $.getJSON('<?= base_url('guru/show/') ?>'+id, function(data) {
        if(data.data == 1) {
          $('#e-id').val(data.id)
          $('#e-nip').val(data.nip)
          $('#e-nama').val(data.nama)

          $('#form-pesan-edit').html('');
          $('#modal-edit').modal('show')
        }
      })
    })
  }

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
        { "data"    : "aksi",
          "orderable": false,
          "width"   : "50px",
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