<style>
.download-btn {padding:0!important; }
.download-btn a{     font-size:25px;  color: #333;  }
.download-btn a:hover { color: #1caf9a; }
</style>

<div class="panel-heading" >
	<h3 class="panel-title"><strong>Document Details</strong></h3>
</div>
<div class="panel-body">
	<div class="row">
	<div class="table-responsive">
	<table id="contacts" class="table table-bordered" style="margin:0px;">
		<thead>
			<tr>
			  	<th width="15%">Document Type</th>
				<th width="18%">Document Name</th>
				<th width="22%">Description</th>
				<th width="15%">Reference No.</th>
				<th width="12%">Date of Issue</th>
				<th width="12%">Date of Expiry</th>
				<th style="text-align:center" width="6%" class="download">Download</th>
				<th width="14%" class="download">Preview</th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($documents)) { for ($i=0; $i < count($documents); $i++) { ?>
				<tr>
				  	<td class="Contact_name"><?php if(($documents[$i]->d_type)=='') { echo 'others'; } else { echo $documents[$i]->d_type; } ?></td>
					<td class="Contact_name"><?php if(($documents[$i]->doc_documentname)=='') { echo $documents[$i]->doc_doc_name; } else { echo $documents[$i]->doc_documentname; } ?></td>
					<td class="Contact_name"><?php echo $documents[$i]->doc_description; ?></td>
					<td><?php echo $documents[$i]->doc_ref_no; ?></td>
					<td><?php if ($documents[$i]->doc_doi!='') { if($documents[$i]->doc_doi != '') echo date('d/m/Y',strtotime($documents[$i]->doc_doi)); }?></td>
					<td><?php if ($documents[$i]->doc_doe!='') { if($documents[$i]->doc_doe != '') echo date('d/m/Y',strtotime($documents[$i]->doc_doe)); } ?></td>
					<?php if($documents[$i]->doc_document!='' && $documents[$i]->doc_document!=null) { ?>
						<td align="center" class="download download-btn">
		            		<a class=" " target="_blank" href="<?php echo base_url().$documents[$i]->doc_document; ?>"><i class="fa fa-download" aria-hidden="true"></i> </a>
			            </td>
					
						<td align="" class="download">
		            		<button data-box="#message-box-info-<?php echo $i;?>" class="btn btn-info mb-control sch">Preview</button>
		            		<div class="message-box message-box-info animated fadeIn" id="message-box-info-<?php echo $i;?>" style="overflow:auto;top:0;">
                                    <div class="mb-container" style="background:#fff;top:5%;">
                                        <div class="mb-middle">
                                            
                                                <div class="mb-title" style="color:#000;text-align:center;">Preview</div>
                                                <iframe src="https://docs.google.com/gview?url=<?php echo base_url().$documents[$i]->doc_document; ?>&embedded=true" id="viewer" frameborder="0" scrolling="no" width="100%" height="450"></iframe>
                                                <button class="btn btn-warning mb-control-close">Cancel</button>
                                            
                                        </div>
                                    </div>
                                </div>
			            </td>
					<?php } else { ?>
						<td align=""></td>
						<td align=""></td>
					<?php } ?>
				</tr>
			<?php } } ?>
		</tbody>
	</table>
	
	<!-- <div class="row">
	&nbsp;
	</div> -->
  	</div>
	</div>
</div>