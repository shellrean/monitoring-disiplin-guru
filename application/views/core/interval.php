<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar interval 
        <button class="btn btn-success btn-sm pull-right" onclick="tambah()">Tambah interval</button>
      </div>
      <input type="hidden" id="base_url" value="<?= base_url('jadwal') ?>">
      <div class="card-body">
        <div class="table-responsive-sm">
        <table class="table table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>Interval</th>
            </tr> 
          </thead>
          <tbody>
            <tr>
              <td>
                <?php if($datas): ?>
                <?php foreach($datas as $ds): ?>
                  <button class="btn btn-primary btn-sm my-1 mx-1" onclick="edit('<?= $ds->id ?>')"><?= $ds->dari ?> - <?= $ds->sampai ?></button>
                <?php endforeach; ?>
                <?php else: ?>
                  <i>Belum ada data interval yang dimasukkan</i>
                <?php endif; ?>
              </td>
            </tr>
          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modal-tambah" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?= base_url('interval/store') ?>" >
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah interval</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan"></div>
          <div class="form-group">
            <label>Dari</label>
            <input type="time" name="dari" class="form-control">
          </div>
          <div class="form-group">
            <label>Sampai</label>
            <input type="time" name="sampai" class="form-control">
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
<div class="modal fade" id="modal-interval" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?= base_url('interval/update') ?>" >
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail interval</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan"></div>
          <div class="form-group">
            <label>Dari</label>
            <input type="hidden" name="id" id="id">
            <input type="time" name="dari" id="dari" class="form-control">
          </div>
          <div class="form-group">
            <label>Sampai</label>
            <input type="time" name="sampai" id="sampai" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" onclick="hapus()"class="btn btn-danger mr-auto" >Hapus</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" id="tambah-simpan" class="btn btn-success">Simpan</button>
        </div>
    </div>
    </form>
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
      $.getJSON('<?= base_url('interval/show/') ?>'+id, function(data) {
        if(data.data == 1) {
          $('#id').val(data.id)
          $('#dari').val(data.dari)
          $('#sampai').val(data.sampai)

          $('#form-pesan').html('');
          $('#modal-interval').modal('show')
        }
      })
    })
  }

  function hapus()
  {
    id = $('#id').val();
    window.location = "<?= base_url('interval/destroy/') ?>"+id;
  }
</script>