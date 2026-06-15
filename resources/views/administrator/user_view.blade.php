<x-base-layout>
    <h1>Alle gebruikers</h1>

    <form method="POST" action="{{ route('administrator.user.update') }}">
        @csrf
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Status</th>
                    <th>Phonenumber</th>
                    <th>City</th>
                    <th>Country</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td><a href="{{ route('mails.password_reset', $user->id) }}" class="btn btn-sm btn-warning">Send reset e-mail</a></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <select name="roles[{{ $user->id }}]">
                                <option value="user" @selected($user->role === 'user')>User</option>
                                <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                <option value="organizer" @selected($user->role === 'organizer')>Organizer</option>
                            </select>
                        </td>
                        <td>
                            {{ ucfirst($user->status) }}
                            <button type="button"
                                class="btn btn-sm deactivate-btn {{ $user->status === 'active' ? 'btn-danger' : 'btn-success' }}"
                                data-user-id="{{ $user->id }}" data-user-status="{{ $user->status }}">
                                {{ $user->status === 'active' ? 'Deactiveren' : 'Activeren' }}
                            </button>
                        </td>
                        <td>{{ $user->phonenumber }}</td>
                        <td>{{ $user->city }}</td>
                        <td>{{ $user->country }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <button type="submit">Save</button>
    </form>

    <script>
        document.querySelectorAll('.deactivate-btn').forEach(button => {
            button.addEventListener('click', async function() {
                if (!confirm('Weet je zeker dat je deze actie wilt uitvoeren?')) return;

                try {
                    const userId = this.dataset.userId;
                    const response = await fetch(`/administrator/user_deactivate/${userId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')
                                .value,
                            'Content-Type': 'application/json',
                        }
                    });

                    if (response.ok) {
                        window.location.reload();
                    } else {
                        alert('Er is een fout opgetreden.');
                    }
                } catch (error) {
                    alert('Er is een fout opgetreden: ' + error.message);
                }
            });
        });
    </script>
</x-base-layout>

