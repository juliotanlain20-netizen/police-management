{{-- resources/views/admin/user-roles/edit.blade.php --}}

<h1>Manage User Roles</h1>

<hr>

<h3>User Information</h3>

<p>
    <strong>Name:</strong>
    {{ $user->name }}
</p>

<p>
    <strong>Email:</strong>
    {{ $user->email }}
</p>

<p>
    <strong>Police Officer:</strong>

    @if ($user->officer)
        Yes
    @else
        No
    @endif
</p>

<hr>


{{-- ============================================
     USER BELUM OFFICER
     ============================================ --}}

@if (session('needs_officer'))

    <div>
        <h3>User Belum Menjadi Police Officer</h3>

        <p>
            Role Police atau Investigation Supervisor hanya dapat
            diberikan setelah user terdaftar sebagai Police Officer.
        </p>

        <a href="{{ route('user-role.edit', $user->id) }}">
            Cancel
        </a>

        <a href="{{ route('police.create', [
            'user_id' => session('officer_user_id')
        ]) }}">
            Tambah Officer
        </a>
    </div>

    <hr>

@endif


{{-- ============================================
     VALIDATION ERROR
     ============================================ --}}

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


{{-- ============================================
     FORM ROLE
     ============================================ --}}

<form action="{{ route('user-role.update', $user->id) }}" method="POST">

    @csrf
    @method('PATCH')

    <h3>Roles</h3>

    @php
        $selectedRoles = old(
            'roles',
            $user->roles->pluck('id')->toArray()
        );
    @endphp


    @foreach ($roles as $role)

        <div>

            {{-- Police Officer yang sudah terdaftar:
                 role police tidak boleh dicabut --}}
            @if ($role->name === 'police' && $user->officer)

                <input
                    type="checkbox"
                    checked
                    disabled
                >

                <label>
                    {{ $role->name }}
                    (managed by Police Management)
                </label>


            {{-- Citizen tidak relevan lagi jika user sudah officer --}}
            @elseif ($role->name === 'citizen' && $user->officer)

                <input
                    type="checkbox"
                    disabled
                >

                <label>
                    {{ $role->name }}
                    (not available for Police Officer)
                </label>


            {{-- Role biasa --}}
            @else

                <input
                    type="checkbox"
                    name="roles[]"
                    value="{{ $role->id }}"

                    {{ in_array($role->id, $selectedRoles) ? 'checked' : '' }}
                >

                <label>
                    {{ $role->name }}
                </label>

            @endif

        </div>

    @endforeach


    <br>

    <button type="submit">
        Update Roles
    </button>

</form>


<br>

<a href="{{ route('user-role.index') }}">
    Back
</a>