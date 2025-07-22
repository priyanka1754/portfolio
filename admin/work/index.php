<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_work" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered table-compact" id="list">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="20%">
					<col width="15%">
					<col width="35%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Company</th>
						<th>Position</th>
						<th>Start-End</th>
						<th>Logo</th>
						<th>Location</th>
						<th>Company Link</th>
						<th>Tech Used</th>
						<th>Certificate</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM `work` order by `ended` desc");
					while($row= $qry->fetch_assoc()):
						$desc = html_entity_decode($row['description']);
						$dest = strip_tags($desc);
						$dest =stripslashes($desc);
					?>
					<tr>
  <td class="text-center"><?php echo $i++ ?></td>
  <td><?= ucwords($row['company']) ?></td>
  <td><?= ucwords($row['position']) ?></td>
  <td><?= $row['started'] . ' - ' . ($row['ended'] == 'Present' ? 'Present' : $row['ended']) ?></td>
  <td>
    <?php if(!empty($row['company_logo'])): ?>
        <img src="<?= base_url . $row['company_logo'] ?>" height="40">
    <?php else: ?>
        No Logo
    <?php endif; ?>
</td>
  <td><?= $row['location'] ?></td>
  <td>
    <?php if(!empty($row['company_link'])): ?>
      <a href="<?= $row['company_link'] ?>" target="_blank">Visit</a>
    <?php else: ?> N/A <?php endif; ?>
  </td>
  <td><?= $row['tech_used'] ?></td>
  <td>
    <?php if(!empty($row['certificate_file'])): ?>
        <a href="<?= base_url . $row['certificate_file'] ?>" target="_blank">View</a>
    <?php else: ?>
        N/A
    <?php endif; ?>
</td>
  


						<td><small class="truncate-1"><?php echo $desc ?></small></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat btn-sm manage_work">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-sm btn-flat delete_work" data-id="<?php echo $row['id'] ?>">
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
		$('.new_work').click(function(){
			location.href = _base_url_+"admin/?page=work/manage";
		})
		$('.manage_work').click(function(){
			location.href = _base_url_+"admin/?page=work/manage&id="+$(this).attr('data-id')
		})
		$('.delete_work').click(function(){
		_conf("Are you sure to delete this detail?","delete_work",[$(this).attr('data-id')])
		})
		$('#list').dataTable()
	})
	function delete_work($id){
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Content.php?f=work_delete',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					location.reload()
				}
			}
		})
	}
</script>