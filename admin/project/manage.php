<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif; ?>

<?php 
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM project WHERE id = '{$_GET['id']}' ");
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
			<h5 class="card-title">Project</h5>
		</div>
		<div class="card-body">
			<form id="project" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Name</label>
							<textarea name="name" cols="30" rows="2" class="form-control"><?php echo isset($name) ? $name : '' ?></textarea>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Client</label>
							<textarea name="client" cols="30" rows="2" class="form-control"><?php echo isset($client) ? $client : '' ?></textarea>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Summary</label>
							<textarea name="summary" cols="30" rows="4" class="form-control"><?php echo isset($summary) ? html_entity_decode($summary) : '' ?></textarea>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Description</label>
							<textarea name="description" cols="30" rows="10" class="form-control summernote"><?php echo isset($description) ? html_entity_decode($description) : '' ?></textarea>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">GitHub Link</label>
							<input type="url" name="github_link" class="form-control" value="<?php echo isset($github_link) ? $github_link : '' ?>">
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Upload Project Video</label>
							<input type="file" name="video_file" class="form-control" accept="video/*">
							<?php if(isset($video_url) && !empty($video_url)): ?>
								<small class="form-text text-muted">Current: <a href="<?php echo $video_url ?>" target="_blank">View Video</a></small>
								<input type="hidden" name="existing_video_url" value="<?php echo $video_url ?>">
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label">Banner Image</label>
					<div class="custom-file">
						<input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
						<label class="custom-file-label" for="customFile">Choose file</label>
					</div>
				</div>

				<div class="form-group d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($banner) ? $banner : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>

		<div class="card-footer">
			<button class="btn btn-primary btn-sm" form="project"><?php echo isset($_GET['id']) ? "Update" : "Save" ?></button>
			<a class="btn btn-primary btn-sm" href="./?page=project">Cancel</a>
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

	$(document).ready(function() {
		$('#project').submit(function(e) {
    e.preventDefault();
    start_loader();
    $.ajax({
        url: _base_url_ + "classes/Content.php?f=project",
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        error: function(xhr, status, error) {
            alert_toast("An error occurred: " + error, 'error');
            console.log(xhr.responseText);
            end_loader();
        },
        success: function(resp) {
    // Log the raw response before trying to parse it
    console.log("Raw server response:", resp);
    
    try {
        var data = JSON.parse(resp);
        if (data.status === 'success') {
            location.href = _base_url_ + "admin/?page=project";
        } else {
            alert_toast("Error: " + (data.message || "Unknown error"), 'error');
            console.log("Error details:", data);
            end_loader();
        }
    } catch(e) {
        alert_toast("Invalid response format from server", 'error');
        console.log("Parse error:", e);
        end_loader();
    }
}
    });
});

		$('.summernote').summernote({
			height: 200,
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['table', ['table']],
				['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
			]
		});
	});
</script>
