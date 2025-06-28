@extends('layouts.admin')
@section('content')
<div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-3">Basic Form</h4>
                  <form action="{{ route('admin.category.update', $category->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="category" value="{{$category->category}}" id="tb-fname" placeholder="Enter Name here">
                          <label for="tb-fname">Name</label>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="d-md-flex align-items-center">
                          <div class="ms-auto mt-3 mt-md-0">
                            <button type="submit" class="btn btn-primary hstack gap-6">
                              <i class="ti ti-send fs-4"></i>
                              Submit
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
@endsection