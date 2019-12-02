<div class="row">
  <div class="col-lg-12"> 
    <div class="card">
      <div class="card-header py-3">
      	Upload guru excel
      	<a href="<?= base_url('public/download/template_guru_upload.xlsx') ?>" target="_blank" class="btn btn-sm btn-success pull-right">Download template</a>
      </div>
      <form method="post" enctype="multipart/form-data">
	    <div class="card-body">
	      <div class="form-group">
	        <input type="hidden" id="url" value="<?= base_url('guru/import') ?>">
	        <input type="file" name="import" id="fileupload">
					<button class="btn btn-sm btn-success rounded-0" type="button" id="uplFile">Upload</button>
	      </div>
	      <div class="progress">
	        <div class="progress-bar progress-bar-striped bg-info" id="progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100">
	      </div>
	      </div>
	    </div>
      </form> 
    </div>
  </div>
</div>