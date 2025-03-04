<x-app-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create User
                            <a href="{{ url('users')}}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{url('users')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="permission">Name</label>
                                <input name="name" class="form-control" type="text"/>
                                <button type="submit"></button>
                            </div>
                            <div class="mb-3">
                                <label for="permission">Email</label>
                                <input name="email" class="form-control" type="text"/>
                                <button type="submit"></button>
                            </div>
                            <div class="mb-3">
                                <label for="permission">Password</label>
                                <input name="password" class="form-control" type="text"/>
                                <button type="submit"></button>
                            </div>
                            <div class="mb-3">
                                <label for="permission">Roles</label>
                                <select name="roles[]" class="form-control" multiple>
                                    @foreach ( $roles as $role )
                                        <option value="{{$role}}">{{$role}}</option>
                                    @endforeach
                                    
                                </select> 
                                <button type="submit"></button>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</x-app-layout>