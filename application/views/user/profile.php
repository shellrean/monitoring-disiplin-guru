 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-cogs"></i> Profile 
      </div>
      <form id="form-profile">
      <input type="hidden" id="base_url" value="<?= base_url('user') ?>">
      <div class="card-body">
        <div id="form-pesan"></div>
        <div class="form-group">
          <label>User login</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= user()->username ?>">
        </div>
        <div class="form-group">
          <label>Nama</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Nama" value="<?= user()->name ?>">
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="text" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-success btn-sm">
          Simpan
        </button>
      </div>
      <div class="card-footer">
        <span><i class="icon-info text-info"></i> 
        Password biarkan kosong bila tidak mau diubah</span> <br>
        <span><i class="icon-info text-info"></i> 
        Diwajibkan logout dan login kembali bila user login diubah</span> <br>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
  $('#form-profile').submit(function(e){
    e.preventDefault()
    let base = $('#base_url').val()

    Pace.restart();
    Pace.track(function () {
      $.ajax({
        url: base+'/update_profile',
        type: 'POST',
        data: $('#form-profile').serialize(),
        cache: false,
        success(res) {
          let obj = $.parseJSON(res);
          if(obj.status == 1) {
            hideLoading();
            notify_success(obj.pesan)
          }
          else {
            hideLoading()
            $('#form-pesan').html(pesan_err(obj.pesan));
          }
        }
      })
    })
  })
</script>