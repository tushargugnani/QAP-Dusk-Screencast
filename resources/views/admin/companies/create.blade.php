@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.company.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.companies.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.company.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($company) ? $company->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                <label for="address">{{ trans('cruds.company.fields.address') }}</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ old('address', isset($company) ? $company->address : '') }}">
                @if($errors->has('address'))
                    <em class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.address_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">{{ trans('cruds.company.fields.description') }}</label>
                <textarea id="description" name="description" class="form-control ">{{ old('description', isset($company) ? $company->description : '') }}</textarea>
                @if($errors->has('description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.description_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('city_id') ? 'has-error' : '' }}">
                <label for="city">{{ trans('cruds.company.fields.city') }}</label>
                <select name="city_id" id="city" class="form-control">
                    @foreach($cities as $id => $city)
                        <option value="{{ $id }}" {{ (isset($company) && $company->city ? $company->city->id : old('city_id')) == $id ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
                @if($errors->has('city_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('city_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('categories') ? 'has-error' : '' }}">
                <label for="categories">{{ trans('cruds.company.fields.categories') }}</label>
                <select name="categories[]" id="categories" class="form-control">
                    @foreach($categories as $id => $categories)
                        <option value="{{ $id }}" {{ (in_array($id, old('categories', [])) || isset($company) && $company->categories->contains($id)) ? 'selected' : '' }}>{{ $categories }}</option>
                    @endforeach
                </select>
                @if($errors->has('categories'))
                    <em class="invalid-feedback">
                        {{ $errors->first('categories') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.categories_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                <label for="logo">{{ trans('cruds.company.fields.logo') }}</label>
                <input type="file" name="logo" class="form-control"/>
                @if($errors->has('logo'))
                    <em class="invalid-feedback">
                        {{ $errors->first('logo') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.logo_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')

@stop