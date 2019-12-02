<div class="row">
  <div class="col-lg-12"> 
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Analisa
      </div>
      <div class="card-body">
        <div class="table-responsive-sm">
        <table class="table table-bordered table-striped table-sm" id="appTable"  style="min-width: 520px">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Sekolah</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        </div>
      </div>
      <div class="card-footer">
        
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-periode" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Report periode</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="hidden" id="analisa_id" >
          <input type="hidden" id="base_url" value="<?= base_url('analisa/periode/') ?>">
          <label>Dari</label>
          <input type="text" class="form-control datepicker" name="dari" id="dari">
        </div>
        <div class="form-group">
          <label>Sampai</label>
          <input type="text" class="form-control datepicker" name="sampai" id="sampai">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" id="btn-periode" class="btn btn-success">Lapor</button>
      </div>
    </div>
  </div>
</div>

<script>
  function periode(id)
  {
    $('#analisa_id').val(id)
    $('#modal-periode').modal('show');
  }
  $(function() {
    $('#btn-periode').click(function() {
      let dari = $('#dari').val()
      let sampai = $('#sampai').val()
      let url = $('#base_url').val()
      let id = $('#analisa_id').val()

      if(dari == '' || sampai == '') {
        notify_error('Silahkan pilih periode tanggal')
      }
      else {
        window.open(url+id+'/'+dari+'/'+sampai)
      }
    })

    let table = $('#appTable').DataTable( {
      "ajax"  : '<?= base_url('analisa/data'); ?>',
      "order" : [[2, 'asc' ]],
      "columns": [
        {
          "data"    : null,
          "width"   : "50px",
          "sClass"  : "text-center",
          "orderable": false
        },
        { "data"    : "sekolah" },
        { "data"    : "aksi",
          "orderable": false,
        },
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