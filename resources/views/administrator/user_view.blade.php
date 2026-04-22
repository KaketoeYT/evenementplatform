<h1>Alle gebruikers</h1>

<form method="POST" action="{{ route('administrator.user.update') }}">
    @csrf
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Telefoonnummer</th>
                <th>Stad</th>
                <th>Land</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <select name="roles[{{ $user->id }}]">
                            <option value="user" @selected($user->role === 'user')>User</option>
                            <option value="admin" @selected($user->role === 'admin')>Admin</option>
                            <option value="organizer" @selected($user->role === 'organizer')>Organizer</option>
                        </select>
                    </td>
                    <td>{{ $user->phonenumber }}</td>
                    <td>{{ $user->city }}</td>
                    <td>{{ $user->country }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Geen gebruikers gevonden</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <button type="submit">Opslaan</button>
</form>
