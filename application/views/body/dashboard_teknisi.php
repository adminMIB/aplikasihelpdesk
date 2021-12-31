<?php $q = $this->lib->get_notif_tiket_unread(); ?>	
<?php if(isset($_SESSION['is_show_popup_unread_notif'])&& $_SESSION['is_show_popup_unread_notif']){ ?>
	<div id="modNotifUnread" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-body">
	        <p>Anda memiliki <?php echo $q ; ?> ticket belum dibaca.</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>
	<script type="text/javascript">
    $(window).on('load',function(){
        $('#modNotifUnread').modal('show');
    });
</script>
<?php } ?>		
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Dashboard Teknisi</li>
			</ol>
		</div><!--/.row-->
		
	<br>

	<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>REPORT</strong> <em>TEKNISI JOBS</em>
					</div>
					<div class="panel-body">

						<div class="icon-grid">

							<?php $no = 0; foreach($datateknisi as $row) : $no++;?>

							<a href="<?php echo base_url();?>dashboard_teknisi/report_teknisi/<?php echo $row->id_teknisi;?>"><div class="col-lg-3 col-md-4 col-sm-6">
								<svg class="glyph stroked male user "><use xlink:href="#stroked-male-user"/></svg>
								<b><?php echo $row->nama;?></b>
								<br>
								<b><?php echo $row->point;?> POINT</b>
							</div>

						</a>

						<?php endforeach;?>

						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->	