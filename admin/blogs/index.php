<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
</script>
<?php endif; ?>
<style>
	.banner-img {
		width: 75px;
		object-fit: contain;
	}
</style>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_blog" href="javascript:void(0)">
					<i class="fa fa-plus"></i> Add New
				</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered table-compact" id="list">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="25%">
					<col width="20%">
					<col width="20%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Image</th>
						<th>Title</th>
						<th>Date</th>
						<th>Intro</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM `blogs` ORDER BY date DESC");
					while($row = $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><center><img src="<?php echo validate_image($row['img']) ?>" class="banner-img img-thumbnail" alt=""></center></td>
						<td><b class="truncate-1"><?php echo ucwords($row['title']) ?></b></td>
						<td><?php echo date("M d, Y", strtotime($row['date'])) ?></td>
						<td><small class="truncate-1"><?php echo $row['intro'] ?></small></td>
						<td class="text-center">
							<div class="btn-group">
								<a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat btn-sm manage_blog">
									<i class="fas fa-edit"></i>
								</a>
								<button type="button" class="btn btn-danger btn-sm btn-flat delete_blog" data-id="<?php echo $row['id'] ?>">
									<i class="fas fa-trash"></i>
								</button>
							</div>
						</td>
					</tr>	
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.new_blog').click(function(){
			location.href = _base_url_ + "admin/?page=blogs/manage";
		});
		$('.manage_blog').click(function(){
			location.href = _base_url_ + "admin/?page=blogs/manage&id=" + $(this).attr('data-id');
		});
		$('.delete_blog').click(function(){
			_conf("Are you sure to delete this blog?", "delete_blog", [$(this).attr('data-id')]);
		});
		$('#list').dataTable();
	});

	function delete_blog($id){
		start_loader();
		$.ajax({
			url: _base_url_ + 'classes/Content.php?f=blog_delete',
			method: 'POST',
			data: { id: $id },
			success: function(resp){
				if(resp == 1){
					location.reload();
				}
			}
		});
	}
</script>
