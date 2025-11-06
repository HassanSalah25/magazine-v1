<div class="modal fade" id="createPointModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <form id="ajaxForm" class="modal-form" action="{{route('admin.approach.point.store')}}" method="POST">
             <input type="hidden" name="id" value="{{request()->input('id')}}">
           <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Add Point</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
           </div>
           <div class="modal-body">
              <div class="row">
                 <div class="col-lg-12">
                    @csrf

                     <div class="form-group">
                         <label for="">Image ** </label>
                         <br>
                         <div class="thumb-preview" id="thumbPreview1">
                             <img src="" alt="Image">
                         </div>
                         <br>
                         <br>


                         <input id="fileInput1" type="hidden" name="image">
                         <button id="chooseImage1" class="choose-image btn btn-primary" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal1">Choose Image</button>


                         <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                         <p class="text-danger mb-0 em" id="errimage"></p>


                     </div>
                    <div class="form-group">
                        <label for="">Language **</label>
                        <select name="language_id" class="form-control">
                            <option value="" selected disabled>Select a language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->id}}">{{$lang->name}}</option>
                            @endforeach
                        </select>
                        <p id="errlanguage_id" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group">
                       <label for="">Icon **</label>
                       <div class="btn-group d-block">
                          <button type="button" class="btn btn-primary iconpicker-component"><i
                             class="fa fa-fw fa-heart"></i></button>
                          <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                             data-selected="fa-car" data-toggle="dropdown">
                          </button>
                          <div class="dropdown-menu"></div>
                       </div>
                       <input id="inputIcon" type="hidden" name="icon" value="fas fa-heart">
                       <div class="mt-2">
                          <small>NB: click on the dropdown sign to select an icon.</small>
                       </div>
                    </div>

                    @if ($be->theme_version == 'cleaning')
                        <div class="form-group">
                            <label for="">Color **</label>
                            <input type="text" class="form-control jscolor" name="color" value="39498a">
                            <p id="errcolor" class="mb-0 text-danger em"></p>
                        </div>
                    @endif

                    <div class="form-group">
                       <label for="">Title **</label>
                       <input type="text" class="form-control" name="title" value="" placeholder="Enter Title">
                       <p id="errtitle" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group">
                       <label for="">Short Text **</label>
                       <input type="text" class="form-control" name="short_text" value="" placeholder="Enter Short Text">
                       <p id="errshort_text" class="mb-0 text-danger em"></p>
                    </div>
                     <div class="form-group">
                         <label for="">Show in Page</label>
                         <select name="page_id" class="form-control">
                             <option value="" selected disabled>Home Page</option>
                             <option value="{{\App\Models\Point::CAREER}}">Career Page</option>
                         </select>
                         <p id="errpage_id" class="mb-0 text-danger em"></p>
                     </div>
                    <div class="form-group">
                      <label for="">Serial Number **</label>
                      <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="Enter Serial Number">
                      <p id="errserial_number" class="mb-0 text-danger em"></p>
                      <p class="text-warning"><small>The higher the serial number is, the later the point will be shown in approach section.</small></p>
                    </div>
                 </div>
              </div>
           </div>
           <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button id="submitBtn" type="submit" class="btn btn-success">Submit</button>
           </div>
         </form>
      </div>
   </div>
</div>
<!-- Image LFM Modal -->
<div class="modal fade lfm-modal" id="lfmModal1" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
    <i class="fas fa-times-circle"></i>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <iframe src="{{url('laravel-filemanager')}}?serial=1" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
