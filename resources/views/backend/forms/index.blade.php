@extends('backend.layouts.app')

@section('content')
<div class="page-title-head d-flex align-items-center gap-2">
    <div class="flex-grow-1">
        <h4 class="fs-16 text-uppercase fw-bold mb-0">{{$moduleName}}</h4>
    </div>
</div>
@include('backend.includes.alert-message')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header border-bottom border-dashed align-items-center">
                <div class="row">
                    <div class="col-md-8">
                        <form class="row g-3 align-items-center">
                            <div class="col-md-4 d-none">
                                <select name="company" class="form-select" id="status-select">
                                    @foreach ($companyList as $index => $row)
                                        <option value="{{ $row->id }}" 
                                            @if(request()->get('company') == $row->id) selected @endif>
                                            {{ $row->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{request()->get('search')}}" placeholder="Search">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success btn-icon w-100">
                                    <i class="ti ti-search"></i>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button type="reset" class="btn btn-warning btn-icon w-100" 
                                    onclick="window.location.href = '{{ url()->current() }}';">
                                    <i class="ti ti-refresh"></i>
                                </button>
                            </div>
                        </form>                        
                    </div>
                    <div class="col-md-3 offset-md-1 text-end">
                        @if(!auth()->user()->company_id)
                        <div class="btn-group" role="group">
                            @foreach($formNames as $name)
                                <a href="{{ route('forms.by', ['form_name' => $name]) }}"
                                class="btn btn-outline-primary {{ request()->segment(3) == $name ? 'active' : '' }}">
                                    {{ ucfirst($name) }}
                                </a>
                            @endforeach
                        </div>  
                        @endif     
                    </div>
                </div>
            </div>
            <div class="card-body">
                @php
                    $preferredOrder = ['company', 'subject', 'message'];
                    $extraColumns = collect($pageData->items())
                        ->pluck('form_data')
                        ->map(function($data) {
                            // If already an array, just get keys; if JSON string, decode first
                            $arr = is_array($data) ? $data : json_decode($data, true);
                            return is_array($arr) ? array_keys($arr) : [];
                        })
                        ->flatten()
                        ->unique()
                        ->sortBy(function($col) use ($preferredOrder) {
                            return array_search($col, $preferredOrder) !== false ? array_search($col, $preferredOrder) : 999;
                        })                        
                        ->values()
                        ->toArray();
                @endphp              
                <div class="table-responsive-sm table-responsive">
                    <table class="table table-striped text-truncate">
                        <thead>
                            <tr>
                                <th class="w-10">#</th>
                                <th class="w-10">Name</th>
                                <th class="w-10">Email</th>
                                <th class="w-10">Phone</th>
                                @foreach($extraColumns as $col)
                                    <th class="w-10">{{ ucfirst(str_replace('_', ' ', $col)) }}</th>
                                @endforeach                                 
                                <th class="w-10">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pageData as $index => $row)
                            @php
                                $formData = is_array($row->form_data) ? $row->form_data : json_decode($row->form_data, true);
                            @endphp                            
                            <tr>
                                <td>{{ $index + 1 }}</td>                           
                                <td>{{ $row->name }}</td>                                                           
                                <td>{{ $row->email }}</td>    
                                <td>{{ $row->phone }}</td>
                                @foreach ($extraColumns as $col)
                                    <td>{{ $formData[$col] ?? '-' }}</td>
                                @endforeach                                  

                                <td>{{ formatDatetime($row->updated_at) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $pageData->appends(request()->input())->links() }}
                </div> <!-- end table-responsive-->
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div><!-- end row-->

<script defer>
const callbackTeams = function(response) {
    setTimeout(function() {
        location.reload();
    }, 1500);
}
</script>
@endsection