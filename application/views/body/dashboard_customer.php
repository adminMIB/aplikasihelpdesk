<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Dashboard <?php echo $this->session->userdata('id_jabatan');?></li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-xs-6 col-md-6">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<h4>Tickets<br>Solved</h4>
						<div class="easypiechart" id="easypiechart-blue" data-percent="<?php echo $row_ticket_solved;?>" ><span class="percent"><?php echo ceil($row_ticket_solved);?> %</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-6">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<h4>Tickets On<br>Process</h4>
						<div class="easypiechart" id="easypiechart-orange" data-percent="<?php echo $row_ticket_process;?>" ><span class="percent"><?php echo ceil($row_ticket_process);?> %</span>
						</div>
					</div>
				</div>
			</div>

		</div><!--/.row-->


		<div class="row">




			<div class="col-xs-6 col-md-6">
				

				<div class="panel panel-teal panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked star"><use xlink:href="#stroked-star"/></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php echo ceil($sql_feedback_positiv);?>%</div>
							<div class="text-muted">Feedback Positiv</div>
						</div>
					</div>
				</div>

			</div>


			<div class="col-xs-6 col-md-6">
				

				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"/></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php echo ceil($sql_feedback_negativ);?>%</div>
							<div class="text-muted">Feedback Negativ</div>
						</div>
					</div>
				</div>

			</div>



			

		</div><!--/.row-->
								
		
								
			</div><!--/.col-->
		</div><!--/.row-->
	</div>	<!--/.main-->