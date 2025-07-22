<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
</script>
<?php endif; ?>

<?php 
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM blogs WHERE id = '{$_GET['id']}' ");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}
?>

<style>
	#cimg {
		max-width: 50%;
		object-fit: contain;
	}
</style>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<h5 class="card-title">Blog</h5>
		</div>
		<div class="card-body">
			<form id="blog" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

				<div class="form-group">
					<label class="control-label">Title</label>
					<input type="text" name="title" class="form-control" value="<?php echo isset($title) ? $title : '' ?>" required>
				</div>

				<div class="form-group">
					<label class="control-label">Date</label>
					<input type="date" name="date" class="form-control" value="<?php echo isset($date) ? $date : '' ?>" required>
				</div>

				<div class="form-group">
					<label class="control-label">Short Intro</label>
					<textarea name="intro" rows="3" class="form-control"><?php echo isset($intro) ? $intro : '' ?></textarea>
				</div>

				<div class="form-group">
					<label class="control-label">Description</label>
					<textarea name="description" cols="30" rows="10" class="form-control summernote"><?php echo isset($description) ? html_entity_decode($description) : '' ?></textarea>
				</div>

				<div class="form-group">
					<label class="control-label">Reference Links (optional)</label>
					<textarea name="reference_links" rows="3" class="form-control"><?php echo isset($reference_links) ? $reference_links : '' ?></textarea>
				</div>

				<div class="form-group">
					<label class="control-label">Blog Image</label>
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="customFile" name="img" onchange="displayImg(this,$(this))">
						<label class="custom-file-label" for="customFile">Choose file</label>
					</div>
				</div>

				<div class="form-group d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($img) ? $img : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>

		<div class="card-footer">
			<button class="btn btn-primary btn-sm" form="blog"><?php echo isset($_GET['id']) ? "Update" : "Save" ?></button>
			<a class="btn btn-primary btn-sm" href="./?page=blogs">Cancel</a>
		</div>
	</div>
</div>

<script>
	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#cimg').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$(document).ready(function(){
		$('#blog').submit(function(e){
			e.preventDefault();
			start_loader();
			$.ajax({
				url: _base_url_ + "classes/Content.php?f=blog",
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				type: 'POST',
				error: err => {
					alert_toast("An error occurred", 'error');
					console.log(err);
					end_loader();
				},
				success: function(resp){
                    try {
                        resp = JSON.parse(resp);
                        if (resp.status === 'success') {
                            alert_toast(resp.message, 'success');
                            setTimeout(function() {
                                location.href = _base_url_ + "admin/?page=blogs";
                            }, 1500);
                        } else {
                            alert_toast(resp.message || "An error occurred", 'error');
                            end_loader();
                        }
                    } catch(e) {
                        console.log("Invalid JSON response:", resp);
                        alert_toast("An unexpected error occurred", 'error');
                        end_loader();
                    }
                }

			});
		});

		$('.summernote').summernote({
			height: 200,
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'italic', 'underline', 'clear']],
				['para', ['ul', 'ol', 'paragraph']],
				['insert', ['link']],
				['view', ['codeview']]
			]
		});
	});
</script>
