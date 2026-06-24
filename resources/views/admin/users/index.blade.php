<x-layout>
    <x-slot name="title">
        Manage users
    </x-slot>

    <section class="page-header">
        <div>
            <h1>Manage users</h1>
            <p>View all registered users, change roles and block or unblock accounts.</p>
        </div>
    </section>

    <section class="content-list">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Save info</th>
                    <th>Role</th>
                    <th>Blocked</th>
                    <th>Change role</th>
                    <th>Block / Unblock</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            {{ $user->id }}
                        </td>

                        <td>
                            <input type="text"
                                   name="name"
                                   form="user-info-{{ $user->id }}"
                                   class="form-control"
                                   value="{{ $user->name }}"
                                   required>
                        </td>

                        <td>
                            <input type="email"
                                   name="email"
                                   form="user-info-{{ $user->id }}"
                                   class="form-control"
                                   value="{{ $user->email }}"
                                   required>
                        </td>

                        <td>
                            <input type="text"
                                   name="phone"
                                   form="user-info-{{ $user->id }}"
                                   class="form-control"
                                   value="{{ $user->phone }}">
                        </td>

                        <td>
                            <form id="user-info-{{ $user->id }}"
                                  method="POST"
                                  action="{{ route('admin.users.updateInfo', $user) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-primary btn-sm">
                                    Save info
                                </button>
                            </form>
                        </td>

                        <td>
                                <span class="badge bg-secondary">
                                    {{ ucfirst($user->role) }}
                                </span>
                        </td>

                        <td>
                            @if ($user->is_blocked)
                                <span class="badge bg-danger">
                                        Yes
                                    </span>
                            @else
                                <span class="badge bg-success">
                                        No
                                    </span>
                            @endif
                        </td>

                        <td>
                            <form method="POST" action="{{ route('admin.users.updateRole', $user) }}">
                                @csrf
                                @method('PATCH')

                                <div class="d-flex gap-2">
                                    <select name="role" class="form-control">
                                        <option value="participant" @selected($user->role === 'user')>
                                            User
                                        </option>

                                        <option value="organizer" @selected($user->role === 'organizer')>
                                            Organizer
                                        </option>

                                        <option value="admin" @selected($user->role === 'admin')>
                                            Admin
                                        </option>
                                    </select>

                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </td>

                        <td>
                            @if (auth()->id() === $user->id)
                                <span class="text-muted">
                                        Current admin
                                    </span>
                            @else
                                <form method="POST" action="{{ route('admin.users.block', $user) }}">
                                    @csrf
                                    @method('PATCH')

                                    @if ($user->is_blocked)
                                        <button type="submit" class="btn btn-success btn-sm">
                                            Unblock
                                        </button>
                                    @else
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to block this user?')">
                                            Block
                                        </button>
                                    @endif
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            No users found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-3">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</x-layout>
