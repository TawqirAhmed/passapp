<div>
	<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h3 class="card-title">Info</h3>
			</div>
			<div class="col-6">
				<button type="button" class="btn btn-outline-success waves-effect width-md float-right" data-toggle="modal" data-target="#modalvault" data-overlaySpeed="200" data-animation="fadein">New Info</button>
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
				            <th>Site</th>
				            <th>Link</th>
				            <th>User Name</th>
				            <th>Email</th>
				            <th>Category</th>
				            <th>Modified</th>
				            <th>Action</th>
			            </tr>
		                </thead>

		                <tbody>
		                	@foreach($allInfo as $key => $info)
		                		<tr>
		                			<td>{{ $key+1 }}</td>
		                			<td>{{ $info->site }}</td>
		                			<td>{{ $info->link }}</td>
		                			<td>{{ $info->user_name }}</td>
		                			<td>{{ $info->email }}</td>
		                			<td>{{ $info->category->name }}</td>
		                			<td>{{ $info->updated_at }}</td>
		                			<td>
		                				<a class="btn btn-success waves-effect waves-light btn-sm" data-toggle="modal" wire:click="getInfo('{{ $info->id }}')" data-target="#modalgetPassword">View</a>
		                				<a class="btn btn-warning waves-effect waves-light btn-sm" data-toggle="modal" wire:click="getInfo('{{ $info->id }}')" data-target="#modalEditInfo">Edit</a>
										<a class="btn btn-danger waves-effect waves-light btn-sm" onclick="confirm('Are you Want to Delete This Information?') || event.stopImmediatePropagation()" wire:click="deleteInfo('{{ $info->id }}')">Delete</a>
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
<div wire:ignore.self id="modalvault" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data" wire:submit.prevent="storeVault">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          <div class="modal-header" style="color: white">
		          	<h4 class="modal-title">Add Info Form</h4>
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
		                        <strong>Site:</strong>
		                        <input type="text" class="form-control input-lg" placeholder="Site" wire:model="site" required>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="form-group">          
		                    <div class="input-group">             
		                      <div class="col-xs-12 col-sm-12 col-md-12">
		                        <strong>Link:</strong>
		                        <textarea class="form-control input-lg" placeholder="Link" wire:model="link"></textarea>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="form-group">          
		                    <div class="input-group">             
		                      <div class="col-xs-12 col-sm-12 col-md-12">
		                        <strong>User Name:</strong>
		                        <input type="text" class="form-control input-lg" placeholder="User Name" wire:model="user_name" required>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="form-group">          
		                    <div class="input-group">             
		                      <div class="col-xs-12 col-sm-12 col-md-12">
		                        <strong>Email:</strong>
		                        <input type="email" class="form-control input-lg" placeholder="Email" wire:model="email" required>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="form-group">          
		                    <div class="input-group">             
		                      <div class="col-xs-12 col-sm-12 col-md-12">
		                        <strong>Password:</strong>
		                        <input type="password" class="form-control input-lg" placeholder="Password" wire:model="password" required>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="form-group">          
		                    <div class="input-group">             
		                      <div class="col-xs-12 col-sm-12 col-md-12">
		                        <strong>Category:</strong>
		                        {{-- <input type="text" class="form-control input-lg" placeholder="Name" wire:model="site" required> --}}
		                        <select class="form-control input-lg" wire:model="category_id">
		                        	<option value="" selected="selected">Select Category</option>
		                        	@foreach($allCategories as $category)
			                          <option value="{{ $category->id }}">{{ $category->id }} : {{ $category->name }}</option>
			                        @endforeach
		                        </select>
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
		  =  Modal window for get Password    =
		  ===========================-->
		<!-- sample modal content -->
		<div wire:ignore.self id="modalgetPassword" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <form role="form" enctype="multipart/form-data" wire:submit.prevent="viewPass()">
				      	@csrf
				        <!--=====================================
				            MODAL HEADER
				        ======================================-->  
				          <div class="modal-header">
				          	<h4 class="modal-title">View Password</h4>
				            <button type="button"  wire:click="clear()" class="close" data-dismiss="modal">&times;</button>
				            
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
			                        	<strong>Login Password:</strong>
					                  	<input type="password" class="form-control input-sm" name="name" placeholder="Login Password" wire:model="verify_pass" required>
					                  </div>
					                </div>
					              </div>

					              <div class="form-group">          
					                <div class="input-group">             
					                  <div class="col-xs-12 col-sm-12 col-md-12">
			                        	<strong>Password:</strong>
					                  	<input type="text" class="form-control input-sm" name="name" placeholder="Password" wire:model="v_pass">
					                  </div>
					                </div>
					              </div>
					              
					              
				              
				            </div>
				          </div>
				          <!--=====================================
				            MODAL FOOTER
				          ======================================-->
				          <div class="modal-footer">
				            <button type="submit" class="btn btn-success waves-effect waves-light">View</button>
				            <button type="button" class="btn btn-danger" wire:click="clear()" data-dismiss="modal">Close</button>
				          </div>
				    </form>
		            
		        </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->


{{-- modalEditInfo Table-------------------------------------------------------------------------------------------- --}}

        <!--==========================
      =  Modal window for modalEditInfo   =
      ===========================-->
<div wire:ignore.self id="modalEditInfo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	
        	  <div class="modal-header" style="color: white">
	          	<h4 class="modal-title">Edit Info Form</h4>
	            <button type="button"  wire:click="clear()" class="close" data-dismiss="modal">&times;</button>
	            
	          </div>

	        <form role="form" method="post" enctype="multipart/form-data" wire:submit.prevent="viewInfo">
        		@csrf

        	  <div class="form-group">          
	            <div class="input-group">             
	              <div class="col-xs-12 col-sm-12 col-md-12">
	            	<strong>Login Password:</strong>
	              	<input type="password" class="form-control input-sm" name="name" placeholder="Login Password" wire:model="verify_pass" required>
	              </div>
	            </div>
	          </div>
              <div class="modal-footer">
	            <button type="submit" class="btn btn-success waves-effect waves-light">Next</button>
	          </div>
        	</form>

            <form role="form" method="post" enctype="multipart/form-data" wire:submit.prevent="updateVault">
		      	@csrf
		        <!--=====================================
		            MODAL HEADER
		        ======================================-->  
		          {{-- <div class="modal-header" style="color: white">
		          	<h4 class="modal-title">Edit Info Form</h4>
		            <button type="button" class="close" data-dismiss="modal">&times;</button>
		            
		          </div> --}}
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

						
						@if($flag)
						<!-- TAKING NAME  -->
		                  <div class="form-group">          
		                    <div class="input-group">             
		                      <div class="col-xs-12 col-sm-12 col-md-12">
		                        <strong>Site:</strong>
		                        <input type="text" class="form-control input-lg" placeholder="Site" wire:model="e_site" required>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="form-group">          
		                    <div class="input-group">             
		                      <div class="col-xs-12 col-sm-12 col-md-12">
		                        <strong>Link:</strong>
		                        <textarea class="form-control input-lg" placeholder="Link" wire:model="e_link"></textarea>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="form-group">          
		                    <div class="input-group">             
		                      <div class="col-xs-12 col-sm-12 col-md-12">
		                        <strong>User Name:</strong>
		                        <input type="text" class="form-control input-lg" placeholder="User Name" wire:model="e_user_name" required>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="form-group">          
		                    <div class="input-group">             
		                      <div class="col-xs-12 col-sm-12 col-md-12">
		                        <strong>Email:</strong>
		                        <input type="email" class="form-control input-lg" placeholder="Email" wire:model="e_email" required>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="form-group">          
		                    <div class="input-group">             
		                      <div class="col-xs-12 col-sm-12 col-md-12">
		                        <strong>Password:</strong>
		                        <input type="password" class="form-control input-lg" placeholder="Password" wire:model="e_password" required>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="form-group">          
		                    <div class="input-group">             
		                      <div class="col-xs-12 col-sm-12 col-md-12">
		                        <strong>Category:</strong>
		                        {{-- <input type="text" class="form-control input-lg" placeholder="Name" wire:model="site" required> --}}
		                        <select class="form-control input-lg" wire:model="e_category_id">
		                        	<option value="" selected="selected">Select Category</option>
		                        	@foreach($allCategories as $category)
			                          <option value="{{ $category->id }}">{{ $category->id }} : {{ $category->name }}</option>
			                        @endforeach
		                        </select>
		                      </div>
		                    </div>
		                  </div>

		                  @endif

		              
		            </div>
		          </div>
		          <!--=====================================
		            MODAL FOOTER
		          ======================================-->
		          <div class="modal-footer">
		            <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
		            <button type="button"  wire:click="clear()" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		          </div>
		    </form>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--====  End of module Modal window for Add categories  ====-->
</div>
