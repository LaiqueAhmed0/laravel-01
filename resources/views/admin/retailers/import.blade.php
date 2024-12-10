@extends('layouts.layout')

@push('content')
    <!--Begin::Section-->
    <div class="row">
        <div class="offset-3 col-xl-6">
            <div class="row row-full-height">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">
                                    Add Sims
                                </h3>
                            </div>
                        </div>
                        <form class="kt-form" method="POST" enctype="multipart/form-data" action="/admin/retailers/{{$retailer->id}}/import">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <label>Range of Sims</label>
                                    <div class="row">
                                        <div wire:ignore class="col-lg-6">
                                            <select class="form-control select2" name="from">
                                                <option value="null">Please Select</option>

                                            </select>
                                        </div>
                                        <div wire:ignore class="col-lg-6">
                                            <select class ="form-control select2" name="to">
                                                <option value="null">Please Select</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center text-muted text-uppercase fw-bolder mb-5">or</div>
                                <div class="form-group">
                                    <label>Import CSV</label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input form-control-solid" id="customFile" name="file">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                <div class="text-center text-muted text-uppercase fw-bolder mb-5">or</div>
                                <div class="form-group">
                                    <label>Select Sims</label>
                                    <select class="form-control select2" name="endpoints[]" multiple="multiple">

                                    </select>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <button type="submit" onclick="" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::Section-->
@endpush

@push('scripts')

    <script>
        $('.select2').select2({
            ajax: {
                url: 'https://portal.lovemobiledata.com/admin/retailers/sims',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }
                    // Query parameters will be ?search=[term]&type=public
                    return query;
                }
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            }
        });

    </script>

@endpush