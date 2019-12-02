<div class="row">
  <div class="col-lg-12">
     <?= $this->session->flashdata('message'); ?>
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Manage jadwal guru
        <button class="btn btn-success btn-sm pull-right" onclick="tambah()">Tambah jadwal</button>
      </div>
      <input type="hidden" id="base_url" value="<?= base_url('jadwal') ?>">
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        <table width="20%">
          <tr>
            <td>Nama guru</td> <td>:</td>
            <td><?= $guru->nama ?></td>
          </tr>
          <tr>
            <td>Nip</td> <td>:</td>
            <td><?= $guru->nip ?></td>
          </tr>
        </table>
        <br>
        <div class="table-responsive-sm">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Hari</th>
              <th>Jam</th>
              <th>Kelas</th>
              <th>Aksi</th>
              <th>Pilih</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        </div>
      </div>
      </form>
      <div class="card-footer">
        <a href="<?= base_url('jadwal') ?>" class="btn btn-success btn-sm">Kembali</a>
        <button type="button" id="btn-edit-hapus" class="btn btn-primary btn-sm">Hapus</button>
        <button type="button" id="btn-edit-pilih" class="btn btn-danger btn-sm pull-right">Pilih Semua</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modal-tambah" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form-tambah">
      <input type="hidden" name="guru_id" value="<?= $this->uri->segment(3) ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah jadwal</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan"></div>
          <div class="form-group">
            <label>Hari</label>
            <select name="hari_id" class="form-control">
              <?php foreach($hari as $h): ?>
                <option value="<?= $h->id ?>"><?= $h->nama ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Interval</label>
            <select name="seling_id" class="form-control">
              <?php foreach($interval as $i): ?>
                <option value="<?= $i->id ?>"><?= $i->dari ?> - <?= $i->sampai ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Kelas</label>
            <select name="kelas_id" class="form-control">
              <?php foreach($kelas as $i): ?>
                <option value="<?= $i->id ?>"><?= $i->nama ?></option>
              <?php endforeach; ?>
            </select>
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
    <form id="form-edit">
      <input type="hidden" name="guru_id" value="<?= $this->uri->segment(3) ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit jadwal</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan-edit"></div>
          <div class="form-group">
            <input type="hidden" name="id" id="edit-id">
            <label>Hari</label>
            <select name="hari_id" id="hari_id" class="form-control">
              <?php foreach($hari as $h): ?>
                <option value="<?= $h->id ?>"><?= $h->nama ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Interval</label>
            <select name="seling_id" id="seling_id" class="form-control">
              <?php foreach($interval as $i): ?>
                <option value="<?= $i->id ?>"><?= $i->dari ?> - <?= $i->sampai ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Kelas</label>
            <select name="kelas_id" id="kelas_id" class="form-control">
              <?php foreach($kelas as $i): ?>
                <option value="<?= $i->id ?>"><?= $i->nama ?></option>
              <?php endforeach; ?>
            </select>
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
        <h5 class="modal-title" id="exampleModalLabel">Hapus jadwal</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <strong>Peringatan</strong>
        Jadwal yang dipilih akan dihapus beserta dengan data yang berelasi dengannya.
        <br /><br />
        Apakah anda yakin untuk menghapus jadwal ?
      </div>
      <div class="modal-footer">
        <button type="button" id="btn-hapus" class="btn btn-danger btn-sm">Hapus</button>
        <a href="#" class="btn btn-primary btn-sm" data-dismiss="modal">Tutup</a>
      </div>
    </div>
  </div>

<script>
  function tambah()
  { 
    $('#form-pesan').html('');
    $('#modal-tambah').modal('show')
  }

  function edit(id)
  {
    Pace.restart();
    Pace.track(function () {
      $.getJSON('<?= base_url('jadwal/show/') ?>'+id,function(data) {
        if(data.data == 1) {
          $('#edit-id').val(data.id)
          $('#hari_id').val(data.hari_id)
          $('#seling_id').val(data.seling_id)
          $('#kelas_id').val(data.kelas_id)

          $('#form-pesan-edit').html('');
          $('#modal-edit').modal('show')
        }
        hideLoading();
      })
    })
  }

  $(function() {
    let table = $('#appTable').DataTable({
      "processing" : true,
      "ajax"  : '<?= base_url('jadwal/data/'.$this->uri->segment(3)) ?>',
      "order" : [[2, 'asc' ]],
      "columns": [
        {
          "data"    : null,
          "width"   : "30px",
          "sClass"  : "text-center",
          "orderable": false
        },
        { "data"    : "hari" },
        { "data"    : "seling" },
        { "data"    : "kelas" },
        { "data"    : "aksi",
          "orderable": false,
          "width"   : "50px",
        },
        { "data"    : "check",
          "orderable": false,
          "width"   : "10px", 
        }
      ]
    })

    table.on( 'order.dt search.dt', function() {
       table.column(0, { search : 'applied', order:'applied'}).nodes().
        each( function(cell, i) {
          cell.innerHTML = i+1;
        });
    }).draw();   
  })
</script>