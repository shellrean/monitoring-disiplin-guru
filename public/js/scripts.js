/** -------------------------------------
 * Kuswandi
 * 2019
 * scripts.js
 ** ------------------------------------ */

$(function() {
	$('.datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
      	changeYear: true,
      	showAnim: 'clip',
	});
	$('#btn-edit-pilih').click(function(e) {
		if($('#check').val() == 0) {
			$(':checkbox').each(function() {
				this.checked = true;
			});
			$('#check').val('1');
		} else {
			$(':checkbox').each(function() {
				this.checked = false;
			});
			$('#check').val('0');
		}
	})

	$('#btn-edit-hapus').click(function() {
		$('#modal-hapus').modal('show')
	})

	$('#btn-hapus').click(function() {
		$('#form-hapus').submit();
	}) 

	$('#form-hapus').submit(function(e) {
		let base = $('#base_url').val();

		e.preventDefault();
		Pace.restart();
    	Pace.track(function () {
			$.ajax({
				url: base+'/destroy',
				type: 'POST',
				data: $('#form-hapus').serialize(),
				cache: false,
				success(res) {
					let obj = $.parseJSON(res);
					if(obj.status == 1) {
						refresh_table();
						$('#modal-hapus').modal('hide');
						notify_success(obj.pesan);
						$('#check').val(0);
					} else {
						$('#modal-hapus').modal('hide');
						notify_error(obj.pesan);
					}
				}
			})
		})
	})

	$('#form-tambah').submit(function(e){
		e.preventDefault()
		let base = $('#base_url').val()

		Pace.restart();
    	Pace.track(function () {
			$.ajax({
				url: base+'/store',
				type: 'POST',
				data: $('#form-tambah').serialize(),
				cache: false,
				success(res) {
					let obj = $.parseJSON(res);
					if(obj.status == 1) {
						refresh_table()
						$('#modal-tambah').modal('hide')
						notify_success(obj.pesan)
					}
					else {
						$('#form-pesan').html(pesan_err(obj.pesan));
					}
				}
			})
		})
	})

	$('#form-edit').submit(function(e) {
      e.preventDefault();
      let base = $('#base_url').val()

      Pace.restart();
      Pace.track(function () {
	      $.ajax({
	        url: base+'/update',
	        type: "POST",
	        data:$('#form-edit').serialize(),
	        cache: false,
	        success(res) {
	          let obj = $.parseJSON(res);
	          if(obj.status  == 1) {
	            refresh_table();
	            $('#modal-edit').modal('hide');
	            notify_success(obj.pesan)
	          }
	          else {
	            $('#form-pesan-edit').html(pesan_err(obj.pesan))
	          }
	        }
	      })
	  })
  	})

  	$('#fileupload').fileupload({
  		url: $('#url').val(),
  		dataType: 'json',
		})
		.on('fileuploadprogress', function (e, data) {
	  	var progress = parseInt(data.loaded / data.total * 100, 10);
	  	$('#progress-bar').css('width',progress + '%');
		})
		.on('fileuploadsubmit', function (e, data) {
			$('#gagal').hide();
			var mapel = $('#category_id_upload').val();
			data.formData = {data: mapel};
			if(data.formData.mapel == ''){
				return false;
			}
			else{
				$('#progress').show();
			}
		})
		.on('fileuploaddone', function (e, data) {
			window.setTimeout(function() { 
				$('#progress-bar').css('width','0%');
			}, 1000);
			if(data.result.type == 'error') {
				notify_error(data.result.text)
			}
			else {
				notify_success(data.result.text)
			}
		})
		.prop('disabled', !$.support.fileInput)
		.parent().addClass($.support.fileInput ? undefined : 'disabled');
	})