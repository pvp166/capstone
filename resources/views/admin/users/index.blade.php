@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Users') }}</div>

                <div class="card-body">
                    <div class="card-header">{{ __('Sort Form') }}
                        <form action="{{ route('admin.users.filter')}}" method ="POST">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
    
                                <div class="col-md-6">
                                    <input id="name" name="name" type="text" class="form-control">
    
                                </div>
                                <br><br>
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
    
                                <div class="col-md-6">
                                    <input id="email" name="email" type="text" class="form-control">
    
                                </div>
                                <br><br>
                                <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>
    
                                <div class="col-md-6">
                                    <select class="form-control" id="role" name="role" required focus>
                                        <option value="all">All</option>
                                        <option value="admin">Admin</option>
                                        <option value="customer">Customer</option>
                                        <option value="cashier">Cashier</option>
                                    </select>
                                </div>
                                <br><br>
                                
                                <div class="col-md-6">
                                    <a href="../">
                                    <button class="btn btn-primary">Submit</button>
                                    </a>
                                </div>
                                
                            </div>
                        </form>
                        
                        
                    </div>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          
                            @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{$user->id}}</th>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{ implode(', ',$user->roles()->get()->pluck('name')->toArray()) }}</td>
                                <td>
                                    @can('edit-user')
                                    <a href="{{ route('admin.users.edit',$user->id )}}"><button type="button" class="btn btn-primary">Edit</button></a>
                                    <a href="{{ route('admin.users.destroy', $user->id)}}"><button type="button" class="btn btn-secondary">Delete</button></a>
                                    @endcan
                                </td>
                            </tr>
                              
                            
                            @endforeach
                            
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
