<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar interval 
        <button class="btn btn-success btn-sm pull-right" onclick="tambah()">Tambah interval</button>
      </div>
      <input type="hidden" id="base_url" value="<?= base_url('jadwal') ?>">
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th width="50px">#</th>
              <th width="150px">Hari</th>
              <th>Interval</th>
            </tr> 
          </thead>
          <tbody>
            <?php $no=1; foreach($datas as $d): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $d->nama ?></td>
              <?php 
                $data = $this->db->get_where('seling',['hari_id' => $d->id,'sekolah_id' => user()->sekolah_id])->result();
              ?>
              <td>
                <?php foreach($data as $ds): ?>
                  <button class="btn btn-primary btn-sm" onclick="edit('<?= $ds->id ?>')"><?= $ds->dari ?> - <?= $ds->sampai ?></button>
                <?php endforeach; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
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
            <label>Hari</label>
            <select class="form-control" name="hari_id">
              <?php foreach($datas as $d): ?>
                <option value="<?= $d->id ?>"><?= $d->nama ?></option>
              <?php endforeach; ?>
            </select>
          </div>
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
            <input type="hidden" name="hari_id" id="hari_id" value="1">
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
    showLoading();
    $.getJSON('<?= base_url('interval/show/') ?>'+id, function(data) {
      if(data.data == 1) {
        $('#id').val(data.id)
        $('#dari').val(data.dari)
        $('#sampai').val(data.sampai)

        $('#form-pesan').html('');
        $('#modal-interval').modal('show')
      }
      hideLoading()
    })
  }

  function hapus()
  {
    id = $('#id').val();
    window.location = "<?= base_url('interval/destroy/') ?>"+id;
  }
</script>