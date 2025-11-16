
@php
$banner_images = $pageData->meta->where('meta_key', 'banner_images')->first()->meta_value ?? '';

$about = json_decode($pageData->meta->where('meta_key', 'about')->first()->meta_value ?? '[]', true);

$partner_title = $pageData->meta->where('meta_key', 'partner_title')->first()->meta_value ?? '';
$partner_description = $pageData->meta->where('meta_key', 'partner_description')->first()->meta_value ?? '';
$partners = json_decode($pageData->meta->where('meta_key', 'partners')->first()->meta_value ?? '[]', true);

@endphp

<div class="row">
    <div class="col-md-12">
        <hr>
        <h4 class="text-primary">Breadcrumb Section</h4>
    </div>      
    <div class="col-md-12">
        <label for="name" class="form-label">Breadcrumb <span class="text-danger">*</span></label>
        <div class="form-group mb-2">
            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                <div class="input-group-prepend">
                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ __('Browse') }}</div>
                </div>
                <div class="form-control file-amount">{{ __('Choose File') }}</div>
                <input value="{{$banner_images}}" type="hidden" name="meta[banner_images]" class="selected-files" required>
            </div>
            <div class="file-preview box sm"></div>
        </div>
    </div>    
</div> 





<div class="row">
    <div class="col-md-12">
        <hr>
        <h4 class="text-primary">About Section</h4>
    </div>       
    <div class="about-target">
        @if(isset($about['itration']) && is_array($about['itration']))
            @foreach($about['itration'] as $index => $itration)
                <div class="row remove-parent">
                    <div class="col-md-12">
                        <label for="name" class="form-label">Image & Title <span class="text-danger">*</span></label>
                        <input value="{{ $index }}" name="meta[about][itration][]" type="hidden" required>
                    </div> 
                    <div class="col-md">
                        <div class="form-group mb-2">
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ __('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ __('Choose File') }}</div>
                                <input type="hidden" 
                                    name="meta[about][image][]" 
                                    class="selected-files" 
                                    value="{{ $about['image'][$index] ?? '' }}" 
                                    required>
                            </div>
                            <div class="file-preview box sm"></div>
                        </div>
                    </div> 
                    <div class="col-md">
                        <div class="form-group mb-2">
                            <input value="{{ $about['title'][$index] ?? '' }}" 
                                name="meta[about][title][]" 
                                type="text" 
                                class="form-control" 
                                minlength="3" 
                                maxlength="200" 
                                placeholder="Enter Title" 
                                required>
                        </div>
                    </div>     
                                                       
                    <div class="col-md-auto">
                        <button type="button" class="btn btn-icon btn-circle btn-soft-danger" data-toggle="remove-parent" data-parent=".remove-parent">
                            <i class="ti ti-x"></i>
                        </button>
                    </div> 
                    
                     <div class="col-md-12">
                        <div class="form-group mb-2">
                            <textarea name="meta[about][decription][]" class="form-control text-editor" rows="4" required>{{ $about['decription'][$index] ?? '' }}</textarea>
                        </div>
                    </div>                   
                </div>
            @endforeach
        @endif
    </div>
    <button
        type="button"
        class="mt-1 btn btn-soft-success btn-icon w-100 init-text-editor"
        data-toggle="add-more"
        data-content='
            <div class="row remove-parent">
                <div class="col-md-12">
                    <label for="name" class="form-label">Image & Title <span class="text-danger">*</span></label>
                    <input value="data" name="meta[about][itration][]" type="hidden" required>
                </div> 
                <div class="col-md">
                    <div class="form-group mb-2">
                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ __('Browse') }}</div>
                            </div>
                            <div class="form-control file-amount">{{ __('Choose File') }}</div>
                            <input type="hidden" name="meta[about][image][]" class="selected-files" required>
                        </div>
                        <div class="file-preview box sm"></div>
                    </div>
                </div> 
                <div class="col-md">
                    <div class="form-group mb-2">
                        <input value="" name="meta[about][title][]" type="text" class="form-control" minlength="3" maxlength="200" placeholder="Enter Title" required>
                    </div>
                </div>   
                                           
                <div class="col-md-auto">
                    <button type="button" class="btn btn-icon btn-circle btn-soft-danger" data-toggle="remove-parent" data-parent=".remove-parent">
                        <i class="ti ti-x"></i>
                    </button>
                </div>   
                
                <div class="col-md-12">
                    <div class="form-group mb-2">
                        <textarea name="meta[about][decription][]" class="form-control text-editor" rows="4" required></textarea>
                    </div>
                </div>               
            </div>   
        '
        data-target=".about-target">
        <i class="ti ti-plus"></i>
        <span class="ml-2">Add More</span>
    </button>     
</div> 






<div class="row">
    <div class="col-md-12">
        <hr>
        <h4 class="text-primary">partnership Section</h4>
    </div> 
    <div class="col-md-12 form-group mb-2">
        <label for="content" class="form-label">Title <span class="text-danger">*</span></label>
        <input name="meta[partner_title]" class="form-control" value="{{$partner_title}}" required>
    </div>       
    <div class="col-md-12 form-group mb-2">
        <label for="content" class="form-label">Description <span class="text-danger">*</span></label>
        <textarea name="meta[partner_description]" class="form-control text-editor" rows="4" required>{{$partner_description}}</textarea>
    </div>       
    <div class="awards-target">
        @if(isset($partners['itration']) && is_array($partners['itration']))
            @foreach($partners['itration'] as $index => $itration)
                <div class="row remove-parent">
                    <div class="col-md-12">
                        <label for="name" class="form-label">Chemical Partner <span class="text-danger">*</span></label>
                        <input value="{{ $index }}" name="meta[partners][itration][]" type="hidden" required>
                    </div> 
                    <div class="col-md">
                        <div class="form-group mb-2">
                            <input value="{{ $partners['icon'][$index] ?? '' }}" 
                                name="meta[partners][icon][]" 
                                type="text" 
                                class="form-control" 
                                minlength="3" 
                                maxlength="200" 
                                placeholder="Enter Icon" 
                                required>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group mb-2">
                            <input value="{{ $partners['title'][$index] ?? '' }}" 
                                name="meta[partners][title][]" 
                                type="text" 
                                class="form-control" 
                                minlength="3" 
                                maxlength="200" 
                                placeholder="Enter Title" 
                                required>
                        </div>
                    </div>     
                    <div class="col-md">
                        <div class="form-group mb-2">
                            <textarea name="meta[partners][decription][]" class="form-control" rows="4" required>{{ $partners['decription'][$index] ?? '' }}</textarea>
                        </div>
                    </div>                                                       
                    <div class="col-md-auto">
                        <button type="button" class="btn btn-icon btn-circle btn-soft-danger" data-toggle="remove-parent" data-parent=".remove-parent">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>         
                </div>
            @endforeach
        @endif
    </div>
    <button
        type="button"
        class="mt-1 btn btn-soft-success btn-icon w-100"
        data-toggle="add-more"
        data-content='
            <div class="row remove-parent">
                <div class="col-md-12">
                    <label for="name" class="form-label">Chemical Partner <span class="text-danger">*</span></label>
                    <input value="data" name="meta[partners][itration][]" type="hidden" required>
                </div> 
                <div class="col-md">
                    <div class="form-group mb-2">
                        <input value="" name="meta[partners][icon][]" type="text" class="form-control" minlength="3" maxlength="200" placeholder="Enter Icon" required>
                    </div>
                </div> 
                <div class="col-md">
                    <div class="form-group mb-2">
                        <input value="" name="meta[partners][title][]" type="text" class="form-control" minlength="3" maxlength="200" placeholder="Enter Title" required>
                    </div>
                </div>   
                <div class="col-md">
                    <div class="form-group mb-2">
                        <textarea name="meta[partners][decription][]" class="form-control" rows="4" required></textarea>
                    </div>
                </div>                                           
                <div class="col-md-auto">
                    <button type="button" class="btn btn-icon btn-circle btn-soft-danger" data-toggle="remove-parent" data-parent=".remove-parent">
                        <i class="ti ti-x"></i>
                    </button>
                </div>               
            </div>   
        '
        data-target=".awards-target">
        <i class="ti ti-plus"></i>
        <span class="ml-2">Add More</span>
    </button>     
</div> 

<script>
$(document).on('click', '.init-text-editor', function () {
    initTextEditor();
});
</script>