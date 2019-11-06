<div class="row">
  <div class="col-lg-12"> 
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar cctv 
      </div>
      <div class="card-body">
        <div class="form-group">
        <select class="form-control col-md-6" id="kelas_id">
          <?php foreach($kelas as $k): ?>
          <option value="<?= $k->link; ?>">
            <?= kelas($k->kelas_id); ?>
          </option>
          <?php endforeach; ?>
        </select>
        </div>
        <img src="http://43.225.67.241/" class="img-thumbs" width="230px">
      </div>
    </div>
  </div> 
</div>

