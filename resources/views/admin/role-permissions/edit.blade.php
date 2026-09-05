<h1>Manage Role Permissions</h1>

<p>
    <strong>Role:</strong>
    {{ $role->name }}
</p>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

@php
    $selectedPermissions = old(
        'permissions',
        $role->permissions->pluck('id')->toArray()
    );
@endphp

<form
    action="{{ route('role-permission.update', $role->id) }}"
    method="POST"
>
    @csrf
    @method('PATCH')

    @foreach ($permissions as $permission)

        <div>
            <input
                type="checkbox"
                name="permissions[]"
                value="{{ $permission->id }}"
                {{ in_array($permission->id, $selectedPermissions) ? 'checked' : '' }}
            >

            <label>
                {{ $permission->name }}
                -
                {{ $permission->slug }}
            </label>
        </div>

    @endforeach

    <br>

    <button type="submit">
        Update Permissions
    </button>
</form>

<br>

<a href="{{ route('role-permission.index') }}">
    Back
</a>