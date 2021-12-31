<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">New Ticket by Customer</li>
	</ol>
</div><!--/.row-->
<br>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading"><svg class="glyph stroked male user "><use xlink:href="#stroked-male-user"/></svg>
				<a href="#" style="text-decoration:none; font-color:white">New Ticket</a></div>
				<?php echo $this->session->flashdata("msg");?>
				<div class="panel-body">
					<?php if(!empty($data_cust)){ ?>
						<div class="row">
							<div class="col-sm-6">
								<p>ID customer : <?php echo $data_cust->id_customer; ?></p>
								<p>Code customer : <?php echo $data_cust->customer_code; ?></p>
								<p>Nama customer : <?php echo $data_cust->nama_kategori; ?></p>
								<p>Email customer : <?php echo $data_cust->customer_email; ?></p>
								<p>Tlp customer : <?php echo $data_cust->telepon; ?></p>
								<p>Project : <?php echo $data_cust->nama_sub_kategori; ?></p>
								<p>SLA Tiket : <?php echo $data_cust->sla; ?></p>
								<p>Jumlah Token : <?php echo $data_cust->token; ?></p>
								<hr>
								<form method='POST' action="<?php echo base_url('ticket/submit_add_ticket_customer/'.$data_cust->customer_code);?>" enctype="multipart/form-data">
									<input type="hidden" name="id_sub_kategori" value="<?php echo $data_cust->project_id; ?>">
									<input type="hidden" name="id_teknisi" value="<?php echo $data_cust->teknisi_id; ?>">
									<div class="form-group">
										<p>Subjek Problem</p>
										<input type="text" name="subject_problem" class="form-control" required="">
									</div>
									<div class="form-group">
										<p>Upload</p>
										<input type="file" name="foto" class="form-control">
									</div>
									<div class="form-group">
										<p>Deskripsi</p>
										<textarea name="deskripsi" class="form-control"></textarea>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary">Save</button>
									</div>
								</form>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>