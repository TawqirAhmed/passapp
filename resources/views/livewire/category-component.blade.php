<div>
	<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h3 class="card-title">Categories</h3>
			</div>
			<div class="col-6">
				<button type="button" class="btn btn-outline-success waves-effect width-md float-right" data-toggle="modal" data-target="#modalcategories" data-overlaySpeed="200" data-animation="fadein">New Category</button>
			</div> 
		</div>             
	</div>

    <div class="card-body">
		<div class="box-body">
		    <div class="col-12">
		        <div class="card-box">
		            {{-- <h4 class="header-title">All Users</h4> --}}
		            @if(Session::has('message'))
						<div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
					@endif

					<div class="row">

 					<label for="paginate" style="margin-top: auto;margin-left: auto;">Show</label>
 					<div class="col-sm-2">
					<select id="paginate" name="paginate" class="form-control input-sm" wire:model="paginate">
	                    <option value="10">10</option>
	                    <option value="25">25</option>
	                    <option value="50">50</option>
	                    <option value="100">100</option>
                    </select>
                    </div>	
                    <div class="col-sm-6"></div>
                    <div class="col-sm-3">
                    	<input type="search" wire:model="search" class="form-control input-sm" placeholder="Search">
                    </div>
                    </div>
                    <br>

		            <table class="table table-bordered dt-responsive nowrap data-table-categories" width="100%">
		                <thead>
		                <tr>
		                    <th>S/N</th>
				            <th>Name</th>
				            <th>Description</th>
				            <th>Action</th>
			            </tr>
		                </thead>

		                <tbody>
		                	@foreach($allCategories as $category)
		                		<tr>
		                			<td>{{ $category->id }}</td>
		                			<td>{{ $category->name }}</td>
		                			<td>{{ $category->description }}</td>
		                			<td>
		                				<a class="btn btn-warning waves-effect waves-light btn-sm" wire:click="getCategory('{{ $category->id }}')" data-toggle="modal" data-target="#modalEditCategory">Edit</a>
										<a class="btn btn-danger waves-effect waves-light btn-sm" onclick="confirm('Are you Want to Delete This Category?') || event.stopImmediatePropagation()" wire:click="deleteCategory('{{ $category->id }}')">Delete</a>
		                			</td>
		                		</tr>
		                	@endforeach
		                </tbody>
		            </table>
		        </div> <!-- end card-box -->
		    </div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>


{{-- Add categories Table-------------------------------------------------------------------------------------------- --}}

        <!--==========================
      =  Modal window for Add categories   =
      ===========================-->
<div wire:ignore.self id="modalcategories" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data" wire:submit.prevent="storeCategory">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="color: white">
		          	<h4 class="modal-title">Add Category Form</h4>
		            <button type="button" class="close" data-dismiss="modal">&times;</button>
		            
		          </div>
		          <!--=====================================
		            MODAL BODY
		          ======================================-->
		          <div class="modal-body">
		            <div class="box-body">
		            	@if ($errors->any())
						    <div class="alert alert-danger">
						        <ul>
						            @foreach ($errors->all() as $error)
						                <li>{{ $error }}</li>
						            @endforeach
						        </ul>
						    </div>
						@endif

						<!-- TAKING NAME  -->
		                  <div class="form-group">          
		                    <div class="input-group">             
		                      <div class="col-xs-12 col-sm-12 col-md-12">
		                        <strong>Name:</strong>
		                        <input type="text" class="form-control input-lg" name="cat_name" placeholder="Name" wire:model="name" required>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="form-group">          
		                    <div class="input-group">             
		                      <div class="col-xs-12 col-sm-12 col-md-12">
		                        <strong>Description:</strong>
		                        <textarea class="form-control input-lg" name="cat_description" placeholder="Description" wire:model="description"></textarea>
		                      </div>
		                    </div>
		                  </div>

		              
		            </div>
		          </div>
		          <!--=====================================
		            MODAL FOOTER
		          ======================================-->
		          <div class="modal-footer">
		            <button type="submit" class="btn btn-success waves-effect waves-light">Add</button>
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		          </div>
		    </form>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--====  End of module Modal window for Add categories  ====-->

<!--==========================
		  =  Modal window for Edit Category    =
		  ===========================-->
		<!-- sample modal content -->
		<div wire:ignore.self id="modalEditCategory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <form role="form" enctype="multipart/form-data" wire:submit.prevent="updateCategory()">
				      	@csrf
				        <!--=====================================
				            MODAL HEADER
				        ======================================-->  
				          <div class="modal-header">
				          	<h4 class="modal-title">Edit Category Form</h4>
				            <button type="button" class="close" data-dismiss="modal">&times;</button>
				            
				          </div>
				          <!--=====================================
				            MODAL BODY
				          ======================================-->
				          <div class="modal-body">
				            <div class="box-body">
				            	@if ($errors->any())
								    <div class="alert alert-danger">
								        <ul>
								            @foreach ($errors->all() as $error)
								                <li>{{ $error }}</li>
								            @endforeach
								        </ul>
								    </div>
								@endif

								 <div class="form-group">          
					                <div class="input-group">             
					                  <div class="col-xs-12 col-sm-12 col-md-12">
			                        	<strong>Name:</strong>
					                  	<input type="text" class="form-control input-sm" name="name" placeholder="Name" wire:model="e_name" required>
					                  </div>
					                </div>
					              </div>
					              
					              <div class="form-group">      
					                <div class="input-group">                 
					                  <div class="col-xs-12 col-sm-12 col-md-12">
			                        	<strong>Description:</strong>
					                   	<textarea type="text" class="form-control input-sm" name="description" placeholder="Description" wire:model="e_description" required></textarea>
					                   </div>
					                </div>
					              </div>
				              
				            </div>
				          </div>
				          <!--=====================================
				            MODAL FOOTER
				          ======================================-->
				          <div class="modal-footer">
				            <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
				            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				          </div>
				    </form>
		            
		        </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

</div>
