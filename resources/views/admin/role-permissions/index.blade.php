<h1>Role Permissions</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Role</th>
            <th>Permissions</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>

                <td>
                    @forelse ($role->permissions as $permission)
                        {{ $permission->slug }}

                        @if (!$loop->last)
                            ,
                        @endif
                    @empty
                        -
                    @endforelse
                </td>

                <td>
                    <a href="{{ route('role-permission.edit', $role->id) }}">
                        Manage Permissions
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>