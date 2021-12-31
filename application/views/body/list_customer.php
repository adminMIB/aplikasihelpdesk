			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Customer</li>
			</ol>
		</div><!--/.row-->
		
	<br>
				
		<?php echo $this->session->flashdata("msg");?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading"><svg class="glyph stroked male user "><use xlink:href="#stroked-male-user"/></svg>
						<a href="<?php echo base_url();?>customer/add" style="text-decoration:none">List Customer</a></div>
					<div class="panel-body">
						<table data-toggle="table" data-show-refresh="false" data-show-toggle="true" data-show-columns="true" data-search="true"  data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						        <th data-field="no" data-sortable="true" width="10px"> No</th>
						        <th data-field="id_customer" data-sortable="true">Username Customer</th>
						        <th data-field="customer_code" data-sortable="true">Nama Customer</th>						        
						        <th data-field="customer_email" data-sortable="true">Email</th>
						        <th data-field="telepon" data-sortable="true">Telp</th>
						        <th data-field="project" data-sortable="true">Project</th>
						        <th data-field="sla" data-sortable="true">SLA</th>
						        <th data-field="teknisi" data-sortable="true">Teknisi</th>
						        <th data-field="token" data-sortable="true">Token</th>
						        <th>Aksi</th>
						    </tr>
                            </thead>
                            <tbody>
                           <?php $no = 0; foreach($data_customer as $row) : $no++;?>
						     <tr>
						        <td data-field="no" width="10px"><?php echo $no;?></td>
						        <td ><?php echo $row->customer_code;?></td>
						        <td ><?php echo $row->nama_kategori;?></td>
						        <td ><?php echo $row->customer_email;?></td>
						        <td ><?php echo $row->telepon;?></td>
						        <td ><?php echo $row->nama_sub_kategori;?></td>
						        <td ><?php echo $row->sla;?></td>
						        <td ><?php echo $this->model_app->get_nama_teknisi_by_id($row->id_teknisi) ;?></td>
						        <td ><?php echo $row->token;?></td>
						        <td> 
									<a class="ubah btn btn-primary btn-xs" href="<?php echo base_url();?>customer/edit/<?php echo $row->id_customer;?>"><span class="glyphicon glyphicon-edit" ></span></a>
									<a data-toggle="modal"  title="Hapus Data" class="hapus btn btn-danger btn-xs" href="#modKonfirmasi<?php echo $row->id_customer;?>" data-id="<?php echo $row->id_customer;?>"><span class="glyphicon glyphicon-trash"></span></a>
									<!-- Modal -->
									<div id="modKonfirmasi<?php echo $row->id_customer;?>" class="modal fade" role="dialog">
									  <div class="modal-dialog">

									    <!-- Modal content-->
									    <div class="modal-content">
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									        <h4 class="modal-title">Hapus customer  <b><?php echo $row->customer_code;?></b> ? </h4>
									      </div>
									      <div class="modal-body">
									        <form method="post" action="<?php echo base_url()?>customer/delete/<?php echo $row->id_customer; ?>">
									        	<p>Anda ingin menghapus data ini ?</p>
									        	<div class="row">
									        		<div class="col-sm-3">
									        			<button type="submit" class="btn btn-danger btn-block">Ya</button>
									        		</div>
									        		<div class="col-sm-3">
									        			<button data-dismiss="modal" class="btn btn-warning btn-block">Tidak</button>
									        		</div>
									        	</div>
									        </form>
									      </div>
									    </div>

									  </div>
									</div>

									<a data-toggle="modal"  title="Edit Token" class="hapus btn btn-info btn-xs" href="#modToken<?php echo $row->id_customer;?>" data-id="<?php echo $row->id_customer;?>"><span class="glyphicon glyphicon-edit"></span></a>
									<!-- Modal -->
									<div id="modToken<?php echo $row->id_customer;?>" class="modal fade" role="dialog">
									  <div class="modal-dialog">

									    <!-- Modal content-->
									    <div class="modal-content">
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									        <h4 class="modal-title">Tambah token untuk customer  <b><?php echo $row->customer_code;?></b> ? </h4>
									      </div>
									      <div class="modal-body">
									        <form method="POST" action="<?php echo base_url('customer/save_token/'.$row->id_customer) ?>">
									        	<div class="form-group">
									        		<p>Token saat ini ( Edit angka untuk mengubah jumlah token )</p>
									        		<input type="number" name="token" value="<?php echo $row->token; ?>" class="form-control">
									        	</div>
									        	<div class="form-group">
									        		<button type="submit" class="btn btn-primary">Update jumlah token</button>
									        	</div>
									        </form>
									      </div>
									    </div>

									  </div>
									</div>
								</td>
						    </tr>
						    <?php endforeach;?>
						    </tbody>
						    
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->	


		

	
						
					</div>
				</div>
			</div>
		</div><!--/.row-->	
		
		
